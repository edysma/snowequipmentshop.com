<?php

namespace Botble\Ecommerce\Http\Controllers;

use Assets;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Forms\CustomerCategoryForm;
use Botble\Ecommerce\Http\Requests\CustomerCategoryRequest;
use Botble\Ecommerce\Http\Resources\CustomerCategoryResource;
use Botble\Ecommerce\Models\CustomerCategory;
use Botble\Ecommerce\Repositories\Interfaces\CustomerCategoryInterface;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CustomerCategoryController extends BaseController
{
   
    protected $customerCategoryRepository;

   
    public function __construct(CustomerCategoryInterface $customerCategoryRepository)
    {
        $this->customerCategoryRepository = $customerCategoryRepository;
    }

    /**
     * @return BaseHttpResponse|Factory|View|string
     * @throws Throwable
     */
    public function index(FormBuilder $formBuilder, Request $request, BaseHttpResponse $response)
    {
        page_title()->setTitle(trans('plugins/ecommerce::customer-categories.name'));

        $categories = $this->customerCategoryRepository->getCustomerCategories([], ['slugable'], ['customers']);

        if ($request->ajax()) {
            $data = view('core/base::forms.partials.tree-categories', $this->getOptions(compact('categories')))
                ->render();

            return $response->setData($data);
        }

        Assets::addStylesDirectly(['vendor/core/core/base/css/tree-category.css'])
            ->addScriptsDirectly(['vendor/core/core/base/js/tree-category.js']);

        $form = $formBuilder->create(CustomerCategoryForm::class, ['template' => 'core/base::forms.form-tree-category']);
        $form = $this->setFormOptions($form, null, compact('categories'));

        return $form->renderForm();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return BaseHttpResponse|string
     */
    public function create(FormBuilder $formBuilder, Request $request, BaseHttpResponse $response)
    {
        page_title()->setTitle(trans('plugins/ecommerce::customer-categories.create'));

        if ($request->ajax()) {
            return $response->setData($this->getForm());
        }

        return $formBuilder->create(CustomerCategoryForm::class)->renderForm();
    }

 

    public function store(CustomerCategoryRequest $request, BaseHttpResponse $response)
    {
        $customerCategory = $this->customerCategoryRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(CUSTOMER_CATEGORY_MODULE_SCREEN_NAME, $request, $customerCategory));

        if ($request->ajax()) {
            $customerCategory = $this->customerCategoryRepository->findOrFail($customerCategory->id);

            if ($request->input('submit') == 'save') {
                $form = $this->getForm();
            } else {
                $form = $this->getForm($customerCategory);
            }

            $response->setData([
                'model' => $customerCategory,
                'form'  => $form
            ]);
        }

        return $response
                ->setPreviousUrl(route('customer-categories.index'))
                ->setNextUrl(route('customer-categories.edit', $customerCategory->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return BaseHttpResponse|string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request, BaseHttpResponse $response)
    {
        $customerCategory = $this->customerCategoryRepository->findOrFail($id);

        if ($request->ajax()) {
            return $response->setData($this->getForm($customerCategory));
        }

        page_title()->setTitle(trans('plugins/ecommerce::customer-categories.edit') . ' "' . $customerCategory->name . '"');

        return $formBuilder->create(CustomerCategoryForm::class, ['model' => $customerCategory])->renderForm();
    }

   
    public function update($id, CustomerCategoryRequest $request, BaseHttpResponse $response)
    {
        $customerCategory = $this->customerCategoryRepository->findOrFail($id);
        $customerCategory->fill($request->input());

        $this->customerCategoryRepository->createOrUpdate($customerCategory);
        event(new UpdatedContentEvent(CUSTOMER_CATEGORY_MODULE_SCREEN_NAME, $request, $customerCategory));

        if ($request->ajax()) {
            $customerCategory = $this->customerCategoryRepository->findOrFail($id);

            if ($request->input('submit') == 'save') {
                $form = $this->getForm();
            } else {
                $form = $this->getForm($customerCategory);
            }
            $response->setData([
                'model' => $customerCategory,
                'form'  => $form
            ]);
        }

        return $response
                ->setPreviousUrl(route('customer-categories.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));
    }

    
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $customerCategory = $this->customerCategoryRepository->findOrFail($id);

            $this->customerCategoryRepository->delete($customerCategory);
            event(new DeletedContentEvent(CUSTOMER_CATEGORY_MODULE_SCREEN_NAME, $request, $customerCategory));
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
            $customerCategory = $this->customerCategoryRepository->findOrFail($id);
            $this->customerCategoryRepository->delete($customerCategory);
            event(new DeletedContentEvent(CUSTOMER_CATEGORY_MODULE_SCREEN_NAME, $request, $customerCategory));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

   
    private function getForm($model = null)
    {
        $options = ['template' => 'core/base::forms.form-no-wrap'];
        if ($model) {
            $options['model'] = $model;
        }

        $form = app(FormBuilder::class)->create(CustomerCategoryForm::class, $options);

        $form = $this->setFormOptions($form, $model);

        return $form->renderForm();
    }


    private function setFormOptions($form, $model = null, $options = [])
    {
        if (!$model) {
            $form->setUrl(route('customer-categories.create'));
        }

        if (!$model) {
            $class = $form->getFormOption('class');
            $form->setFormOption('class', $class . ' d-none');
        }

        $form->setFormOptions($this->getOptions($options));

        return $form;
    }

    /**
     * @param array $options
     * @return array
     */
    private function getOptions($options = [])
    {
        return array_merge([
            'canCreate'   => true,
            'canEdit'     => true,
            'canDelete'   => true,
            'createRoute' => 'customer-categories.create',
            'editRoute'   => 'customer-categories.edit',
            'deleteRoute' => 'customer-categories.destroy',
        ], $options);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getSearch(Request $request, BaseHttpResponse $response)
    {
        $term = $request->input('search');

        $categories = $this->customerCategoryRepository
                ->select(['id', 'name'])
                ->where('name', 'LIKE', '%' . $term . '%')
                ->paginate(10);

        $data = CustomerCategoryResource::collection($categories);

        return $response->setData($data)->toApiResponse();
    }
}
