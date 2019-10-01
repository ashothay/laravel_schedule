<?php

use App\Grade;
use App\Period;
use App\Lesson;
use App\Subject;
use App\User;
use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = User::pluck('id');
        $teachersCount = count($teachers);
        $subjects = Subject::pluck('id');
        $subjectsCount = count($subjects);
        foreach (Grade::pluck('id') as $grade_id) {
            for ($weekday = 0; $weekday < 5; $weekday++) {
                for ($starts_at = 28800; $starts_at < 56000; $starts_at += 3600) {
                    if (rand(0, 2) !== 0) {
                        continue;
                    }
                    Lesson::create([
                        'weekday' => $weekday,
                        'grade_id' => $grade_id,
                        'teacher_id' => $teachers[rand(0, $teachersCount - 1)],
                        'subject_id' => $subjects[rand(0, $subjectsCount - 1)],
                        'starts_at' => date('H:i', $starts_at),
                        'ends_at' => date('H:i', $starts_at + 2700),
                    ]);
                }
            }
        }
    }
}
