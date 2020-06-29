<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExperienceModel;

class ExperienceController extends Controller
{
    public $timestamps = false;

    public function postExperience(Request $request)
    {
        $domain = 'http://127.0.0.1:8000/';
        if ($request->submit and $request->experience) {
            $authtoken = $request->authtoken;
            $name = $request->name ? $request->name : '';
            $tags = $request->tags ? $request->tags : '';
            $description = $request->description ? $request->description : '';
            if ($request->hasFile('thumbnail')) {
                $validExtensions = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $_FILES['thumbnail']['name'])[1];
                if (in_array($extension, $validExtensions)) {
                    if ($_FILES['thumbnail']['size'] < (10240 * 10240)) {
                        $thumbnailName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['thumbnail']['tmp_name'], public_path('uploads/expThumbnail/') . $thumbnailName);
                        $thumbnailURL = $domain . 'uploads/expThumbnail/' . $thumbnailName;
                    } else {
                        return ['errormessage' => 'File size limit exceeded. Thumbnail is too large.'];
                    }
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $thumbnailURL = '';
            }

            $experience = $request->experience;
            $experienceName = time() . '.html';
            file_put_contents(public_path('uploads/experience/') . $experienceName, $experience);
            $experienceURL = $domain . 'uploads/experience/' . $experienceName;

            $success = ExperienceModel::create([
                'authtoken' => $authtoken,
                'experience' => $experience,
                'share_experience' => $experienceURL,
                'thumbnail' => $thumbnailURL,
                'name' => $name,
                'tags' => $tags,
                'description' => $description,
            ]);
            if ($success) {
                $response['message'] = 'Experience Added successfully';
                $response['msg_code'] = 1;
                $response['Data'] = array();
                $results = ExperienceModel::where('authtoken', $authtoken)->orderBy('id','desc')->get();
                foreach ($results as $result) {
                    array_push($response['Data'], [
                        'id' => $result->id,
                        'authtoken' => $result->authtoken,
                        'experience' => $result->experience,
                        'share_experience' => $result->share_experience,
                        'thumbnail' => $result->thumbnail,
                        'name' => $result->name,
                        'description' => $result->description
                    ]);
                }
            } else {
                $response['message'] = 'Something went wrong.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function fetchExperience(Request $request)
    {
        if ($request->submit) {
            if ($request->authtoken) {
                if ($request->experienceid) {
                    $id = $request->experienceid;
                    $authtoken = $request->authtoken;

                    $response['Data'] = array();
                    $results = ExperienceModel::where('id', $id)
                        ->where('authtoken', $authtoken)
                        ->get();
                    foreach ($results as $result) {
                        array_push($response['Data'], [
                            'experienceid' => $result->id,
                            'authtoken' => $result->authtoken,
                            'experience' => $result->experience,
                            'share_experience' => $result->share_experience,
                            'thumbnail' => $result->thumbnail,
                            'project_name' => $result->name,
                            'tags' => $result->tags,
                            'description' => $result->description
                        ]);
                    }
                    $response['message'] = 'Fetch Experience Successfully.';
                    $response['msg_code'] = 1;
                } else {
                    $response['message'] = 'Invalid Request. Experience ID missing.';
                    $response['msg_code'] = 0;
                }
            } else {
                $response['message'] = 'Invalid Request. Authtoken missing.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }
    public function editPostExperience(Request $request)
    {
        $domain = 'http://127.0.0.1:8000/';
        if ($request->submit) {
            if ($request->authtoken) {
                if ($request->id) {
                    $id = $request->id;
                    $currentExperience = ExperienceModel::where('id', $id)->get();
                    if ($currentExperience) {
                        $authtoken = $currentExperience->authtoken;
                        $name = $request->name ? $request->name : $currentExperience->name;
                        $description = $request->description ? $request->description : $currentExperience->type;
                        $tags = $request->tags ? $request->tags : $currentExperience->tags;

                        if ($authtoken == $request->authtoken) {
                            if ($request->hasFile('thumbnail')) {
                                $validExtensions = ['png', 'jpg', 'jpeg'];
                                $extension = explode('.', $_FILES['thumbnail']['name'])[1];
                                if (in_array($extension, $validExtensions)) {
                                    if ($_FILES['thumbnail']['size'] < (10240 * 10240)) {
                                        $thumbnailName = time() . '.' . $extension;
                                        move_uploaded_file($_FILES['thumbnail']['tmp_name'], public_path('uploads/expThumbnail/') . $thumbnailName);
                                        $thumbnailURL = $domain . 'uploads/expThumbnail/' . $thumbnailName;
                                    } else {
                                        return ['errormessage' => 'File size limit exceeded. Thumbnail is too large.'];
                                    }
                                } else {
                                    return ['errormessage' => 'Invalid File.'];
                                }
                            } else {
                                $thumbnailURL = $currentExperience->thumbnail;
                            }

                            if ($request->experience) {
                                $experience = $request->experience;
                                $experienceName = time() . '.html';
                                file_put_contents(public_path('uploads/experience/') . $experienceName, $experience);
                                $experienceURL = $domain . 'uploads/experience/' . $experienceName;
                            } else {
                                $experience = $currentExperience->experience;
                                $experienceURL = $currentExperience->share_experience;
                            }
                            $success = ExperienceModel::where('id', $id)->update([
                                'experience' => $experience,
                                'share_experience' => $experienceURL,
                                'thumbnail' => $thumbnailURL,
                                'name' => $name,
                                'tags' => $tags,
                                'description' => $description,
                            ]);
                            if ($success) {
                                $updatedExperiences = ExperienceModel::where('id', $id)->get();
                                $response['message'] = 'Experience updated successfully!';
                                $response['msg_code'] = 1;
                                $response['Data'] = array();
                                foreach ($updatedExperiences as $updatedExperience) {
                                    array_push($response['Data'], [
                                        'id' => $updatedExperience->id,
                                        'authtoken' => $updatedExperience->authtoken,
                                        'experience' => $updatedExperience->experience,
                                        'share_experience' => $updatedExperience->share_experience,
                                        'name' => $updatedExperience->name,
                                        'tags' => $updatedExperience->tags,
                                        'description' => $updatedExperience->description,
                                    ]);
                                }
                            } else {
                                $response['message'] = "Some Error occured while updating values.";
                                $response['msg_code'] = 0;
                            }
                        } else {
                            $response['message'] = "Invalid Request. Authtoken not identified.";
                            $response['msg_code'] = 0;
                        }
                    } else {
                        $response['message'] = "Invalid Request. ID not present.";
                        $response['msg_code'] = 0;
                    }
                } else {
                    $response['message'] = 'Invalid Request. Experience ID not present.';
                    $response['msg_code'] = 0;
                }
            } else {
                $response['message'] = 'Invalid Request. Authtoken not present.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid request. "submit" attribute not present.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }
}
