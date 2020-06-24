<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MarkerModel;

class MarkerController extends Controller
{
    public $timestamps = false;

    public function postMarker(Request $request)
    {
        $domain = 'http://127.0.0.1:8000/';

        if ($request->submit) {
            if ($request->authtoken) {
                $authtoken = $request->authtoken;
                $name = $request->name ? $request->name : '';
                $tags = $request->tags ? $request->tags : '';
                $experienceid = $request->experienceid ? $request->experienceid : '';
                $description = $request->description ? $request->description : '';
                if ($request->hasFile('marker')) {
                    $validExtensions = ['png', 'jpg', 'jpeg'];
                    $extension = explode('.', $_FILES['marker']['name'])[1];
                    if (in_array($extension, $validExtensions)) {
                        if ($_FILES['marker']['size'] < (10240 * 10240)) {
                            $markerName = time() . '.' . $extension;
                            move_uploaded_file($_FILES['marker']['tmp_name'], public_path('uploads/marker/') . $markerName);
                            $markerURL = $domain . 'uploads/marker/' . $markerName;
                        } else {
                            return ['errormessage' => 'File size limit exceeded. Marker is too large.'];
                        }
                    } else {
                        return ['errormessage' => 'Invalid File.'];
                    }
                } else{
                    return ['errormessage' => 'Invalid request. Please add a Marker.'];
                }
                if ($request->hasFile('patt')) {
                    $validExtensions = ['patt'];
                    $extension = explode('.', $_FILES['patt']['name'])[1];
                    if (in_array($extension, $validExtensions)) {
                        if ($_FILES['patt']['size'] < (10240 * 10240)) {
                            $patternName = time() . '.' . $extension;
                            move_uploaded_file($_FILES['patt']['tmp_name'], public_path('uploads/pattern/') . $patternName);
                            $patternURL = $domain . 'uploads/pattern/' . $patternName;
                        } else {
                            return ['errormessage' => 'File size limit exceeded. Pattern is too large.'];
                        }
                    } else {
                        return ['errormessage' => 'Invalid File.'];
                    }
                } else{
                    return ['errormessage' => 'Invalid request. Please add a Pattern.'];
                }
                    $data = [
                        'authtoken' => $authtoken,
                        'marker' => $markerURL,
                        'linkpatt'=>$patternURL,
                        'name' => $name,
                        'tags' => $tags,
                        'description' => $description,
                        'experienceid' => $experienceid,
                    ];

                    $success = MarkerModel::create($data);

                    if ($success) {
                        $response['message'] = 'Marker added successdully!';
                        $response['msg_code'] = 1;
                        $response['Data'] = array();
                        $markers = MarkerModel::where('authtoken', $authtoken)->orderBy('id', 'desc')->get();
                        foreach ($markers as $marker) {
                            array_push($response['Data'], [
                                'id' => $marker->id,
                                'authtoken' => $marker->authtoken,
                                'linkmarker' => $marker->marker,
                                'linkpatt'=>$marker->linkpatt,
                                'name' => $marker->name,
                                'tags' => $marker->tags,
                                'description' => $marker->description,
                                'experienceid' => $marker->experienceid,
                            ]);
                        }
                    } else {
                        $response['message'] = 'Something went wrong.';
                        $response['msg_code'] = 0;
                    }
                // } else {
                //     $response['message'] = 'Invalid request. Please add a Marker.';
                //     $response['msg_code'] = 0;
                // }
            } else {
                $response['message'] = 'Invalid request. Authtoken not set.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid request. "submit" attribute not present.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function fetchMarkers(Request $request)
    {
        if ($request->submit) {
            if ($request->authtoken) {
                $authtoken = $request->authtoken;
                $response['Data'] = array();

                $results = MarkerModel::where('authtoken', $authtoken)->orderBy('id', 'desc')->get();
                foreach ($results as $marker) {
                    array_push($response['Data'], [
                        'id' => $marker->id,
                        'authtoken' => $marker->authtoken,
                        'linkmarker' => $marker->marker,
                        'linkpatt' => $marker->linkpatt,
                        'name' => $marker->name,
                        'tags' => $marker->tags,
                        'description' => $marker->description,
                        'experienceid' => $marker->experienceid,
                    ]);
                }
            } else {
                $response['message'] = 'Invalid request. Authtoken not set.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid request. "submit" attribute not present.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function fetchMarker(Request $request)
    {
        if ($request->submit) {
            if ($request->id) {
                if ($request->authtoken) {
                    $id = $request->id;
                    $result = MarkerModel::where('id', $id)->get();
                    if ($result) {
                        $response['message'] = 'Fetched marker successfully!';
                        $response['msg_code'] = 1;
                        $response['data'] = array();
                        foreach ($result as $marker) {
                            array_push($response['data'], [
                                'id' => $marker->id,
                                'authtoken' => $marker->authtoken,
                                'linkmarker' => $marker->marker,
                                'linkpatt' => $marker->linkpatt,
                                'name' => $marker->name,
                                'tags' => $marker->tags,
                                'description' => $marker->description,
                                'experoenceid' => $marker->experienceid,
                            ]);
                        }
                    } else {
                        $response['message'] = 'Something went wrong.';
                        $response['msg_code'] = 0;
                    }
                } else {
                    $response['message'] = "Invalid Request. Authtoken not set.";
                    $response['msg_code'] = 0;
                }
            } else {
                $response['message'] = "Invalid Request. ID not set.";
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = "Invalid Request.";
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }

    public function postPattern(Request $request)
    {
        $domain = 'http://127.0.0.1:8000/';

        if ($request->submit) {
            if ($request->marker_id and $request->authtoken) {
                $id = $request->id;
                $name = $request->name ? $request->name : '';
                $tags = $request->tags ? $request->tags : '';
                $description = $request->description ? $request->description : '';
                $experienceid = $request->experienceid ? $request->experienceid : '';
                if ($request->hasFile('patt')) {
                    $extension = explode('.', $_FILES['patt']['name'])[1];
                    if ($extension == 'patt') {
                        $patternName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['patt']['tmp_name'], public_path('uploads/pattern/') . $patternName);
                        $patternURL = $domain . 'uploads/pattern/' . $patternName;
                    } else {
                        return ['errormessage' => 'Invalid File.'];
                    }

                    $success = MarkerModel::where('id', $id)->update([
                        'linkpatt' => $patternURL,
                        'name' => $name,
                        'tags' => $tags,
                        'description' => $description,
                        'experienceid' => $experienceid,
                    ]);
                    if ($success) {
                        $response['message'] = 'Pattern Posted successfully!';
                        $response['msg_code'] = 1;
                        $response['data'] = array();
                        $results = MarkerModel::where('id', $id)->get();
                        foreach ($results as $result) {
                            array_push($response['data'], [
                                'id' => $result->id,
                                'authtoken' => $result->authtoken,
                                'linkpatt' => $result->linkpatt,
                                'linkmarker' => $result->marker,
                                'project_name' => $result->name,
                                'tags' => $result->tags,
                                'description' => $result->description,
                                'experienceid' => $result->experienceid,
                            ]);
                        }
                    } else {
                        $response['message'] = 'Something went wrong.';
                        $message['msg_code'] = 0;
                    }
                }
            } else {
                $response['message'] = 'Invalid Request.';
                $response['msg_code'] = 0;
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response()->json($response);
    }
}
