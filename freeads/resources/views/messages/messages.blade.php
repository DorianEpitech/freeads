<?php use Carbon\Carbon; ?>

<x-app-layout>
    <div class="flex justify-content-center mt-4">
        <div class="col-4">
            <ul class="list-group">
                @foreach ($conversations as $conversation)
                <li class="list-group-item">
                    <a href="{{ route('conversation', ['receiver_id' => $conversation['contact_id']]) }}">{{ $conversation['contact_name'] }}</a>
                        <div class="d-flex justify-content-between">
                            @php $date = $conversation['last_message_time'] @endphp
                            <small>Last activity: {{ Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans() }}</small>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>