<?php

namespace App\Http\Controllers;

use App\MediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public $timestamps = false;

    public function createMedia(Request $request)
    {

        $domain = 'http://127.0.0.1:8000/';

        if ($request->create) {
            $authtoken = $request->authtoken;
            $type = $request->type ? $request->type : '';
            $name = $request->name ? $request->name : '';
            $tags = $request->tags ? $request->tags : '';

            if ($request->hasFile('audio')) {
                $validExtensions = ['mp3', 'wav', 'ogg'];
                $extension = explode('.', $_FILES['audio']['name'])[1];
                if (in_array($extension, $validExtensions)) {
                    if ($_FILES['audio']['size'] < (10240 * 10240)) {
                        $audioName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['audio']['tmp_name'], public_path('uploads/audio/') . $audioName);
                        $audioURL = $domain . 'uploads/audio/' . $audioName;
                        $mediaExtension = $extension;
                    } else {
                        return ['errormessage' => 'File size limit exceeded. Image is too large.'];
                    }
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $audioURL = '';
            }

            if ($request->hasFile('video')) {
                $validExtensions = ['mp4', 'wmv', 'avi'];
                $extension = explode('.', $_FILES['video']['name'])[1];
                if (in_array($extension, $validExtensions)) {
                    if ($_FILES['video']['size'] < (10240 * 10240)) {
                        $videoName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['video']['tmp_name'], public_path('uploads/video/') . $videoName);
                        $videoURL = $domain . 'uploads/video/' . $videoName;
                        $mediaExtension=$extension;
                    } else {
                        return ['errormessage' => 'File size limit exceeded. Image is too large.'];
                    }
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $videoURL = '';
            }

            if ($request->hasFile('thumbnail')) {
                $validExtensions = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $_FILES['thumbnail']['name'])[1];
                if (in_array($extension, $validExtensions)) {
                    if ($_FILES['thumbnail']['size'] < (10240 * 10240)) {
                        $thumbnailName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['thumbnail']['tmp_name'], public_path('uploads/videoThumbnail/') . $thumbnailName);
                        $thumbnailURL = $domain . 'uploads/videoThumbnail/' . $thumbnailName;
                    } else {
                        return ['errormessage' => 'File size limit exceeded. Thumbnail is too large.'];
                    }
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $thumbnailURL = '';
            }

            $data = [
                'authtoken' => $authtoken,
                'type' => $type,
                'name' => $name,
                'tags' => $tags,
                'audio' => $audioURL,
                'video' => $videoURL,
                'thumbnail' => $thumbnailURL,
                'extension' => $mediaExtension
            ];

            $media = MediaModel::create($data);

            if (empty($media)) {
                $response['message'] = 'Media not Added to Database.';
                $response['msg_code'] = 0;
            } else {
                // $data = DB::table('assets')->find($id);
                $response['message'] = 'Media Added to Database.';
                $response['msg_code'] = 1;
                $response['data'] = $media;
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function fetchMedia(Request $request)
    {
        if ($request->submit) {
            $authtoken = $request->authtoken;
            $response['media'] = array();

            $results = MediaModel::where('authtoken', '=', $authtoken)->orderBy('id', 'desc')->get();
            foreach ($results as $media) {
                array_push($response['media'], array(
                    'id' => $media->id,
                    'autoken' => $media->authtoken,
                    'type' => $media->type,
                    'video' => $media->video,
                    'thumbnail' => $media->thumbnail,
                    'audio' => $media->audio,
                    'extension' => $media->extension,
                    'name' => $media->name,
                    'tags' => $media->tags
                ));
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function searchMedia(Request $request)
    {
        if ($request->submit) {
            $authtoken = $request->authtoken;
            $tags = $request->tags;
            $response['media'] = array();
            $searchResults = MediaModel::where('authtoken', '=', $authtoken)
                ->where('tags', 'LIKE', $tags)
                ->orWhere('type', 'LIKE', $tags)
                ->orWhere('name', 'LIKE', $tags)
                ->orderBy('id', 'desc')->get();

            if ($searchResults->count() > 0) {
                foreach ($searchResults as $searchResult) {
                    array_push($response['media'], array(
                        'id' => $searchResult->id,
                        'authtoken' => $searchResult->authtoken,
                        'type' => $searchResult->type,
                        'thumbnail' => $searchResult->thumbnail,
                        'audio' => $searchResult->audio,
                        'video' => $searchResult->video,
                        'extension' => $searchResult->extension,
                        'name' => $searchResult->name,
                        'tags' => $searchResult->tags
                    ));
                }
            } else {
                echo json_encode(("No Media Available!"), JSON_PRETTY_PRINT);
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function deleteMedia(Request $request)
    {
        if ($request->authtoken) {
            if ($request->product_id) {
                $id = $request->product_id;
                $success = MediaModel::where('id', $id)->delete();
                if ($success) {
                    $response['message'] = 'Media deleted successfully!';
                    $response['msg_code'] = 1;
                } else {
                    $response['message'] = 'Something went wrong.';
                    $response['msg_code'] = 0;
                }
            } else {
                $response['message'] = 'Invalid Request. ID not set.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid Request. Authtoken not set.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function updateMedia(Request $request)
    {

        $domain = 'http://127.0.0.1:8000/';

        if ($request->update) {
            if ($request->authtoken) {
                if ($request->project_id) {
                    $id = $request->project_id;
                    $currentMedias = MediaModel::where('id', $id)->get();
                    if ($currentMedias) {
                        foreach ($currentMedias as $currentMedia) {
                            $authtoken = $currentMedia->authtoken;
                            $name = $request->name ? $request->name : $currentMedia->name;
                            $type = $request->type ? $request->type : $currentMedia->type;
                            $tags = $request->tags ? $request->tags : $currentMedia->tags;
                            if ($authtoken == $request->authtoken) {
                                if ($request->hasFile('audio')) {
                                    $validExtensions = ['mp3', 'wav', 'ogg'];
                                    $extension = explode('.', $_FILES['audio']['name'])[1];
                                    if (in_array($extension, $validExtensions)) {
                                        if ($_FILES['audio']['size'] < (10240 * 10240)) {
                                            $audioName = time() . '.' . $extension;
                                            move_uploaded_file($_FILES['audio']['tmp_name'], public_path('uploads/audio/') . $audioName);
                                            $audioURL = $domain . 'uploads/audio/' . $audioName;
                                            $audioExtension = $extension;
                                        } else {
                                            return ['errormessage' => 'File size limit exceeded. Image is too large.'];
                                        }
                                    } else {
                                        return ['errormessage' => 'Invalid File.'];
                                    }
                                } else {
                                    $audioURL = $currentMedia->audio;
                                    $audioExtension = $currentMedia->extension;
                                }

                                if ($request->hasFile('video')) {
                                    $validExtensions = ['mp4', 'wmv', 'avi'];
                                    $extension = explode('.', $_FILES['video']['name'])[1];
                                    if (in_array($extension, $validExtensions)) {
                                        if ($_FILES['video']['size'] < (10240 * 10240)) {
                                            $videoName = time() . '.' . $extension;
                                            move_uploaded_file($_FILES['video']['tmp_name'], public_path('uploads/video/') . $videoName);
                                            $videoURL = $domain . 'uploads/video/' . $videoName;
                                        } else {
                                            return ['errormessage' => 'File size limit exceeded. Image is too large.'];
                                        }
                                    } else {
                                        return ['errormessage' => 'Invalid File.'];
                                    }
                                } else {
                                    $videoURL = $currentMedia->video;
                                }

                                if ($request->hasFile('thumbnail')) {
                                    $validExtensions = ['png', 'jpg', 'jpeg'];
                                    $extension = explode('.', $_FILES['thumbnail']['name'])[1];
                                    if (in_array($extension, $validExtensions)) {
                                        if ($_FILES['thumbnail']['size'] < (10240 * 10240)) {
                                            $thumbnailName = time() . '.' . $extension;
                                            move_uploaded_file($_FILES['thumbnail']['tmp_name'], public_path('uploads/videoThumbnail/') . $thumbnailName);
                                            $thumbnailURL = $domain . 'uploads/videoThumbnail/' . $thumbnailName;
                                        } else {
                                            return ['errormessage' => 'File size limit exceeded. Thumbnail is too large.'];
                                        }
                                    } else {
                                        return ['errormessage' => 'Invalid File.'];
                                    }
                                } else {
                                    $thumbnailURL = $currentMedia->thumbnail;
                                }

                                $success = MediaModel::where('id', $id)->update([
                                    'type' => $type,
                                    'video' => $videoURL,
                                    'thumbnail' => $thumbnailURL,
                                    'audio' => $audioURL,
                                    'name' => $name,
                                    'tags' => $tags,
                                    'extension' => $audioExtension,
                                ]);
                                if ($success) {
                                    $updatedMedias = MediaModel::where('id', $id)->get();
                                    $response['message'] = 'Media updated successfully!';
                                    $response['msg_code'] = 1;
                                    $response['data'] = array();
                                    foreach ($updatedMedias as $updatedMedia) {
                                        array_push($response['data'], [
                                            'id' => $updatedMedia->id,
                                            'authtoken' => $updatedMedia->authtoken,
                                            'type' => $updatedMedia->type,
                                            'video' => $updatedMedia->video,
                                            'thumbnail' => $updatedMedia->thumbnail,
                                            'audio' => $updatedMedia->audio,
                                            'name' => $updatedMedia->name,
                                            'tags' => $updatedMedia->tags,
                                            'extension' => $updatedMedia->extension,
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
                        }
                    } else {
                        $response['message'] = "Invalid Request. ID not present.";
                        $response['msg_code'] = 0;
                    }
                } else {
                    $response['message'] = "Invalid Request. ID not set.";
                    $response['msg_code'] = 0;
                }
            } else {
                $response['message'] = "Invalid Request. Authtoken not set.";
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = "Invalid Request.";
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }
}
