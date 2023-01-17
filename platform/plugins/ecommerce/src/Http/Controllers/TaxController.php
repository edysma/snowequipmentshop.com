<?php

namespace Botble\Ecommerce\Http\Controllers;

use App\Models\TaxCountry;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Forms\CountryTaxForm;
use Botble\Ecommerce\Forms\TaxForm;
use Botble\Ecommerce\Http\Requests\TaxRequest;
use Botble\Ecommerce\Models\Tax;
use Botble\Ecommerce\Repositories\Interfaces\TaxInterface;
use Botble\Ecommerce\Tables\TaxTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class TaxController extends BaseController
{
    /**
     * @var TaxInterface
     */
    protected $taxRepository;

    /**
     * @param TaxInterface $taxRepository
     */
    public function __construct(TaxInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @param TaxTable $dataTable
     * @return Factory|View
     *
     * @throws Throwable
     */
    public function index(TaxTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/ecommerce::tax.name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::tax.create'));

        return $formBuilder->create(TaxForm::class)->renderForm();
    }

    public function addCountryTax(FormBuilder $formBuilder , Request $request){
        page_title()->setTitle(trans('plugins/ecommerce::flash-sale.create'));
        $tax = null;

        if((isset($request->id) && $request->id != '') ){
            $tax = Tax::find(trim($request->id));
        }

        return $formBuilder->create(CountryTaxForm::class , ['model' => $tax] , ['id' => $request->id])->renderForm();
    }

    public function editCountryTax(Request $request ,FormBuilder $formBuilder ,$id){
        $taxCountry = null;
        if((isset($request->country_id) && $request->country_id != '') && (isset($request->tax_id) && $request->tax_id != '') )
            $taxCountry = TaxCountry::where('country_id' , $request->country_id)->where('tax_id' , $request->tax_id )->first();

        event(new BeforeEditContentEvent($request, $taxCountry));
        page_title()->setTitle(trans('plugins/ecommerce::tax.edit'));
        return $formBuilder->create(CountryTaxForm::class ,['model' => $taxCountry])->renderForm();
    }

    public function deleteCountryTax(Request $request ,BaseHttpResponse $response ,$id){
        $result = null;
        if((isset($request->country_id) && $request->country_id != '') && (isset($request->tax_id) && $request->tax_id != '') )
            $result = TaxCountry::where('country_id' , $request->country_id)->where('tax_id' , $request->tax_id )->delete();


        if($result){
        return $response->setPreviousUrl(route('tax.index'))
                ->setMessage(trans('core/base::notices.delete_success_message'));
        }else{

        }
    }

    public  function saveCountryTax(Request $request , BaseHttpResponse $response)
    {
                $data = [
                    'tax_id' => $request->id ,
                    'country_id' => $request->country,
                    'tax_percentage' => $request->tax
                ];
               $result =  DB::table('tax_country')->insert($data);
               if($result){
                return $response->setPreviousUrl(route('tax.index'))
                        ->setMessage(trans('core/base::notices.create_success_message'));
               }
          
    }

    public  function updateCountryTax(Request $request , BaseHttpResponse $response)
    {
            
            $data = [
                'tax_percentage' => $request->tax,
            ];
            $result =  DB::table('tax_country')->where('tax_id' ,$request->id )->where('country_id' ,$request->country_id)->update($data);
            if($result){
            return $response->setPreviousUrl(route('tax.index'))
                    ->setMessage(trans('core/base::notices.update_success_message'));
            }else{
                return $response->setPreviousUrl(route('tax.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));
            }
    }


    /**
     * @param TaxRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(TaxRequest $request, BaseHttpResponse $response)
    {
        $tax = $this->taxRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

        return $response
            ->setPreviousUrl(route('tax.index'))
            ->setNextUrl(route('tax.edit', $tax->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $tax = $this->taxRepository->findOrFail($id);

        page_title()->setTitle(trans('plugins/ecommerce::tax.edit', ['title' => $tax->title]));

        return $formBuilder->create(TaxForm::class, ['model' => $tax])->renderForm();
    }

    /**
     * @param int $id
     * @param TaxRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, TaxRequest $request, BaseHttpResponse $response)
    {
        $tax = $this->taxRepository->createOrUpdate($request->input(), ['id' => $id]);

        event(new UpdatedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

        return $response
            ->setPreviousUrl(route('tax.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $tax = $this->taxRepository->findOrFail($id);
            $this->taxRepository->delete($tax);
            event(new DeletedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $tax = $this->taxRepository->findOrFail($id);
            $this->taxRepository->delete($tax);
            event(new DeletedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
