@php
    if ($messages[0]->sender_id == auth()->user()->id) {

        $contactName = $messages[0]->receiver->name;
        $contactId = $messages[0]->receiver_id;
    } else {
    
        $contactName = $messages[0]->sender->name;
        $contactId = $messages[0]->sender_id;
    }
@endphp

<x-app-layout>
    <h3 class="flex justify-content-center mt-4 overflow-hidden">Conversation with {{ $contactName }}</h3>
    <div class="flex justify-content-center mt-4 overflow-hidden">
        <div class="col-md-8 overflow-hidden">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-unstyled" style="max-height: 550px; overflow-y: scroll;">
                                @foreach ($messages as $message)
                                <li class="media mb-4 @if($message->sender_id == auth()->user()->id) justify-content-end @endif">
                                    <div class="media-body @if($message->sender_id == auth()->user()->id) text-right @endif">
                                        <div class="bg-light rounded py-2 px-3 mb-2">
                                            <p class="text-small mb-0 text-muted">{{ $message->message }}</p>
                                        </div>
                                        <small style="padding: 10px" class="small text-muted">{{ ($message->sender_id == auth()->user()->id) ? 'You' : $message->sender->name }} | {{ $message->created_at->diffForHumans() }}</small>

                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ url('newmessage/send') }}" class="mt-4">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $contactId }}">
                <input type="hidden" name="sender_id" value="{{ auth()->user()->id }}">
                <div class="form-group">
                    <textarea name="message" class="form-control mb-2" rows="3" placeholder="Write your message here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    window.onload = function() {
        
        console.log('test');
        let conversation = document.querySelector('.list-unstyled');
        conversation.scrollTop = conversation.scrollHeight;
    }
</script>