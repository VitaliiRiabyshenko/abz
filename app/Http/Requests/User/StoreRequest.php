<?php

namespace App\Http\Requests\User;

use App\Rules\EmailRule;
use App\Rules\PhoneUARule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:60'],
            'email' => ['required', 'email', 'min:2', 'max:100', 'unique:users,email', new EmailRule()],
            'phone' => ['required', 'unique:users,phone', new PhoneUARule()],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'photo' => ['required', 'image', 'mimes:jpeg,jpg', 'max:5120', 'dimensions:min_width=70,min_height=70']
        ];
    }
}
