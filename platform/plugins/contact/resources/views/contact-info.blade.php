@if ($contact)
<p>{{ __('Country') }}: <i>{{ $contact->country }}</i></p>
    <p>{{ __('Language') }}: <i>{{ $contact->lang }}</i></p>
    <p>{{ __('Url') }}: <i>{{ $contact->fromurl }}</i></p>

    <p>{{ trans('plugins/contact::contact.tables.full_name') }}: <i>{{ $contact->name }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.email') }}: <i><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></i></p>
    <p>{{ trans('plugins/contact::contact.tables.phone') }}: <i>@if ($contact->phone) <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a> @else N/A @endif</i></p>
    <p>{{ trans('plugins/contact::contact.tables.address') }}: <i>{{ $contact->address ?: 'N/A' }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.subject') }}: <i>{{ $contact->subject ?: 'N/A' }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.content') }}:</p>
    <pre class="message-content">{{ $contact->content ?: '...' }}</pre>
@endif
