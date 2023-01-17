<?php

namespace Botble\Contact\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Contact\Events\SentContactEvent;
use Botble\Contact\Http\Requests\ContactRequest;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use EmailHandler;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\DB;
class PublicController extends Controller
{
    /**
     * @var ContactInterface
     */
    protected $contactRepository;

    /**
     * @param ContactInterface $contactRepository
     */
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param ContactRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function postSendContact(ContactRequest $request, BaseHttpResponse $response)
    {
        
        $blacklistDomains = setting('blacklist_email_domains');
        $lang=$request->input('lang');
      
        if ($blacklistDomains) {
            $emailDomain = Str::after(strtolower($request->input('email')), '@');

            $blacklistDomains = collect(json_decode($blacklistDomains, true))->pluck('value')->all();

            if (in_array($emailDomain, $blacklistDomains)) {
                return $response
                    ->setError()
                    ->setMessage(__('Your email is in blacklist. Please use another email address.'));
            }
        }

        $blacklistWords = trim(setting('blacklist_keywords', ''));

        if ($blacklistWords) {
            $content = strtolower($request->input('content'));

            $badWords = collect(json_decode($blacklistWords, true))
                ->filter(function ($item) use ($content) {
                    $matches = [];
                    $pattern = '/\b' . $item['value'] . '\b/iu';

                    return preg_match($pattern, $content, $matches, PREG_UNMATCHED_AS_NULL);
                })
                ->pluck('value')
                ->all();

            if (count($badWords)) {
                return $response
                    ->setError()
                    ->setMessage(__('Your message contains blacklist words: ":words".', ['words' => implode(', ', $badWords)]));
            }
        }

        try {
                
            if (count(\Botble\Location\Models\Country::all()) > 0) {
                $recommendedCountryCode = '';
                if (!session('country')) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://ipinfo.io/',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);

                    if ($response) {
                        $response = json_decode($response, true);
                        // dd($response);
                        if (isset($response['country'])) {
                            $recommendedCountryCode = $response['country'];
                        }
                        foreach (\Botble\Location\Models\Country::all() as $country) {
                            if (strtolower($country->code) == strtolower($recommendedCountryCode)) {
                                session(['country' => $country->id]);
                                session(['countryCode' => $country->code]);
                            }
                        }

                        // dd(session('country'));
                    }
                }
                // echo $response;
                // dd(session()->all()['countryCode']);

                $result =  DB::table('countries_translations')->where('lang_code', 'like', '%' . strtolower(session()->all()['countryCode']) . '_%')->where('countries_id', session(['country']))->first();
                if ($result) {

                    $countryName = $result->name;
                } else {
                    $result =  DB::table('countries_translations')->where('lang_code', 'like', '%' . strtolower(session()->all()['countryCode']) . '_%')->where('countries_id', session(['country']))->first();

                    if ($result) {
                    } else {
                        $countryName = get_application_country()->name;
                    }
                }
                // dd(strtolower(session()->all()['countryCode']));
            }
            // dd($request->input()->all());
            $contact = $this->contactRepository->getModel();


            $contact->fill($request->input());
            $this->contactRepository->createOrUpdate($contact);

            event(new SentContactEvent($contact));

            $args = [];

            if ($contact->name && $contact->email) {
                $args = ['replyTo' => [$contact->name => $contact->email]];
            }
      
            EmailHandler::setModule(CONTACT_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'contact_country'    => $_POST['country'] ?? 'N/A',
                    'contact_lang'    => $_POST['lang'] ?? 'N/A',
                    'from_url'    => $_POST['fromurl'] ?? 'N/A',
                    'contact_name'    => $contact->name ?? 'N/A',
                    'contact_subject' => $contact->subject ?? 'N/A',
                    'contact_email'   => $contact->email ?? 'N/A',
                    'contact_phone'   => $contact->phone ?? 'N/A',
                    'contact_address' => $contact->address ?? 'N/A',
                    'contact_content' => $contact->content ?? 'N/A',
                ])
                ->sendUsingTemplate($lang.'_notice', null, $args);

            return $response->setMessage(__('Send message successfully!'));
        } catch (Exception $exception) {
            info($exception->getMessage());
            return $response
                ->setError()
                ->setMessage(__("Can't send message on this time, please try again later!"));
        }
    }
}
