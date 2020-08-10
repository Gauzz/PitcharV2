@extends('layouts.app')

@section('styles')

<link rel="stylesheet" type="text/css" href="assets/css/profile.css">

@endsection


@section('content')

<div id="fullBody">
<div id="mySidenav" class="sidenav" style="width:0px;">
  <a href="javascript:void(0)" class="closebtn"   onclick="closeNav()">&times;</a>
  <a href="{{ url('/home') }}" style="margin-top:70px;">Dashboard</a>
  <a href="{{ route('logout') }}">Logout</a>
  
</div>

<p style="font-size:45px; cursor:pointer;" id="hamburger" onclick="openNav()">&#9776; </p>
<p id="accSetting">Account Settings</p>
<p id="underLine"></p>
<input type="text"  id="Name" name="fname" value=" {{ Auth::user()->name }}" ><br>

<form action="/profile" method="post" enctype="multipart/form-data">

  @csrf
  <img src="{{ Auth::user()->profile_pic }} "  alt="Image preview..." id="imgRounded" >
  <label for="profileImage"></label>
  <input name="image" id="profileImage"  type="file" accept="image/*" onchange="document.getElementById('imgRounded').src = window.URL.createObjectURL(this.files[0]) ">
  <label for="fname" id="fullName">FULL NAME</label><br>
  <input type="text" id="fName" name="fname" value=" {{ Auth::user()->name }}" ><br>
  <label for="lname" id="fullEmail">EMAIL</label><br>
  <input type="text" id="Email" name="lname" value="{{ Auth::user()->email }}" disabled ><br><br>
  <input type="submit" class="submit"  value="Save" id="savBtn">

</form>



<div>
<p id="restPassword" onclick="return showDiv();">
@if (Route::has('password.request'))
<a   href="{{ route('password.request') }}">
                                        {{ __('RESET PASSWORD') }}
                                    </a>
                                @endif
                                </p>

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
        
        
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
   
       



		@endsection
    
