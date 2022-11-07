<?php

namespace App\Http\Controllers;

use App\Models\dropzone;
use App\Models\Images;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DropzoneController extends Controller
{
    public function saveFile(Request $request){

        foreach ($request->file('file') as $key => $file) {

            $path = Storage::putFile('images', $file);

            $saveImage = new Images();
            $saveImage->user_id = $request->user;
            $saveImage->image = $path;
            $saveImage->save();

        }

        return response()->json(['status' => 'sucess']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dropzone/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = hash('sha256', 'password');
        $user->save();
        // $files = [];
        // foreach ($request->file('file') as $key => $file) {
        //     $files[$key] = $file;
        // }
        // dd($files);

        return response()->json(['id' => $user->id]);
        // $files = $request->file('file');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dropzone  $dropzone
     * @return \Illuminate\Http\Response
     */
    public function show(dropzone $dropzone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dropzone  $dropzone
     * @return \Illuminate\Http\Response
     */
    public function edit(dropzone $dropzone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dropzone  $dropzone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dropzone $dropzone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dropzone  $dropzone
     * @return \Illuminate\Http\Response
     */
    public function destroy(dropzone $dropzone)
    {
        //
    }
}
