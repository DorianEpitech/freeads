<x-app-layout>
    <form method="POST" action="{{ url('newmessage/send') }}">
        @csrf
    
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" required></textarea>
        </div>
    
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
        <input type="hidden" name="sender_id" value="{{ auth()->user()->id }}">
    
        <button type="submit" class="btn btn-primary btn-outline">Send</button>
    </form>
    
</x-app-layout>