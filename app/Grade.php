<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function lessons() {
        return $this->hasMany(Lesson::class)->orderBy('weekday')->orderBy('starts_at');
    }
}
