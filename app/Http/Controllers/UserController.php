<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use JWTAuthException;
use Auth;
use Storage;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }
    public function register(Request $request){
        $user = $this->user->create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);
        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }
    
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['invalid_email_or_password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function getAuthUser(Request $request){

        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }
    public function prueba(Request $request){

        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));
        
            Storage::disk('local')->makeDirectory($user->id.'/'.$request->mascota_id);
            $consecutivo=count(Storage::disk('local')->files($user->id.'/'.$request->mascota_id));
            $consecutivo=$consecutivo+1;
         $path = $request->file('files')->storeAs(
            $user->id.'/'.$request->mascota_id, $request->mascota_name.'_'.$request->mascota_id.'_'.$consecutivo
        );
         return response()->json(['archivo creado exitosamente con el consecutivo' => $user]);
    }    
}
