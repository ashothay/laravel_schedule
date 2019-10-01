<?php

namespace App\Http\Requests;

use App\Lesson;
use App\Role\UserRole;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LessonRequest extends FormRequest
{
    /**
     * Indicates if starts_at - ends_at period intersects with already added lessons periods.
     *
     * @var array
     */
    public $intersects = false;

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
     * Determine if the starts_at - ends_at period intersects with already added lessons periods.
     *
     * @return void
     */
    private function validatePeriod()
    {
        try {
            $request = request();
            $lessons = Lesson::query()
                ->where('weekday', '=', $request->weekday)
                ->where('grade_id', '=', $request->grade_id)
                ->get();
            $start_date = strtotime($request->starts_at);
            $end_date = strtotime($request->ends_at);
            foreach ($lessons as $lesson) {
                if (($lesson->start_date <= $start_date && $start_date < $lesson->end_date) ||
                    ($lesson->start_date < $end_date && $end_date <= $lesson->end_date) ||
                    ($lesson->start_date >= $start_date && $end_date >= $lesson->end_date)) {
                    $this->intersects = true;
                }
            }
        } catch (Exception $e) {
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->validatePeriod();

        return [
            'grade_id' => ['required', 'exists:grades,id'],
            'weekday' => ['required', 'gte:0', 'lte:4'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'starts_at' => ['required', 'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if ($this->intersects) {
                        $fail(':attribute value intersects with another lesson\'s period.');
                    }
                },],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at',
                function ($attribute, $value, $fail) {
                    if ($this->intersects) {
                        $fail(':attribute value intersects with another lesson\'s period.');
                    }
                },],
        ];
    }
}
