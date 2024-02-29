<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\Post;
use Illuminate\Http\Request;



class LikeableController extends Controller
{


    // public function index()
    // {

    //     return back();
    // }
    // public function likeable($id)
    // {
    //     $post_id = $id;

    //     // Retrieve the like with the specified ID
    //     $likes = Like::find($post_id);

    //     if ($likes) {
    //         $likes->post_id = $post_id;
    //         $likes->likeable =  $likes->likeable + 1;
    //         $likes->save();
    //     } else {
    //         Like::create(
    //             [
    //                 'post_id' => $post_id,
    //                 'likeable' => 1
    //             ]
    //         );
    //     }
    //     return back();
    // }


    // public function dislikeable($id)
    // {
    //     // echo $id;
    //     $post_id = $id;


    //     $likes = Like::find($post_id);
    //     $likes->post_id = $post_id;
    //     $likes->likeable =  $likes->likeable - 1;
    //     $likes->save();
    //     return back();
    // }


    public function index()
    {

        return back();
    }
    public function likeable($id, $type)
    {
        $post_id = $id;      
        $likes = Like::find($post_id);

        if ($likes) {
            $likes->post_id = $post_id;
            if($type == "like"){
                $likes->likeable =  $likes->likeable + 1;
            }else{
                $likes->dislikes =  $likes->dislikes + 1;
            }
            $likes->save();
        } else {
            $data = [
                'post_id' => $post_id,
                'likeable' => 0,
                'dislikes' => 0
            ];
            if($type == "like"){
                $data["like"] = 1;
            }else{
                $data["dislikes"] = 1;
            }
            Like::create($data);
        }
          return back();
    }
}
