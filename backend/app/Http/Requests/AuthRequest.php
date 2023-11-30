<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            $this->validate([
                'email' => 'required',
                'password' => 'required',
            ]),
        ];
    }

    public function authenticate(): bool
    {
        $this->validated();

        if (Auth::attempt($this->toArray())) {
            $this->session()->regenerate();

            return true;
        }

        return false;
    }
}
