<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetEmail;
use App\Models\ResetCodePassword;
use App\Models\User\User;
use App\Services\ResetPassword\ResetPasswordService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordResetController extends Controller
{
    use ResetsPasswords;

    private ResetPasswordService $resetPasswordService;

    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
        $token = $this->resetPasswordService->updateOrCreateToken($request->email);
        try {
            Mail::to($request->email)->send(new ResetEmail($request->email,$token));
            return response()->json(['message' => 'Reset link sent to your email.']);
        }catch(\Exception $exception){
            return response()->json(['error' => 'Unable to send reset link.'], 422);

        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation'=> 'required|min:8'
        ]);
        $user = User::query()->where('email',$request->email);

        if ($this->resetPasswordService->initToken($request->email,$request->token)){
           $user->update([
                'password' => bcrypt((int)$request->password),
            ]);
           $this->resetPasswordService->updateOrCreateToken($request->email);;

           return response()->json(['message' => 'Password reset successfully.']);
        }

        return response()->json(['error' => 'Unable to reset password.'], 422);
    }


}
