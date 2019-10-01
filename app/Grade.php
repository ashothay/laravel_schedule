<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function lessons() {
        return $this->hasMany(Lesson::class)->orderBy('weekday')->orderBy('starts_at');
    }
}
