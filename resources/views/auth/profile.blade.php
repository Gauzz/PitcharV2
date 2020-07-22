@extends('layouts.app')

@section('styles')

<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
@endsection


@section('content')

<div id="fullBody">
	
<p id="accSetting">Account Settings</p>
<p id="underLine"></p>

<div >
<img src="{{ URL::asset('assets/images/profile2.jpg') }}" id="imgSmallRounded">
</div>

	
<div >
<img src="{{ URL::asset('assets/images/profile2.jpg') }}" id="imgRounded">
</div>

		
<form action=" " id="profileform">
  <label for="fname" id="fullName">FULL NAME</label><br>
  <input type="text" id="fName" name="fname" value=" Full Name" ><br>
  <label for="lname" id="fullEmail">EMAIL</label><br>
  <input type="text" id="Email" name="lname" value="Email" ><br><br>
  <input type="submit" value="Save" id="savBtn">
</form>

<div>
<p id="restPassword" onclick="return showDiv();">RESET PASSWORD</p>

<input type="text" id="link" name="link" value=" verification link send on registerd email-id" style="visibility: none;"><br>
<p id="breakLink">TAKIN A BREAK FROM PITCHAR</p>
<P id="del">DELETE MY ACCOUNT</P>
</div>
</div>


<script type="text/javascript">
        function showDiv() {
            document.getElementById('link').style.display = 'inline-block';
            return false;
        }
    </script>




		@endsection
