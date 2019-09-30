@php
    $message_types = [
        'danger' => 'Error',
        'warning' => 'Warning',
        'success' => 'Success',
        'info' => 'Info',
    ];
@endphp

@foreach ($message_types as $message_type => $message_title)
    @if(session($message_type))
        <div class="alert alert-{{ $message_type }} alert-dismissible fade show" role="alert">
            <strong>{{ $message_title }}!</strong> {{ session($message_type) }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach