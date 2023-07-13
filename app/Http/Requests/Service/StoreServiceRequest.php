<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => [
                'required', 'string',
            ],
            'jenis' => [
                'required','string', 'max:255',
            ],
            'tipe' => [
                'required', 'string', 'max:255',
            ],
            'kelengkapan' => [
                'required', 'string', 'max:255',
            ],
            'kerusakan' => [
                'required','string', 'max:255',
            ],
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Harus memilih customer',
            'jenis.required' => 'Jenis harus diisi',
            'tipe.required' => 'Tipe harus diisi',
            'kelengkapan.required' => 'Kelengkapan harus diisi',
            'kerusakan.required' => 'Kerusakan harus diisi'
        ];
    }
}
