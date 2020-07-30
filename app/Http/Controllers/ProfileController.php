<?php

namespace App\Http\Controllers;
use App\UserModel;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function uploadProfile(Request $request){ 
        $domain = 'http://127.0.0.1:8000/';

            if ($request->hasFile('image')) {
                $image = $request->image;
                $extension = explode('.', $_FILES['image']['name'])[1];
                $validExtensions = ['png','jpg','jpeg'];
                if (in_array($extension,$validExtensions)) {   
                    $path = $image->store('uploads/profilePic/', 'public');
                    $imgURL = $domain.$path;
                    $imageName = time() . '.' . $extension;
                    move_uploaded_file($_FILES['image']['tmp_name'], public_path('uploads/profilePic/') . $imageName);
                    $imageURL =   'uploads/profilePic/' . $imageName; 
                     UserModel::find(1)->update(['profile_pic' => $imageURL]);

                }
            } else {
                $imgURL='';
            }
return back()->with('success','You have successfully upload image.');
;
}}

