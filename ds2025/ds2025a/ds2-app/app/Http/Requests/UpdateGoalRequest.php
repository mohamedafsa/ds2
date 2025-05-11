<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && $this->goal->user_id === auth()->id();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:studies,sport,reading,projects,health,other',
            'visibility' => 'required|in:private,friends,public',
            'deadline' => 'nullable|date',
            'progress_percentage' => 'required|numeric|between:0,100',
        ];
    }
}