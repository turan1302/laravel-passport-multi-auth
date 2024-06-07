<?php

namespace App\Http\Controllers\api\auth\user;

use App\Http\Controllers\api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class indexController extends BaseController
{
    public function login(Request $request)
    {
        $data = $request->except("_token");

        $user = User::where("email",$data['email'])->first();

        if ($user && Hash::check($data['password'],$user->password)){
            $token = $user->createToken('youtubeToken')->accessToken;

            return parent::success("Kullanıcı Giriş İşlemi Başarılı",[
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "token_type" => "Bearer",
                "acces_token" => $token
            ]);

        }else{
            return parent::error("Kullanıcı Bilgileri Hatalı",[],401);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->except("_token","password_confirmation");

        $user = User::create($data);

        if ($user){
            return parent::success("Kullanıcı Oluşturuldu. Bilgilerinizle Giriş Yapabilirsiniz",[
                "user" => $user
            ],201);
        }else{
            return parent::error("Kullanıcı Oluşturulurken Hata Oluştu",[],500);
        }
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return parent::success("Kullanıcı Bilgileri Getirildi",[
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $token = $user->token();
        $token->revoke();

        return parent::success("Çıkış Gerçekleştirildi",[],200);
    }
}
