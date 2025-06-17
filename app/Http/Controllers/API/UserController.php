<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function isProfileComplete(): JsonResponse
    {
        $user = \Auth::user();
        $arraynull = [];
        /*if (!$user->name) {
            $arraynull[] = "Nama";
        }
        if (!$user->email) {
            $arraynull[] = "Email";
        }*/
        if (!$user->birth_place) {
            $arraynull[] = "Tempat Lahir";
        }
        if (!$user->birth_date) {
            $arraynull[] = "Tanggal Lahir";
        }
        if (!$user->phone) {
            $arraynull[] = "Nomer Telepon";
        }
        if (!$user->address) {
            $arraynull[] = "Alamat";
        }
        if (!$user->component) {
            $arraynull[] = "Komponen";
        }
        if (!empty($arraynull)) {
            return $this->sendResponse(false, "Data Profile Kurang Lengkap");
        }
        else{
            return $this->sendResponse(true, "Data Profile Sudah Lengkap");
        }
    }
    public function show(): JsonResponse
    {
        $user = \Auth::user();  
        /*if (is_null($user)) {
            return $this->sendError('user not found.');
        }*/
   
        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request): JsonResponse
    {
        $validator=Validator::make($request->all(),[
            'old_password'        =>'required',
            'new_password'         =>'required|min:8|max:30',
            'confirm_password' =>'required|same:new_password'
         ]);
         if ($validator->fails()) {
            return $this->sendError('Validation Fails.', $validator->errors(), 422);
            /*return response()->json([
               'message'=>'validations fails',
               'errors' =>$validator->errors()
            ],422);*/
         }
         $user=$request->user();
   
         if (Hash::check($request->old_password,$user->password)) {
            $user->update([
               'password'=>Hash::make($request->new_password)
            ]);
            return $this->sendResponse(new UserResource($user), 'User password updated successfully.');
            /*return response()->json([
               'message'=>' password successfully updated',
               'errors' =>$validator->errors()
            ],200);*/
         }
         else
         {
            return $this->sendError('Old Password Does Not Match', $validator->errors(), 422);
            /*return response()->json([
               'message'=>'old password does not match',
               'errors' =>$validator->errors()
            ],422);*/
         }
/*
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = \Auth::user();  
        if (is_null($user)) {
            return $this->sendError('user not found.');
        }
        $user->password = bcrypt($request['password']);
        $user->save();
        return $this->sendResponse(new UserResource($user), 'User password updated successfully.');*/
    }
    protected function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($photo = $request->file('photo')) {
            $destinationPath = 'photo/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $user = \Auth::user();
            $user->photo = "photo/".$profileImage;
        }
        $user->save();

        return $this->sendResponse(new UserResource($user), 'User Photo Profile updated successfully.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'component' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = \Auth::user();
        $user->name = $input['name'];
        $user->birth_place = $input['birth_place'];
        $user->birth_date = $input['birth_date'];
        $user->phone = $input['phone'];
        $user->address = $input['address'];
        $user->component = $input['component'];
        $user->save();
   
        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }
   
}
