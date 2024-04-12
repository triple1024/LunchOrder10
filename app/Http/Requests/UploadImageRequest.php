<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image'=>'image|mimes:jpg,jpg,jpeg,png|max:2048',
            'files.*.image'=>'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'image'=> '指定されたファイルが画像ではありません。',
            'mimes'=> '指定された拡張子(jpg/jpeg/png)ではありません',
            'max'=> 'ファイルサイズは2MB以内にして下さい',
        ];

    }
}
