@extends('layouts.app')

@section('content')
<div class="wrapper">
			<div class="inner">
					<form method="POST" action="{{ route('login') }}" id= "loginform">
                        @csrf
					<h3>Welcome Back</h3>
                    <h5>Create Augmented Reality<br>Experience in no time</h5>
					<div class="form-wrapper">
						<label for="" class="label-input">EMAIL ADDRESS</label>
						                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
					</div>
					<div class="form-wrapper">
						<label for="" class="label-input">PASSWORD</label>
				 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>
					<div id ="forgotpassworddiv" style="float: right;">
					@if (Route::has('password.request'))
                                    <a style="color:#B0BAC9; font-size: 11px; "  href="{{ route('password.request') }}">
                                        {{ __('FORGOT PASSWORD?') }}
                                    </a>
                                @endif
					<br>
                        <button type="submit" class="btn login">Login</button>
					
                                                   
					</div>
					<br>
                    
                    <a href="{{ route('register') }}" class="btn back" id="backtoregister">Back</a>
                    
                     @error('email')
                        <div class=container4>
                            <span class="error" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </span>
                        </div>
                     @enderror
                        
                    <h6>By creating an account you agree to our<br><a><u>Terms And Conditions</u></a></h6>
				</form>
                
                <div class="image-holder">
					<img src="{{ URL::asset('assets/images/city.jpg') }}">
				</div>
			</div>
		</div>

		<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/main.js') }}"></script>
		<link rel='stylesheet' type='text/css' href='assets/css/profile.css' />


@endsection
