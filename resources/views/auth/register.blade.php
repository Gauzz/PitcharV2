<!DOCTYPE html>
@extends('layouts.app')

@section('content')

		<div class="wrapper">
			<div class="inner">


				<!-- Registration Form -->
				<form method="POST" action="{{ route('register') }}" id = "registerform" >
                    @csrf
					<h3>Join PitchAR</h3>
                    <h5>Already have an account? <a href="{{ route('login') }}"><u>Log in Here</u></a></h5>
					<div class="form-wrapper">
						<label for="" class="label-input">EMAIL ADDRESS</label>
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>
                    
					<div class="form-wrapper">
						<label for="" class="label-input">FULL NAME</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>
                    
					<div class="form-wrapper">
						<label for="" class="label-input">PASSWORD</label>
				<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>
                    <a href = "onboarding" class="btn back" id="backtoonboarding">Back</a>
					<button type="submit" class="btn signup">Sign Up</button>
                    
                    <h6>By creating an account you agree to our<br><a><u>Terms And Conditions</u></a></h6>
				</form>
				<!-- Registration Form -->

                
				<div class="image-holder">
					<img src="{{ URL::asset('assets/images/city.jpg') }}">
				</div>
			</div>
		</div>

		<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/main.js') }}"></script>
		<script>

			

		</script>
	</body>
</html>
@endsection
