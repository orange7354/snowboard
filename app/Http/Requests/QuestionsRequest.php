<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:255',
            'user_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpg,png,mp4',
            'video' => 'nullable|file|mimes:mp4'

        ];
    }
}
