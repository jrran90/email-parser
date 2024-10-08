<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmailRequest extends FormRequest
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
            'affiliate_id' => 'required|int',
            'envelope' => 'required|string',
            'from' => 'required|string',
            'subject' => 'required|string',
            'dkim' => 'string|nullable',
            'SPF' => 'string|nullable',
            'spam_score' => 'nullable',
            'email' => 'string|required',
            'sender_ip' => 'string|nullable',
            'to' => 'string|required',
            'timestamp' => 'required|int'
        ];
    }
}
