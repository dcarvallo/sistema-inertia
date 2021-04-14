<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;

class LoginResponse implements ContractsLoginResponse
{
    public function toResponse($request)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            return redirect()->intended(config('fortify.home'));
        }
        return redirect()->intended(config('fortify.admin'));
    }
}