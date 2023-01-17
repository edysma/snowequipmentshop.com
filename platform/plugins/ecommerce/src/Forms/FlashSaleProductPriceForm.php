<?php

namespace Botble\Ecommerce\Forms;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\FlashSaleRequest;
use Botble\Ecommerce\Forms\Fields\CategoryMultiField;
use Botble\Ecommerce\Models\CustomerCategory;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\FlashSaleProductPrice;
use Botble\Location\Models\Country;
use Botble\Support\Http\Requests\Request;
use Carbon\Carbon;
use CustomerCategoryHelper;

class FlashSaleProductPriceForm extends FormAbstract
{
    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {

        $selectedCategories = [];
        foreach (CustomerCategory::all() as $key => $value) {
            $selectedCategories[$value->id] = $value->name;
        }

        
        
        Assets::addScriptsDirectly('vendor/core/plugins/ecommerce/js/flash-sale.js')
            ->addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScripts([
                'blockui',
                'input-mask',
            ]);

        $this
            ->setupModel(new FlashSaleProductPrice())
            ->setValidatorClass(FlashSaleRequest::class)
            // ->addCustomField('categoryMulti', CategoryMultiField::class)

            ->withCustomFields()
            
            ->add('discount', 'number', [
                'label'      => 'Discount',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])

            
            
            ->add('categorie', 'customSelect', [
                'label'      => 'Categorie',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => $selectedCategories
            ])

            ->add('id', 'hidden', [
                'label'      => 'Id',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'value' => $this->getModel()->id
                ],
            ])

            ->setBreakFieldPoint('categorie');
    }
}
