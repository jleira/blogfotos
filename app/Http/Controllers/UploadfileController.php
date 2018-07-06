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
use DB;
use Carbon\Carbon;

class UploadfileController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }
    public function uploadfile(Request $request){

        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));        
            Storage::disk('local')->makeDirectory($user->id.'/'.$request->id);
            $imagen=DB::table('mascotas')->select('imagenes')->where('id',$request->id)->where('id_usuario',$user->id)->value('imagenes');
            $imagennueva='';
            $fecha=carbon::now('America/Bogota')->timestamp;
                if($imagen){
                $imagennueva=$imagen.','.$fecha;
            }else{
                $imagennueva=$fecha;                
            }
            DB::table('mascotas')->where('id',$request->id)->where('id_usuario',$user->id)->update(['imagenes'=>$imagennueva]);
            $path = $request->file('file')->storeAs(
            $user->id.'/'.$request->id, $fecha
        );
         return response()->json(['archivo creado exitosamente' => $request]);
    }  
    public function uploadfile2(Request $request){

        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));        
            Storage::disk('local')->makeDirectory('productos/'.$user->id.'/'.$request->id);
            $imagen=DB::table('productos')->select('imagenes')->where('id',$request->id)->where('usuario_id',$user->id)->value('imagenes');
            $imagennueva='';
            $fecha=carbon::now('America/Bogota')->timestamp;
                if($imagen){
                $imagennueva=$imagen.','.$fecha;
            }else{
                $imagennueva=$fecha;                
            }
            DB::table('productos')->where('id',$request->id)->where('usuario_id',$user->id)->update(['imagenes'=>$imagennueva]);
            $path = $request->file('file')->storeAs(
            'productos/'.$user->id.'/'.$request->id, $fecha
        );
         return response()->json(['archivo creado exitosamente' => $request]);
    }       

    public function uploadfile3(Request $request){

        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));        
            Storage::disk('local')->makeDirectory('pedigree/'.$user->id);
            $imagennueva='';
            $fecha=carbon::now('America/Bogota')->timestamp;
            $aleatorio= rand ( 100 , 999 );
            $imagennueva=$fecha.$aleatorio; 
            $path = $request->file('file')->storeAs(
            'pedigree/'.$user->id, $imagennueva
        );
         return response()->json(['suceess' => 'pedigree/'.$user->id.'/'.$imagennueva]);
    }  
    public function fotochat(Request $request){

        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));        
            Storage::disk('local')->makeDirectory('mensajes/'.$user->id);
            $imagennueva='';
            $fecha=carbon::now('America/Bogota')->timestamp;
            $aleatorio= rand ( 100 , 999 );
            $imagennueva=$fecha.$aleatorio; 
            $path = $request->file('file')->storeAs(
            'mensajes/'.$user->id, $imagennueva
        );
         return response()->json(['suceess' => 'mensajes/'.$user->id.'/'.$imagennueva]);
    }  


}
