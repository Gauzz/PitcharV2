<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetModel;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public $timestamps = false;

    public function createAssets(Request $request)
    {

        $domain = 'http://127.0.0.1:8000/';

        if ($request->create) {
            $authtoken = $request->authtoken;
            $type = $request->type ? $request->type : '';
            $name = $request->name ? $request->name : '';
            $tags = $request->tags ? $request->tags : '';

            if ($request->hasFile('image')) {
                $validExtensions = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $_FILES['image']['name'])[1];
                if (in_array($extension, $validExtensions)) {
                    if ($_FILES['image']['size'] < (10240 * 10240)) {
                        $imageName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'], public_path('uploads/img/') . $imageName);
                        $imageURL = $domain . 'uploads/img/' . $imageName;
                    } else {
                        return ['errormessage' => 'File size limit exceeded. Image is too large.'];
                    }
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $imageURL = '';
            }

            if ($request->hasFile('obj')) {
                $extension = explode('.', $_FILES['obj']['name'])[1];
                if ($extension == 'obj') {
                    $objName = time() . '.' . $extension;
                    move_uploaded_file($_FILES['obj']['tmp_name'], public_path('uploads/obj/') . $objName);
                    $objURL = $domain . 'uploads/obj/' . $objName;
                    $fbxURL = '';
                } elseif ($extension == 'fbx') {
                    $fbxName = time() . '.' . $extension;
                    move_uploaded_file($_FILES['obj']['tmp_name'], public_path('uploads/obj/') . $fbxName);
                    $fbxURL = $domain . 'uploads/obj/' . $fbxName;
                    $objURL = '';
                }
            } else {
                $fbxURL = '';
                $objURL = '';
            }

            if ($request->hasFile('mtl')) {
                $extension = explode('.', $_FILES['mtl']['name'])[1];
                if ($extension == 'mtl') {
                    $mtlName = time() . '.' . $extension;
                    move_uploaded_file($_FILES['mtl']['tmp_name'], public_path('uploads/mtl/') . $mtlName);
                    $mtlURL = $domain . 'uploads/mtl/' . $mtlName;
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $mtlURL = '';
            }

            if ($request->hasFile('thumbnail')) {
                $validExtensions = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $_FILES['thumbnail']['name'])[1];
                if (in_array($extension, $validExtensions)) {
                    if ($_FILES['thumbnail']['size'] < (10240 * 10240)) {
                        $thumbnailName = time() . '.' . $extension;
                        move_uploaded_file($_FILES['thumbnail']['tmp_name'], public_path('uploads/thumbnail/') . $thumbnailName);
                        $thumbnailURL = $domain . 'uploads/thumbnail/' . $thumbnailName;
                    } else {
                        return ['errormessage' => 'File size limit exceeded. Thumbnail is too large.'];
                    }
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $thumbnailURL = '';
            }

            if ($request->hasFile('gltf')) {
                $extension = explode('.', $_FILES['gltf']['name'])[1];
                if ($extension == 'gltf') {
                    $gltfName = time() . '.' . $extension;
                    move_uploaded_file($_FILES['gltf']['tmp_name'], public_path('uploads/gltf/') . $gltfName);
                    $gltfURL = $domain . 'uploads/gltf/' . $gltfName;
                } else {
                    return ['errormessage' => 'Invalid File.'];
                }
            } else {
                $gltfURL = '';
            }


            // if ($request->hasFile('image')) {
            //     $image = $request->image;
            //     $extension = $image->getClientOriginalExtension();
            //     $validExtensions = ['png','jpg','jpeg'];
            //     if (in_array($extension,$validExtensions)) {    
            //         $path = $image->store('uploads/img',['disk'=>'public']);
            //         $imgURL = $domain.$path;
            //     }
            // } else {
            //     $imgURL='';
            // }

            // if ($request->hasFile('mtl')) {
            //     $mtl = $request->mtl;

            //     $path = $mtl->move('uploads/mtl');
            //     $mtlURL = $domain.$path;
            // } else {
            //     $mtlURL='';
            // }

            // if ($request->hasFile('gltf')) {
            //     $gltf = $request->gltf;
            //     $extension = $gltf->getClientOriginalExtension();
            //     if($extension == 'gltf'){
            //         $path = $gltf->store('uploads/gltf',['disk'=>'public']);
            //         $gltfURL = $domain.$path;

            //     }
            // } else {
            //     $gltfURL='';
            // }

            // if ($request->hasFile('thumbnail')) {
            //     $thumbnail = $request->thumbnail;
            //     $extension = $thumbnail->getClientOriginalExtension();
            //     $validExtensions = ['png','jpg','jpeg'];
            //     if (in_array($extension,$validExtensions)) {
            //         $path = $thumbnail->store('uploads/thumbnail',['disk'=>'public']);
            //         $thumbnailURL = $domain.$path;
            //     }
            // } else {
            //     $thumbnailURL='';
            // }


            $data = [
                'authtoken' => $authtoken,
                'type' => $type,
                'objthumbnail' => $thumbnailURL,
                'obj' => $objURL,
                'mtl' => $mtlURL,
                'fbx' => $fbxURL,
                'gltf' => $gltfURL,
                'image' => $imageURL,
                'name' => $name,
                'tags' => $tags
            ];

            $asset = AssetModel::create($data);

            if (empty($asset)) {
                $response['message'] = 'Assets not Added to Database.';
                $response['msg_code'] = 0;
            } else {
                // $data = DB::table('assets')->find($id);
                $response['message'] = 'Assets Added to Database.';
                $response['msg_code'] = 1;
                $response['data'] = $asset;
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }

        // echo json_encode($response);
        return response()->json($response);
    }

    public function fetchAssets(Request $request)
    {
        if ($request->submit) {
            $authtoken = $request->authtoken;
            $response['assets'] = array();

            $results = DB::table('assets')->where('authtoken', '=', $authtoken)->orderBy('id', 'desc')->get();
            foreach ($results as $asset) {

                array_push($response["assets"], array(
                    'id' => $asset->id,
                    'authtoken' => $asset->authtoken,
                    'Assetstype' => $asset->type,
                    'objthumbnail' => $asset->objthumbnail,
                    'obj' => $asset->obj,
                    'mtl' => $asset->mtl,
                    'gltf' => $asset->gltf,
                    'fbx' => $asset->fbx,
                    'Projectimage' => $asset->image,
                    'Projectname' => $asset->name,
                    'tags' => $asset->tags
                ));
            }
        } else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        // echo json_encode(($response),JSON_PRETTY_PRINT);
        return response($response)->header('Content-Type', 'application/json');
        // echo json_encode($response, JSON_UNESCAPED_SLASHES);
    }

    public function searchAssets(Request $request){
        if($request->submit){
            $authtoken = $request->authtoken;
            $tags = $request->tags;

            $searchResults = DB::table('assets')
                                ->where('authtoken','=',$authtoken)
                                ->orWhere('tags','LIKE',$tags)
                                ->orWhere('type','LIKE',$tags)
                                ->orWhere('name','LIKE',$tags)
                                ->orderBy('id','desc')->get();
            
            
        }
    }
}
