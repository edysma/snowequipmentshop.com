<?php

namespace Botble\Ecommerce\Forms;

use App\Models\TaxCountry;
use Assets;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\FlashSaleRequest;
use Botble\Location\Models\Country;


class CountryTaxForm extends FormAbstract
{
    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {

        $selectedcountry = [];
        foreach (Country::all() as $key => $value) {
            $selectedcountry[$value->id] = $value->name;
        }
        $taxId = null;
        if ($this->getModel()) 
            $taxId = $this->getModel()->tax_id;

        
        Assets::addScriptsDirectly('vendor/core/plugins/ecommerce/js/flash-sale.js')
            ->addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScripts([
                'blockui',
                'input-mask',
            ]);

        $this
            ->setupModel(new TaxCountry())
            // ->setValidatorClass(FlashSaleRequest::class)
            // ->addCustomField('categoryMulti', CategoryMultiField::class)

            ->withCustomFields()
            
            ->add('tax', 'number', [
                'label'      => 'Tax %',
                'label_attr' => ['class' => 'control-label required'],
                'value' => $taxId ? $this->getModel()->tax_percentage: '',
                'attr'       => [
                    'placeholder'  => '%',
                    'data-counter' => 120,
                ],
            ])

            
            
            ->add('country', 'customSelect', [
                'label'      => 'Country',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => $selectedcountry,
                'selected' => $taxId ? $this->getModel()->country_id: ''
            ])

            ->add('id', 'hidden', [
                'label'      => 'Id',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                ],
                'value' => $this->getModel()->tax_id
            ])
            ->add('country_id', 'hidden', [
                'label'      => 'Id',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                ],
                'value' => $this->getModel()->country_id
            ])

            ->setBreakFieldPoint('country');
    }
}
