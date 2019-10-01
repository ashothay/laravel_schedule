@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Schedule of Class {{ $grade->name }}</div>

            <div class="card-body">

                <div class="schedule d-flex align-items-stretch" style="height:800px">
                    @foreach([0, 1, 2, 3, 4] as $weekday)
                        <div class="d-flex flex-column flex-grow-1 border border-light">
                            <div class="font-weight-bold text-center">{{ jddayofweek($weekday, 1) }}</div>
                            <div class="h-100" style="position:relative">
                                @foreach($grade->lessons->where('weekday', $weekday) as $i => $lesson)
                                    <div
                                        class="schedule__lesson d-flex flex-column justify-content-center align-items-center text-white {{ $i % 2 ? 'bg-info' : 'bg-primary' }}"
                                        style="
                                            height: {{ (strtotime($lesson->ends_at) - strtotime($lesson->starts_at)) * 100 / $schedule['duration'] }}%;
                                            top: {{ (strtotime($lesson->starts_at) - $schedule['starts_at']) * 100 / $schedule['duration'] }}%;
                                            ">
                                        <span class="lead font-weight-bold">{{ $lesson->subject->name }}</span>
                                        <small>{{ $lesson->teacher->name }}</small>
                                        <small>{{ $lesson->starts_at }} - {{ $lesson->ends_at }}</small>
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
