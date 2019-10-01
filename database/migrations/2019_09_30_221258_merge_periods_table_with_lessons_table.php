<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MergePeriodsTableWithLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->time('starts_at')->nullable();
            $table->time('ends_at')->nullable();
        });
        Schema::table('lessons', function (Blueprint $table) {
            $lessons = DB::table('lessons')->get();
            foreach ($lessons as $lesson) {
                $period = DB::table('periods')->find($lesson->period_id);
                DB::table('lessons')
                    ->where('id', $lesson->id)
                    ->update([
                        'starts_at' => $period->starts_at,
                        'ends_at' => $period->ends_at,
                    ]);
            }

            $table->dropForeign('schedules_period_id_foreign');
            $table->dropColumn('period_id');
        });
        Schema::table('periods', function (Blueprint $table) {
            $table->drop();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('starts_at')->nullable();
            $table->time('ends_at')->nullable();
            $table->timestamps();
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->unsignedBigInteger('period_id');
        });

        $lessons = DB::table('lessons')->get();
        $date = date("Y-m-d H:i:s");
        foreach ($lessons as $lesson) {
            DB::table('periods')
                ->updateOrInsert([
                    'starts_at' => $lesson->starts_at,
                    'ends_at' => $lesson->ends_at,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
        }
        $periods = DB::table('periods')->get();
        foreach ($periods as $period) {
            DB::table('lessons')
                ->where('starts_at', $period->starts_at)
                ->where('ends_at', $period->ends_at)
                ->update([
                    'period_id' => $period->id
                ]);
        }
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('ends_at');
            $table->foreign('period_id', 'schedules_period_id_foreign')->references('id')->on('periods')->onDelete('cascade');
        });
    }
}
