<?php

namespace App\Http\Requests;

use App\Role\UserRole;
use App\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::guest() && Auth::user()->hasRole(UserRole::ROLE_ADMIN);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grade_id' => ['required', 'exists:grades,id'],
            'weekday' => ['required', 'gte:0', 'lte:4'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at'],
        ];
    }
}
