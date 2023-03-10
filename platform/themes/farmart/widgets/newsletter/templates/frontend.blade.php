<div class="col-xl-3">
    @if (is_plugin_active('newsletter'))
        <div class="widget mb-5">
            <h4 class="fw-bold widget-title mb-4">{!! BaseHelper::clean($config['title']) !!}</h4>
            <div class="widget-description pb-3 mb-4">{!! BaseHelper::clean($config['subtitle']) !!}</div>
            <div class="form-widget">
                <form class="subscribe-form" method="POST" action="{{ route('public.newsletter.subscribe') }}">
                    @csrf
                    <div class="form-fields">
                        <div class="input-group">
                            <div class="input-group-text">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-mail" xlink:href="#svg-icon-mail"></use>
                                </svg>
                            </span>
                            </div>
                            <input class="form-control shadow-none" name="email" type="email" placeholder="{{ __('Your email...') }}">
                            <button class="btn btn-outline-secondary" type="submit">{{ __('Subscribe') }}</button>
                        </div>
                        <div class="col-12">
                <div class="mb-3">
                    <input class=" py-3 px-3" type="checkbox"  name="privacyPolicy" value="1" required>
<?php 

$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

?>
                    <label class=" " for="checkbox">{{ __('By accepting this you agree to') }}<a href="/{{ app()->getLocale() }}/privacy">{{ __('Privacy and Policy*') }}</a></label>
                </div>
            </div>
                        @if (setting('enable_captcha') && is_plugin_active('captcha'))
                            <div class="form-group">
                                {!! Captcha::display() !!}
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
