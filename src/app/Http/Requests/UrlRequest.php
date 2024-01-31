<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UrlRequest extends FormRequest
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
    public function rules()
    {
        return [
            'urls' => 'required|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $urls = explode("\n", trim($this->urls));

            foreach ($urls as $url) {
                if (!filter_var(trim($url), FILTER_VALIDATE_URL)) {
                    $validator->errors()->add('urls', $url . ' is not a valid URL.');
                    Log::warning('Invalid URL: ' . $url);
                }
            }
        });
    }
}
