<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();
            // 　google_idが合致するユーザーを取得
            $finduser = User::where('google_id', $user->id)->first();
        
            if($finduser){
                // ログイン処理
                Auth::login($finduser);
        
                return redirect()->intended('home');
        
            }else{
                // 見つからなければ新しくユーザーを作成
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
                // ログイン処理
                Auth::login($newUser);
        
                return redirect()->intended('home');
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}


