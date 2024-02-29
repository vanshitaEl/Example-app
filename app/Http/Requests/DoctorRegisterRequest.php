<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class DoctorRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'psw' => 'required|min:5|max:12'
        ];
    }
    
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');
            $doctor = Doctor::where('email', '=', $email)->with(['verfiyToken'])->first();
            if (isset($doctor)) {
                if ($doctor->status == 'pending') {
                    if (isset($doctor->verfiyToken)) {
                        $validator->errors()->add('email', __('lang.please_verify'));
                    }
                } else if ($doctor->status == 'active') {
                    $validator->errors()->add('email',  __('lang.please_login'));
                } else {
                    $validator->errors()->add('email',  __('lang.email_used'));
                }
            }
        });

        return $validator;
    }
}
