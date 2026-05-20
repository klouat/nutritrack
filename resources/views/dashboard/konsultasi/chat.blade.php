@extends('dashboard.sidebar')

@section('title', 'Konsultasi')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Chat dengan {{ ucfirst(str_replace('_', ' ', $role)) }}</h2>
    
    <div id="chat-box" class="border rounded-lg p-4 h-96 overflow-y-auto bg-white mb-4">
        @foreach($messages as $msg)
            <div class="{{ $msg->from_id == Auth::id() ? 'text-right' : 'text-left' }}">
                <p class="inline-block px-4 py-2 rounded-lg {{ $msg->from_id == Auth::id() ? 'bg-blue-100' : 'bg-gray-200' }}">
                    {{ $msg->message }}
                </p>
            </div>
        @endforeach
    </div>

    <form id="chat-form">
        @csrf
        <input type="hidden" name="to_role" value="{{ $role }}">
        <div class="flex gap-2">
            <input type="text" name="message" class="w-full border rounded px-3 py-2" placeholder="Ketik pesan..." required>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Kirim</button>
        </div>
    </form>
</div>
<script>
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const message = formData.get('message');
    const toRole = formData.get('to_role');

    // Kirim pesan ke server via AJAX
    fetch("{{ route('konsultasi.send') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const chatBox = document.getElementById('chat-box');
            const msgElement = document.createElement('div');
            msgElement.className = "text-right";
            msgElement.innerHTML = `<p class="inline-block px-4 py-2 rounded-lg bg-blue-100">${message}</p>`;
            chatBox.appendChild(msgElement);
            chatBox.scrollTop = chatBox.scrollHeight;
            form.reset();
        } else {
            console.log('Message sending failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
function fetchMessages() {
    fetch("{{ route('konsultasi.fetch', $role) }}")
        .then(response => response.json())
        .then(messages => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = ''; // kosongkan isi chat

            messages.forEach(msg => {
                const msgElement = document.createElement('div');
                const isMe = msg.from_id == {{ Auth::id() }} ? 'text-right' : 'text-left';
                const bubbleClass = msg.from_id == {{ Auth::id() }} ? 'bg-blue-100' : 'bg-gray-200';

                msgElement.className = isMe;
                msgElement.innerHTML = `<p class="inline-block px-4 py-2 rounded-lg ${bubbleClass}">${msg.message}</p>`;
                chatBox.appendChild(msgElement);
            });

            chatBox.scrollTop = chatBox.scrollHeight;
        });
}
fetchMessages();
setInterval(fetchMessages, 1000);
</script>

@endsection
