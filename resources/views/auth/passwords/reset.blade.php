@extends('layouts.app')

@section('content')
<div class="wrapper">
			<div class="inner">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <h3 style="margin-bottom: 20px;">Reset Password</h3>
                        <input type="hidden" name="token" value="{{ $token }}">

					<div class="form-wrapper">
						<label for="" class="label-input">EMAIL ADDRESS</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>

                       <div class="form-wrapper">
						<label for="" class="label-input">PASSWORD</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>

                       <div class="form-wrapper">
						<label for="" class="label-input">CONFIRM PASSWORD</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                     
                        
                        
                     @error('password')
                        <div class=container4>
                            <span class="error" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </span>
                        </div>
                     @enderror
                     @error('email')
                        <div class=container4>
                            <span class="error" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </span>
                        </div>
                    @enderror
                        <button type="submit" class="btn login">Reset Password</button>
                    </form>
                <div class="image-holder">
					<img src="{{ URL::asset('assets/images/city.jpg') }}">
				</div>
                

			</div>
</div>

		<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/main.js') }}"></script>
		@endsection
