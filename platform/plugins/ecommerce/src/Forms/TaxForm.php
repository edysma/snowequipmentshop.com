<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\TaxRequest;
use Botble\Ecommerce\Models\Tax;
use Botble\Location\Models\Country;

class TaxForm extends FormAbstract
{
    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Tax())
            ->setValidatorClass(TaxRequest::class)
            ->withCustomFields()
            ->add('title', 'text', [
                'label'      => trans('plugins/ecommerce::tax.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::tax.title'),
                    'data-counter' => 120,
                ],
            ])
            ->add('percentage', 'number', [
                'label'      => trans('plugins/ecommerce::tax.percentage'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::tax.percentage'),
                    'data-counter' => 120,
                ],
            ])
            ->add('priority', 'number', [
                'label'      => trans('plugins/ecommerce::tax.priority'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::tax.priority'),
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->addMetaBoxes([
                'variations1' => [
                    'title'          => 'Discount',
                    'content'        => view('plugins/ecommerce::tax.country-tax', [
                        'flashSale' => $this->getModel(),
                        'country_taxes'        =>  $this->getModel()->id ? $this->getModel()->country_tax : collect([]),
                        'countries'         => Country::all(),

                    ])->render(),
                    'before_wrapper' => '<div id="main-manage-product-type">',
                    'after_wrapper'  => '</div>',
                    'priority'       => 5,
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
