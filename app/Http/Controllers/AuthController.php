<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthInterface;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Responces\ApiResponce;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function register(RegisterRequest $request)
    {
        
        // return $request;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,

        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->register($data);
            Mail::to($request->email)->send(new RegisterMail($request->name));
            DB::commit();
            return ApiResponce::sendResponse(
                true,
                [new UserResource($user)],
                'Opération effectuée.'
            );
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $th;
            return ApiResponce::rollback($th);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->login($data);
            DB::commit();

            if ($user) {
                $userVerified = User::where('email', $data['email'])->first();
                $userVerified->token = $userVerified->createToken($userVerified->id)->plainTextToken;
                return ApiResponce::sendResponse(
                    $user,
                    $userVerified,
                    'Connexion réussie.',
                    $user ? 200 : 401
                );
            } else {
                return ApiResponce::sendResponse(
                    $user,
                    [],
                    'Informations incorrectes.',
                    $user ? 200 : 401
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return ApiResponce::rollback($th);
        }
    }
}
