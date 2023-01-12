<?php

namespace App\Http\Controllers\auth;

use App\Helpers\AuditHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\setting\Role;
use App\Models\setting\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'status' => @$request->status,
            'password' => Hash::make($request->password),
        ]);


        return ResponseHelper::Get($user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if(Auth::attempt(['email' => @$request->email, 'password' => @$request->password], true)){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            
            $modules = $this->getModules();
            
            $audit = new AuditHelper;
            $audit->auditLogin(1);
            
            return response(['success' => true, 'token'=>$token,'user' => Auth::user(),'modules' => $modules,'token_type' => 'bearer', 'expires_in' => 60 * 24, 'date' => Carbon::now()], Response::HTTP_OK)->withoutCookie($cookie);

            
        }

        return ResponseHelper::Unauthorized('Credenciales incorrectas');
    }

    /**
     * .
     */
    public function logout()
    {
        $audit = new AuditHelper;
        $audit->auditLogin(2);
        
        $cookie = Cookie::forget('cookie_token');

        return response(Response::HTTP_OK)->withCookie($cookie);
    }

    /**
     * .
     */
    public function userProfile()
    {
        return ResponseHelper::Get(auth()->user());
    }


    public function userAll(Request $request)
    {
        return ResponseHelper::Get(User::all());
    }

    public function getModules()
    {
        return Role::with(['modules'=> function ($query) { 
            $query->where('modules_for_roles.selected','1');
        }])->where('id',Auth::user()->id_role)->get();
    }

}
