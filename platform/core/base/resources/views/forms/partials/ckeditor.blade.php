@php
    Assets::addScriptsDirectly(config('core.base.general.editor.ckeditor.js'))
        ->addScriptsDirectly('vendor/core/core/base/js/editor.js');

    $attributes['class'] = Arr::get($attributes, 'class', '') . ' form-control editor-ckeditor';
    $attributes['id'] = Arr::get($attributes, 'id', $name);
    $attributes['rows'] = Arr::get($attributes, 'rows', 4);
    //$substr=substr($value,0,1000).' <a href="javascript:viod(0)"> ....Read more</a>';
@endphp

{!! Form::textarea($name, BaseHelper::cleanEditorContent($value), $attributes) !!}
