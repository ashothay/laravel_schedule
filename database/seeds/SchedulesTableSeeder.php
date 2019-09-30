<?php

use App\Grade;
use App\Period;
use App\Schedule;
use App\Subject;
use App\User;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
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
                foreach(Period::all()->random(5)->pluck('id') as $period_id) {
                    Schedule::create([
                        'weekday' => $weekday,
                        'grade_id' => $grade_id,
                        'teacher_id' => $teachers[rand(0, $teachersCount - 1)],
                        'subject_id' => $subjects[rand(0, $subjectsCount - 1)],
                        'period_id' => $period_id
                    ]);
                }
            }
        }
    }
}
