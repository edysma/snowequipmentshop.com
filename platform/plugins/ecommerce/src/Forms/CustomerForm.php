<?php

namespace Botble\Ecommerce\Forms;

use BaseHelper;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Enums\CustomerStatusEnum;
use Botble\Ecommerce\Http\Requests\CustomerCreateRequest;
use Botble\Ecommerce\Forms\Fields\CategoryMultiField;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\TagField;

use Botble\Ecommerce\Models\Customer;
use CustomerCategoryHelper;

class CustomerForm extends FormAbstract
{
    /**
     * @var string
     */
    protected $template = 'core/base::forms.form-tabs';

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $selectedCategories = [];

        if ($this->getModel()) {
            $productId = $this->getModel()->id;
            // dd($this->getModel()->categories());
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();

            // dd($selectedCategories);
           
        }

        $this
            ->setupModel(new Customer())
            ->setValidatorClass(CustomerCreateRequest::class
            )
            ->addCustomField('categoryMulti', CategoryMultiField::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('email', 'text', [
                'label'      => trans('plugins/ecommerce::customer.email'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::customer.email_placeholder'),
                    'data-counter' => 60,
                ],
            ])
            ->add('phone', 'text', [
                'label'      => trans('plugins/ecommerce::customer.phone'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::customer.phone_placeholder'),
                    'data-counter' => 20,
                ],
            ])
            ->add('dob', 'date', [
                'label'      => trans('plugins/ecommerce::customer.dob'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'data-date-format' => config('core.base.general.date_format.js.date'),
                ],
                'default_value' => BaseHelper::formatDate(now()),
            ])
            ->add('is_change_password', 'checkbox', [
                'label'      => trans('plugins/ecommerce::customer.change_password'),
                'label_attr' => ['class' => 'control-label'],
                'value'      => 1,
            ])
            ->add('password', 'password', [
                'label'      => trans('plugins/ecommerce::customer.password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label'      => trans('plugins/ecommerce::customer.password_confirmation'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => CustomerStatusEnum::labels(),
            ])
            ->add('avatar', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('categories[]', 'categoryMulti', [
                'label'      => trans('plugins/ecommerce::customer.form.categories'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => CustomerCategoryHelper::getAllCustomerCategoriesWithChildren(),
                'value'      => old('categories' , $selectedCategories),
            ])
            ->setBreakFieldPoint('status');
    }
}
