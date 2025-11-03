<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'rating' => ['required','integer','min:1','max:5'],
            'title'  => ['nullable','string','max:150'],
            'body'   => ['nullable','string','max:5000'],
            'author_name'  => ['nullable','string','max:120'],
            'author_email' => ['nullable','email','max:150'],
        ];
    }
}
