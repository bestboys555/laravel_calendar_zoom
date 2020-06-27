@extends('indexmain')

@section('pageTitle'){{ __('Verify Your Email Address') }}@endsection

@section('content')
<div class="inner-container pad-top-lg pad-bot-lg  bg-white">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="title-primary">{{ __('Verify Your Email Address') }}</h1>
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('csspage')

@endsection
@section('scriptpage')

@endsection
