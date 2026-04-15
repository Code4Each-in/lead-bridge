@extends('emails.layout_email')

@section('content')

<p>Hello {{ $user->name }},</p>

<p>
    A new <b>{{ $type }}</b> was added to Lead:
    <b>#{{ $lead->id }}</b>
</p>

@if(!empty($body))
<p>
    {{ $body }}
</p>
@endif

<a href="{{ url('/leads/' . $lead->id) }}">
    👉 View Lead
</a>

@endsection
