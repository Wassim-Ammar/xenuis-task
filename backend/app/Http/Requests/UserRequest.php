<?php

namespace App\Http\Requests;

use App\Http\Responses\ApiResponse;
use App\Http\Responses\GeneralResponse;
use App\Models\Candidat;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|string|unique:users',
                'password' => 'required|string',
                'address' => 'required|string|',
                'mobile' => 'required|string',

            ])
        ];
    }

    public function store(): bool
    {
        $this->validated();
        $user = new User([
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => 2,
        ]);
        $user->save();

        $candidat = new Candidat((['name'  => $this->name, 'surname' => $this->surname, 'address' => $this->address, 'mobile' => $this->mobile, 'createCv' => false, 'user_id' => $user->id, 'applyToAnOffer' => false]));

        event(new Registered($user));

        if ($user->save() && $candidat->save()) {
            Auth::login($user);

            return true;
        }

        return false;
    }

    public function update($user)
    {

        $this->validated();

        User::where('id', $user->id)->update([
            'name' => $this->name,
            'surname' => $this->surname,
            'cin' => $this->cin,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'city' => $this->city,
            'address' => $this->address,
            'permission' => $this->permission,
            'state' => $this->state,

        ]);
    }
}
