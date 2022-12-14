<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class HomeController extends Controller
{

	public function dropzoneform()
	{
		return view('dropzone');
	}


	public function storeData(Request $request)
	{
		try {
			$user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = hash('sha256','password');
            $user->save();
            $user_id = $user->id; // this give us the last inserted record id
		}
		catch (\Exception $e) {
			return response()->json(['status'=>'exception', 'msg'=>$e->getMessage()]);
		}
		return response()->json(['status'=>"success", 'user_id'=>$user_id]);
	}



	// We are submitting are image along with userid and with the help of user id we are updateing our record
	public function storeImage(Request $request)
	{
		if($request->file('file')){

            $img = $request->file('file');

            //here we are geeting userid alogn with an image
            $userid = $request->userid;

            $imageName = strtotime(now()).rand(11111,99999).'.'.$img->getClientOriginalExtension();
            $user_image = new User();
            $original_name = $img->getClientOriginalName();
            $user_image->image = $imageName;

            if(!is_dir(public_path() . '/uploads/images/')){
                mkdir(public_path() . '/uploads/images/', 0777, true);
            }

        $request->file('file')->move(public_path() . '/uploads/images/', $imageName);

        // we are updating our image column with the help of user id
        $user_image->where('id', $userid)->update(['image'=>$imageName]);

        return response()->json(['status'=>"success",'imgdata'=>$original_name,'userid'=>$userid]);
        }
	}

    public function storeMultipleImage(Request $request){
        try {
            $imageArr = [];
            foreach ($request->file('file') as $file) {
                $img = $file;

                //here we are geeting userid alogn with an image
                $userid = $request->userid;
    
                $imageName = strtotime(now()).rand(11111,99999).'.'.$img->getClientOriginalExtension();
                $user_image = new User();
                $original_name = $img->getClientOriginalName();
                $user_image->image = $imageName;
    
                if(!is_dir(public_path() . '/uploads/images/')){
                    mkdir(public_path() . '/uploads/images/', 0777, true);
                }
    
                $file->file('file')->move(public_path() . '/uploads/images/', $imageName);
                array_push($imageArr, $imageName);

            }
            $imageArrToSrt = implode(",", $imageArr);
            // we are updating our image column with the help of user id
            $result = $user_image->where('id', $userid)->update(['image'=>$imageArrToSrt]);
            if ($result) {
                return response()->json(['status'=>"success",'msg'=>'Imagen subida con exito','userid'=>$userid]);
            }else{
                return response()->json(['status'=>"success",'msg'=>'Imagen no subida']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>"success",'msg'=>'Imagen no subida']);
        }

    }

}
