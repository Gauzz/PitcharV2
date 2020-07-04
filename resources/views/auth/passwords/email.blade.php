@extends('layouts.app')

@section('content')

		<div class="wrapper">
			<div class="inner">

                    <form id="forgotpasswordform" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h4>Forgotten Your Password?</h4>
                    <h5>Don't worry we'll send you a meesage<br>to help you reset your password</h5>
					<div class="form-wrapper">
						<label for="" class="label-input">EMAIL ADDRESS</label>
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
					</div>
                    <a  href="{{ route('login') }}" class="btn back" id="backtologin">Back</a>
					<button type="submit" class="btn forgotpasswordbutton">Continue</button> 
                        
                                             @error('email')
                        <div class=container4>
                            <span class="error" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </span>
                        </div>
                     @enderror
                        
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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
		<script>
@endsection
