<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weekday', 'grade_id', 'subject_id', 'teacher_id', 'starts_at', 'ends_at'
    ];

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public function teacher() {
        return $this->belongsTo(User::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function getStartDateAttribute() {
        return strtotime($this->starts_at);
    }

    public function getEndDateAttribute() {
        return strtotime($this->ends_at);
    }

}
