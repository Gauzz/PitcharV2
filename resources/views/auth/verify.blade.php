@extends('layouts.app')

@section('content')
	<div class="wrapper">
			<div class="inner">
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                    <h3 style="margin-top: 100px;">We're Almost There!</h3>
					<h5>{{ __('please check your email for a verification link.') }}<br>
                        {{ __('If you did not receive the email') }}</h5>
                        <button style="margin-top: -10px; margin-left: 15%;" type="submit" class="btn resend">Resend Verification Mail</button>
                                            @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    </form>
                <div class="image-holder">
					<img src="{{ URL::asset('assets/images/city.jpg') }}">
				</div>
                </div>
            </div>
		<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@endsection
