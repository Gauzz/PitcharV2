<?php

namespace App\Http\Controllers;

use App\MediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public $timestamps = false;
    
    public function createMedia(Request $request) {

        $domain = 'http://127.0.0.1:8000/';

        if ($request->create) {
            $authtoken = $request->authtoken;
            $type = $request->type ? $request->type : '';
            $name = $request->name ? $request->name : '';
            $tags = $request->tags ? $request->tags : '';

            if ($request->hasFile('audio')){
                $validExtensions = ['mp3','wav','ogg'];
                $extension = explode('.',$_FILES['audio']['name'])[1];
                if(in_array($extension,$validExtensions)){
                    if($_FILES['audio']['size']<(10240*10240)){
                        $audioName = time().'.'.$extension;
                        move_uploaded_file($_FILES['audio']['tmp_name'],public_path('uploads/audio/').$audioName);
                        $audioURL=$domain.'uploads/audio/'.$audioName;
                        $audioExtension = $extension;
                    }
                    else{
                        return ['errormessage'=>'File size limit exceeded. Image is too large.'];
                    }
                }
                else{
                    return ['errormessage'=>'Invalid File.'];
                }
            }
            else {
                $audioURL='';
                $audioExtension='';
            }

            if ($request->hasFile('video')){
                $validExtensions = ['mp4','wmv','avi'];
                $extension = explode('.',$_FILES['video']['name'])[1];
                if(in_array($extension,$validExtensions)){
                    if($_FILES['video']['size']<(10240*10240)){
                        $videoName = time().'.'.$extension;
                        move_uploaded_file($_FILES['video']['tmp_name'],public_path('uploads/video/').$videoName);
                        $videoURL=$domain.'uploads/video/'.$videoName;
                    }
                    else{
                        return ['errormessage'=>'File size limit exceeded. Image is too large.'];
                    }
                }
                else{
                    return ['errormessage'=>'Invalid File.'];
                }
            }
            else {
                $videoURL='';
            }

            if ($request->hasFile('thumbnail')) {
                $validExtensions = ['png','jpg','jpeg'];
                $extension = explode('.',$_FILES['thumbnail']['name'])[1];
                if(in_array($extension,$validExtensions)){
                    if($_FILES['thumbnail']['size']<(10240*10240)){
                        $thumbnailName = time().'.'.$extension;
                        move_uploaded_file($_FILES['thumbnail']['tmp_name'],public_path('uploads/videoThumbnail/').$thumbnailName);
                        $thumbnailURL=$domain.'uploads/videoThumbnail/'.$thumbnailName;
                    }
                    else{
                        return ['errormessage'=>'File size limit exceeded. Thumbnail is too large.'];
                    }
                }
                else{
                    return ['errormessage'=>'Invalid File.'];
                }
            } else {
                $thumbnailURL='';
            }

            $data = [
                'authtoken'=> $authtoken,
                'type'=>$type,
                'name'=>$name,
                'tags'=>$tags,
                'audio'=>$audioURL,
                'video'=>$videoURL,
                'thumbnail'=>$thumbnailURL,
                'extension'=>$audioExtension
            ];

            $media = MediaModel::create($data);

            if (empty($media)){
                $response['message']='Media not Added to Database.';
                $response['msg_code']=0;
            }
            else {
                // $data = DB::table('assets')->find($id);
                $response['message']='Media Added to Database.';
                $response['msg_code']=1;
                $response['data']=$media;
            }
        }
        else {
            $response['message']='Invalid Request.';
            $response['msg_code']=0;
        }
        return response()->json($response);
    }

    public function fetchMedia(Request $request) {
        if ($request->submit){
            $authtoken = $request->authtoken;
            $response['media']=array();

            $results = DB::table('media')->where('authtoken','=',$authtoken)->orderBy('id','desc')->get();
            foreach($results as $media){
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
        }
        else {
            $response['message']='Invalid Request.';
            $response['msg_code']=0;
        }
        return response($response)->header('Content-type','application/json');
    }

    public function searchMedia(Request $request){
        if($request->submit){
            $authtoken = $request->authtoken;
            $tags = $request->tags;
            $response['media'] = array();
            $searchResults = DB::table('media')
                                ->where('authtoken','=',$authtoken)
                                ->where('tags','LIKE',$tags)
                                ->orWhere('type','LIKE',$tags)
                                ->orWhere('name','LIKE',$tags)
                                ->orderBy('id','desc')->get();
            
            if ($searchResults->count()>0){
                foreach ($searchResults as $searchResult) {
                    array_push($response['media'],array(
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
                
            }else{
                echo json_encode(("No Media Available!"),JSON_PRETTY_PRINT);
            }
        }else {
            $response['message'] = 'Invalid Request.';
            $response['msg_code'] = 0;
        }
        return response($response)->header('Content-Type', 'application/json');

    }
}
