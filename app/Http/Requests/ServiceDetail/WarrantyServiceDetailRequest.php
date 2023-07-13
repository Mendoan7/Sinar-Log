<?php

namespace App\Http\Requests\ServiceDetail;

use Illuminate\Foundation\Http\FormRequest;

class WarrantyServiceDetailRequest extends FormRequest
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
            'kondisi' => [
                'required',
            ],
            'tindakan' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'kondisi.required' => 'Kondisi barang harus diisi',
            'tindakan.required' => 'Tindakan harus diisi',
        ];
    }
}
