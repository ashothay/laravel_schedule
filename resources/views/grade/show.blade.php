@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Schedule of Class {{ $grade->name }}</div>

            <div class="card-body">

                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                    <tr>
                        <td></td>
                        @foreach([0,1,2,3,4] as $weekday)
                            <td>{{ $weekday }}</td>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $lessonsByPeriod = $grade->schedule->groupBy('period_id')
                    @endphp
                    @foreach($periods as $period)
                        @php
                            if ($lessonsByPeriod->has($period->id)) {
                                $periodLessons = $lessonsByPeriod[$period->id][0];
                            } else {
                                $periodLessons = null;
                            }
                        @endphp
                        <tr>
                            <td class="font-weight-bold">
                                {{ $period->starts_at }} <br>
                                - <br>
                                {{ $period->ends_at }}
                            </td>
                            @php
                                $lessonsByWeekday = $lessonsByPeriod[$period->id]->groupBy('weekday');
                            @endphp
                            @foreach([0,1,2,3,4] as $weekday)
                                @php
                                    if ($lessonsByWeekday->has($weekday)) {
                                        $lesson = $lessonsByWeekday[$weekday][0];
                                    } else {
                                        $lesson = null;
                                    }
                                @endphp
                                @if( isset($lesson))
                                    <td>
                                        <span class="font-weight-bold lead">{{ $lesson->subject->name }}</span> <br>
                                        <small>{{ $lesson->teacher->name }}</small>
                                        <small>{{ $lesson->period->starts_at }}</small>
                                        <small>{{ $lesson->weekday }}</small>
                                        <br>
                                        <a href="{{ route('schedules.edit', $lesson->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <button onclick="$('#delete-schedule-{{ $lesson->id }}').submit()" class="btn btn-sm btn-outline-danger">Remove</button>
                                        <form id="delete-schedule-{{ $lesson->id }}"class="d-none" action="{{ route('schedules.destroy', $lesson->id) }}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
@endsection
