<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Rules\EmailOrUserRule;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends BaseRequest
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
            'email' => [
                'required',
                'email',
                // new EmailOrUserRule,
            ],
            'password' => [
                'string',
                Password::min(8)->numbers()->mixedCase()->symbols(),
            ],
        ];
    }
}
