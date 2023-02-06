@extends('email.layout')

@section('content')
    <div class="content">
        <div class="content-header content-header--blue">
        <h4>Password  Reset </h4>
        </div>
        <div class="content-body">
            <p>Hi</p> 
            <div class="text-center">
            You can Reset Your password here:
            <a href="{{ $app_url.'/'.'reset-password'.'/'. $token }}">click here</a> To Reset Password
            </div>

            <div class="hr-line"></div>

            <p>@lang('view_pages.commitment_text').</p>

            <ul>

            </ul>
        </div>
    </div>
@endsection