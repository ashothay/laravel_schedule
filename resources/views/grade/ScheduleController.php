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
                    @foreach($grade->schedule->groupBy('period_id') as $period_id => $daySchedule)
                        <tr>
                            <td class="font-weight-bold">
                                {{ $periods->find($period_id)->starts_at }} <br>
                                - <br>
                                {{ $periods->find($period_id)->ends_at }}
                            </td>
                            @php
                                $lessonsByWeekday = $daySchedule->groupBy('weekday');
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
                                        <br>
                                        <button onclick="$('#delete-schedule-{{ $lesson->id }}').submit()" class="btn btn-sm btn-outline-danger">Remove</button>
                                        <form id="delete-schedule-{{ $lesson->id }}"class="d-none" action="{{ route('schedule.destroy', $lesson->id) }}}" method="post">
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
