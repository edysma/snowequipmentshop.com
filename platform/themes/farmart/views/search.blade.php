@php
    Theme::layout('full-width')
@endphp


    @include(Theme::getThemeNamespace() . '::views.loop', compact('posts'))

