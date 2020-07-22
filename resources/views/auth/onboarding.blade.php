
@extends('layouts.app')

@section('content')

		<div class="wrapper">
			<div class="inner">

				<!-- Onboarding Form -->
				<form action="" id = "onboardingform">
					<h3>Join PitchAR</h3>
					<h5>Create web based augmented reality for free</h5>
					<div id="onboarding">
						<a class="fb btn" id = "fb">
							<i class="fa fa-facebook fa-fw"></i><span id = "onboardingtext">Login with Facebook</span>
						</a>
					</div>
					<div id="onboarding">
						<a class="google btn" id = "google">
							<i class="fa fa-google fa-fw"></i><span id = "onboardingtext">Login with Google</span>
						</a>
					</div>
					<div id="onboarding">
						<a href = "{{ route('register') }}" class="email btn" id = "email">
							<i class="fa fa-envelope fa-fw"></i><span id = "onboardingtext">Login with Email</span>
						</a>
					</div>
				</form>
				<!-- Onboarding Form -->


                
				<div class="image-holder">
					<img src="{{ URL::asset('assets/images/city.jpg') }}">
				</div>
			</div>
		</div>

		<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/main.js') }}"></script>


@endsection
