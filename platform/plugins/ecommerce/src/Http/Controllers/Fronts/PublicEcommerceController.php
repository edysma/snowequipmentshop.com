<?php

namespace Botble\Ecommerce\Http\Controllers\Fronts;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use Botble\Location\Models\Country;
use Illuminate\Http\Request;

class PublicEcommerceController
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * PublicEcommerceController constructor.
     * @param CurrencyInterface $currencyRepository
     */
    public function __construct(CurrencyInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @param string $title
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function changeCurrency(Request $request, BaseHttpResponse $response, $title = null)
    {
        if (empty($title)) {
            $title = $request->input('currency');
        }


        if (!$title) {
            return $response;
        }

        $currency = $this->currencyRepository->getFirstBy(['title' => $title]);


        if ($currency) {
            cms_currency()->setApplicationCurrency($currency);
        }

        return $response;
    }

    public function changeCountry(Request $request, BaseHttpResponse $response, $id = null)
    {
        
        if (empty($id)) {
            $id = $request->input('id');
        }

        if (!$id) {
            return redirect('/');
        }


        $country = Country::find($id);
       
        if ($country) {
           cms_currency()->setApplicationCountry($country);
        }
        if($request->request_from != null || $request->request_from != '' ){
            return redirect()->to($request->request_from);
        }else{
            return redirect('/');
        }

    }
}
