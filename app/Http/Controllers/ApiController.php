<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    public function upload(Request $request){
        // SET VALIDATION RULES
        $validator = Validator::make(\Request::all(), [
            'front' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'rear' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'left' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'right' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        // VALIDATE REQUEST
        if ($validator->fails()) {
            return Response::json(['result'=>$validator->messages()->all()[0]]);
        }
        
        if ($request->hasFile('front') && $request->hasFile('rear') && $request->hasFile('left') && $request->hasFile('right')) {
            // UPLOAD FRONT IMAGE
            try{
                $image = $request->file('front');
                $front = time().rand(1000, 9999);
                $image->move(public_path('/imgs/products'), "$front.png");
            }catch(\Exception $e){
                return Response::json(['error'=>$e->getMessage()]);
            }
            // UPLOAD REAR IMAGE
            try{
                $image = $request->file('rear');
                $rear = time().rand(1000, 9999);
                $image->move(public_path('/imgs/products'), "$rear.png");
            }catch(\Exception $e){
                return Response::json(['error'=>$e->getMessage()]);
            }
            // UPLOAD LEFT IMAGE
            try{
                $image = $request->file('left');
                $left = time().rand(1000, 9999);
                $image->move(public_path('/imgs/products'), "$left.png");
            }catch(\Exception $e){
                return Response::json(['error'=>$e->getMessage()]);
            }
            // UPLOAD RIGHT IMAGE
            try{
                $image = $request->file('right');
                $right = time().rand(1000, 9999);
                $image->move(public_path('/imgs/products'), "$right.png");
            }catch(\Exception $e){
                return Response::json(['error'=>$e->getMessage()]);
            }

            try{
                $attemptInsert = \App\Product::create([
                    "name"=>$request->p_name,
                    "description"=>$request->desc,
                    "quantity"=>$request->qty,
                    "price"=>$request->price,
                    "rating"=>$request->period,
                    "front_img"=>"$front.png",
                    "rear_img"=>"$rear.png",
                    "left_img"=>"$left.png",
                    "right_img"=>"$right.png"
                ]);

                if($attemptInsert){
                    // RETURN SUCCESS RESPONSE
                    return Response::json(['result'=>"Upload Successful", "data"=>$attemptInsert->toArray()]);
                }else{
                    return Response::json(['error'=>"There was an error some where!"]);
                }
            }catch(\Exception $e){
                return Response::json(['error'=>$e->getMessage()]);
            }
        }else{
            // RETURN FAILURE RESPONSE
            return Response::json(['result'=>"Failed for some reasons!"]);
        }
    }

    public function getProduct(){
        try{
            $prod = \App\Product::orderBy('created_at', 'DESC')->first();
            return Response::json(['result'=>"Pull Successful", 'data'=>$prod]);
        }catch(\Exception $e){
            return Response::json(['error'=>$e->getMessage()]);
        }
    }
}
