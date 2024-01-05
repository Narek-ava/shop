<?php

namespace App\Services\ResetPassword;

use App\Models\ResetCodePassword;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Support\Str;

class ResetPasswordService
{
    /**
     * @param $email
     * @return string
     */
    public function updateOrCreateToken($email): string
{
    $token =Str::random(60);

    ResetCodePassword::updateOrCreate(
        [
            'email' => $email
        ],
        [
            'code' => $token
        ]
    );
    return $token;
}

    /**
     * @param $email
     * @param $token
     * @return bool
     */
    public function initToken($email,$token): bool
    {
        $resetCode = ResetCodePassword::query()->where('email',$email)->first()->code;
        return  $resetCode === $token;
}
}
