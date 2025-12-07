<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],
            'title' => [
                'nullable',
                'string',
                'max:150'
            ],
            'body' => [
                'nullable',
                'string',
                'max:5000'
            ],
            'author_name' => [
                'required',
                'string',
                'max:120'
            ],
            'author_email' => [
                'required',
                'email',
                'max:150'
            ],
        ];
    }
}
