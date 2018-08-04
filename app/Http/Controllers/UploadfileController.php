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
use File;
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
            
            $image = $request->file;

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            echo storage_path();
            File::put(storage_path(). '/app/' . $user->id.'/'.$request->id, base64_decode($image));
            
          return response()->json(['archivo creado exitosamente' => $request]);
    }  
    public function pruebab64(Request $request){

        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));        
            Storage::disk('local')->makeDirectory($user->id.'/pruebafff'.$request->id);
//            $imagen=DB::table('mascotas')->select('imagenes')->where('id',$request->id)->where('id_usuario',$user->id)->value('imagenes');
            $imagennueva='';
            $fecha=carbon::now('America/Bogota')->timestamp;
/*                 if($imagen){
                $imagennueva=$imagen.','.$fecha;
            }else{
                                
            } */
          //  DB::table('mascotas')->where('id',$request->id)->where('id_usuario',$user->id)->update(['imagenes'=>$imagennueva]);
          $imagennueva=$fecha;
          $image = $request->file;

          $image = str_replace('data:image/png;base64,', '', $image);
          $image = str_replace(' ', '+', $image);
          $imageName = str_random(10).'.'.'png';
          echo storage_path();
          File::put(storage_path(). 'ap/' . 'prueba', base64_decode($image));
         
return "";  


         return response()->json(['archivo creado exitosamente' => $request]);
    }  
    function base64_to_jpeg($base64_string,$output_file) {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb' ); 
    
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
    
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    
        // clean up the file resource
        fclose( $ifp ); 
    
        return $output_file; 
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
    public function fotousuario(Request $request){
        $user = JWTAuth::toUser(str_replace('Bearer ','',$request->header('Authorization')));
            Storage::disk('local')->makeDirectory($user->id);
            $aleatorio= rand ( 11 , 99 );
            $imagennueva='perfil'.$aleatorio;
            $path = $request->file('file')->storeAs(
            $user->id, $imagennueva
        );
        DB::table('users')->where('id',$user->id)->update(['img'=>$user->id.'/'.$imagennueva]);
         return response()->json(['suceess' => $user->id.'/'.$imagennueva]);
    }
}
