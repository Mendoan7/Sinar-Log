<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'pembayaran' => [
                'required',
            ],
            'garansi' => [
                'required',
            ],
            'pengambil' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'pembayaran.required' => 'Pembayaran harus diisi',
            'garansi.required' => 'Garansi harus diisi',
            'pengambil.required' => 'Pengambil harus diisi',
        ];
    }
}
