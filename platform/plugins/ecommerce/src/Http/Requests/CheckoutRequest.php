<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Support\Http\Requests\Request;
use Cart;
use EcommerceHelper;
use Illuminate\Validation\Rule;

class CheckoutRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     */
    public function rules()
    {
        $rules = [
            'payment_method'  => 'required|' . Rule::in(PaymentMethodEnum::values()),
            'shipping_method' => 'required|' . Rule::in(ShippingMethodEnum::values()),
            'amount'          => 'required|min:0',
            'privacyPolicy'   => 'required|accepted:1'
            
        ];
        if ($this->has('agree_terms_and_policy')) {
            $rules['agree_terms_and_policy'] = 'accepted:1';
        }

        $rules['address.address_id'] = 'required_without:address.name';
        if (!$this->has('address.address_id') || $this->input('address.address_id') === 'new') {
            foreach (EcommerceHelper::getCustomerAddressValidationRules() as $key => $item) {
                $rules['address.' . $key] = $item;
            }
        }

        if ($this->input('create_account') == 1) {
            $rules['password'] = 'required|min:6';
            $rules['password_confirmation'] = 'required|same:password';
            $rules['address.email'] = 'required|max:60|min:6|email|unique:ec_customers,email';
            $rules['address.name'] = 'required|min:3|max:120';
        }

        $products = Cart::instance('cart')->products();
        if (!EcommerceHelper::isAvailableShipping($products)) {
            unset($rules['shipping_method']);
        }

        return apply_filters(PROCESS_CHECKOUT_RULES_REQUEST_ECOMMERCE, $rules);
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = [
            'address.name.required'    => trans('plugins/ecommerce::order.address_name_required'),
            'address.partita_iva.required'    => trans('plugins/ecommerce::order.address_partita_iva_required'),
            'address.codice_fiscale.required'    => trans('plugins/ecommerce::order.address_codice_fiscale_required'),
            'address.codice_sdi.required'    => trans('plugins/ecommerce::order.address_codice_sdi_required'),
            'address.phone.required'   => trans('plugins/ecommerce::order.address_phone_required'),
            'address.email.required'   => trans('plugins/ecommerce::order.address_email_required'),
            'address.email.unique'     => trans('plugins/ecommerce::order.address_email_unique'),
            'address.state.required'   => trans('plugins/ecommerce::order.address_state_required'),
            'address.city.required'    => trans('plugins/ecommerce::order.address_city_required'),
            'address.country.required' => trans('plugins/ecommerce::order.address_country_required'),
            'address.address.required' => trans('plugins/ecommerce::order.address_address_required'),
            'address.agree_terms_and_policy.required' => trans('plugins/ecommerce::order.agree_terms_and_policy'),
            'address.privacyPolicy.required' => trans('plugins/ecommerce::order.privacyPolicy'),
        ];

        $messages = apply_filters(PROCESS_CHECKOUT_MESSAGES_REQUEST_ECOMMERCE, $messages);

        return array_merge(parent::messages(), $messages);
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [
            'address.name'    => __('Name'),
            'address.partita_iva'    => __('partita_iva'),
            'address.codice_fiscale'    => __('codice_fiscale'),
            'address.codice_sdi'    => __('codice_sdi'),
            'address.phone'   => __('Phone'),
            'address.email'   => __('Email'),
            'address.state'   => __('State'),
            'address.city'    => __('City'),
            'address.country' => __('Country'),
            'address.address' => __('Address'),
            'agree_terms_and_policy' => __('Term and Policy'),
        ];

        return array_merge(parent::attributes(), $attributes);
    }
}
