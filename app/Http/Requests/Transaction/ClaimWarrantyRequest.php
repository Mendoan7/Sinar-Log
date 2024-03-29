<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class ClaimWarrantyRequest extends FormRequest
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
            'keterangan' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'keterangan.required' => 'Keterangan Harus Diisi Terlebih Dahulu'
        ];
    }
}
