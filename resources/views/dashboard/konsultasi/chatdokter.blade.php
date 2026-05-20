@extends('dashboard.sidebar')

@section('title', 'Chat dengan Pengguna')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Chat dengan Pengguna</h2>
    
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
        <input type="hidden" name="to_id" value="{{ $userId }}">
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
    fetch("{{ route('konsultasi.fetch.user', $userId) }}")
        .then(response => response.json())
        .then(messages => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';

            messages.forEach(msg => {
                const isMe = msg.from_id == {{ Auth::id() }};
                const bubbleClass = isMe ? 'bg-blue-100' : 'bg-gray-200';
                const alignClass = isMe ? 'text-right' : 'text-left';

                const div = document.createElement('div');
                div.className = alignClass;

                const p = document.createElement('p');
                p.className = `inline-block px-4 py-2 rounded-lg ${bubbleClass}`;
                p.textContent = msg.message;

                div.appendChild(p);
                chatBox.appendChild(div);
            });

            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.error('Polling error:', error));
}
fetchMessages();
setInterval(fetchMessages, 1000);
</script>

@endsection
