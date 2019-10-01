@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                Schedule of Class {{ $grade->name }}

                <div class="float-right">
                    @can('update', $grade)
                        <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                    @endcan
                    @can('delete', $grade)
                        <button onclick="$('#delete-class-{{ $grade->id }}').submit()"
                                class="btn btn-sm btn-outline-danger">Delete
                        </button>
                        <form id="delete-class-{{ $grade->id }}" action="{{ route('grades.destroy', $grade->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endcan
                </div>
            </div>

            <div class="card-body">

                <div class="schedule d-flex align-items-stretch" style="height:800px">
                    @foreach([0, 1, 2, 3, 4] as $weekday)
                        <div class="d-flex flex-column flex-grow-1 border border-light">
                            <div class="font-weight-bold text-center mb-3">{{ jddayofweek($weekday, 1) }}</div>
                            <div class="h-100 position-relative">
                                @foreach($grade->lessons->where('weekday', $weekday) as $i => $lesson)
                                    <div
                                        href="{{ route('lessons.edit', $lesson->id) }}"
                                        class="schedule__lesson d-flex flex-column justify-content-center align-items-center text-white {{ $i % 2 ? 'bg-info' : 'bg-primary' }}  }} "
                                        style="
                                            height: {{ (strtotime($lesson->ends_at) - strtotime($lesson->starts_at)) * 100 / $schedule['duration'] }}%;
                                            top: {{ (strtotime($lesson->starts_at) - $schedule['starts_at']) * 100 / $schedule['duration'] }}%;
                                            ">
                                        <span class="lead font-weight-bold">{{ $lesson->subject->name }}</span>
                                        <small>{{ $lesson->teacher->name }}</small>
                                        <small>{{ $lesson->starts_at }} - {{ $lesson->ends_at }}</small>
                                        @can('update', $lesson)
                                            <a href="{{ route('lessons.edit', $lesson->id) }}"
                                               title="Edit lesson." class="schedule__lesson-edit"></a>
                                        @endcan
                                        @can('delete', $lesson)
                                            <button onclick="$('#delete-lesson-{{ $lesson->id }}').submit()"
                                               title="Delete lesson from Schedule." class="btn rounded-0 btn-danger schedule__lesson-delete">&times;</button>

                                            <form id="delete-lesson-{{ $lesson->id }}" action="{{ route('lessons.destroy', $lesson->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </div>
                            @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        var lessonMinHeight = 120;
        $('.schedule').each(function() {
            var lessonSmallestHeight = Infinity;
            $(this).find('.schedule__lesson').each(function() {
                var height = $(this).height();
                if (height < lessonSmallestHeight ) {
                    lessonSmallestHeight = height;
                }
            });
            if (lessonSmallestHeight < lessonMinHeight) {
                $(this).css('height', lessonMinHeight / lessonSmallestHeight * $(this).height() + 'px')
            }
        });
    });
</script>
@endpush
