@extends('emails.layout_email')

@section('content')

<h2 style="color:#0d2c6c;">Welcome to {{ config('app.name') }} 🎉</h2>

<h2>Welcome {{ $user->name }}</h2>

<p><strong>Email:</strong> {{ $user->email }}</p>

<p><strong>Role:</strong> {{ $user->role->name ?? 'User' }}</p>

<p><strong>Password:</strong> {{ $password }}</p>

<p><strong>Agency:</strong> {{ $user->agency->agency_name ?? 'N/A' }}</p>

<p><strong>City:</strong> {{ $user->city ?? 'N/A' }}</p>

<hr>

<a href="{{ $loginUrl }}"
   style="padding:10px 15px;background:#0d2c6c;color:#fff;text-decoration:none;">
   Login Now
</a>

<p>Thanks,<br><strong>{{ config('app.name') }} Team</strong></p>

@endsection
