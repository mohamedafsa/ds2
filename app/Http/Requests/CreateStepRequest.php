<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStepRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && $this->goal->user_id === auth()->id();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ];
    }
}