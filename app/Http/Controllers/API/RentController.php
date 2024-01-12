<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\RentResource;
use Illuminate\Http\JsonResponse;

class RentController extends BaseController
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        //bikin status diketahui && relasi muncul di end point
        $userId = \Auth::user()->id;
        $rent = Rent::where('users_id', $userId)->get();
    
        return $this->sendResponse(
            RentResource::collection($rent)->toArray($request),
            'Rent retrieved successfully.'
        );
    }
    //push notif || notif list (api all notificatioon unread)
    /*public function notice(Request $request): JsonResponse
    {
        
    }*/
    //(continous api)Notifikasi overdue books $rent = Rent::where('users_id', $userId)->get(); $rent = $rent->where('date_due', '>', Carbon::now());
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'books_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = \Auth::user();
        $arraynull = [];
        if (!$user->name) {
            $arraynull[] = "Nama";
        }
        if (!$user->email) {
            $arraynull[] = "Email";
        }
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
            return $this->sendError('profile belum lengkap.', $arraynull, 422);
        }
        $input['user_id'] = \Auth::user()->id;
   
        $rent = Rent::create($input);
        // $rent = new Rent;
        // $rent->fill($input);
        // $rent->date_request = Carbon::now();
        // $rent->save();
   
        return $this->sendResponse(new RentResource($rent), 'Rent created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $rent = Rent::find($id);
  
        if (is_null($rent)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new RentResource($rent), 'Product retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent): JsonResponse
    {
        //soft-delete
        $rent->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
