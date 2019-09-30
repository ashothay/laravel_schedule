<?php

use App\Grade;
use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grade::query()->delete();
        for ($grade = 1; $grade <= 12; $grade++) {
            $gradeGroups = ['a', 'b', 'c', 'd', 'e'];
            $gradeGroupsQuantity = rand(min(3, count($gradeGroups) - 1), count($gradeGroups));
            for ($gradeGroupId = 0; $gradeGroupId < $gradeGroupsQuantity; $gradeGroupId++) {
                Grade::create(['name' => $grade . '.' . $gradeGroups[$gradeGroupId]]);
            }
        }
    }
}
