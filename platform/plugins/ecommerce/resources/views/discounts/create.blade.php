@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    {!! Form::open() !!}
        <div id="main-discount">
            <div class="max-width-1200">
                <discount-component currency="{{ get_application_currency()->symbol }}"></discount-component>
            </div>
			<div class="max-width-1200">
				<div class="flexbox-grid no-pd-none">
					<div class="flexbox-content flexbox-center">
						<div class="wrapper-content">
							<div class="pd-all-20 border-top-color">
								<label class="title-product-main text-no-bold block-display">Countries Limited to.</label> 
								<div class="form-inline form-group discount-input mt15 mb0 ws-nm">
									<span class="lb-dis"><span>Mention Country Name</span></span> 
									<div class="inline width20-rsp-768 mb5">
										<div class="next-input--stylized"><input type="text" name="countries" autocomplete="off"  class="next-input next-input--invisible"> <span class="next-input-add-on next-input__add-on--after">Countries</span></div>
									</div>
									<span class="lb-dis"> separated by commas</span> 
									<div style="margin: 10px 0px; display: none;"><span class="lb-dis">  Number of products required to apply: </span> <input type="text" name="product_quantity" id="product-quantity" class="form-control width-100-px p-none-r"></div>
								</div>
								<!----> <!----> <!---->
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    {!! Form::close() !!}
@stop

@push('header')
    <script>
        'use strict';

        window.trans = window.trans || {};

        window.trans.discount = JSON.parse('{!! addslashes(json_encode(trans('plugins/ecommerce::discount'))) !!}');

        $(document).ready(function () {
            $(document).on('click', 'body', function (e) {
                let container = $('.box-search-advance');

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.find('.panel').addClass('hidden');
                }
            });
        });
    </script>
    @php
        Assets::addScripts(['form-validation']);
    @endphp
    {!! JsValidator::formRequest(\Botble\Ecommerce\Http\Requests\DiscountRequest::class) !!}
@endpush
