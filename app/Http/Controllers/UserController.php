<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use DB;
class UserController extends Controller
{
    public function tes(Request $request){
        return response()->json('lalasdfaf', 200);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'role_id' => 'required|string|max:255',
            'opd' => 'required|string|max:255',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email'),
            'role_id' => $request->get('role_id'),
            'opd' => $request->get('opd'),
        ]);

        $token = app('auth')->attempt($request->only('username', 'password'));

         return response()->json(compact('user','token'),201);
    }
    public function login(Request $request){
        // $token = app('auth')->attempt($request->only('email', 'password'));
 
        // return $this->success(response()->json(compact('token')), 200);
        //$user = User::where('email', $this->request->input('email'))->first();
        // return response()->json([
        //     'error' => 'Email or password is wrong.'
        // ], 400);

        $token = app('auth')->attempt($request->only('username', 'password'));
        return response()->json(compact('token'));

    }

    public function logout(Request $request){
        try
        {
            $this->validate($request,['token'=> 'required']);
            JWTAuth::invalidate(JWTAuth::getToken());
            //app('auth')->invalidate($request->input('token'));
            return response()->json(['sukses' => true,'pesan'=>'Berhasil Logout']);
        }
        catch(\Exception $e)
        {
            return response()->json(['sukses'=>false, 'pesan'=>'Gagal Logout'], $e->getStatusCode());
        }
    }
    public function getProfile(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $opd = DB::table('master_skpd')->where('kode_skpd', '=', $user['opd'])->select('nama_skpd')->first();
                 return response()->json(['user'=>$user, 'opd' => $opd]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    // public function file(Request $request)
    // {
    //     // return response()->json($request->get('pinjamRuangan'));

    //     if ($request->hasFile('file')) {
    //         $file      = $request->file('file');
    //         $filename  = $file->getClientOriginalName();
    //         $extension = $file->getClientOriginalExtension();
    //         $picture   = date('His').'-'.$filename;
    //         $file->storeAs(
    //             'avatars', "1234");
    //         //\Storage::disk('local')->put('file.txt', 'Contents');
    //         //$file->store('logos');
    //         //$file->move(public_path('img'), $picture);
    //         return response()->json($filename);
    //     } 
    //     return response()->json("gagal");
    // }
}