<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat with AI Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h3 class="mb-4">Chat with AI Assistant</h3>

        <!-- Chat display box -->
        <div id="chat-box" class="border p-3 mb-3 bg-white" style="height: 300px; overflow-y: auto; border-radius: 8px;">
            <!-- Messages will appear here -->
        </div>

        <!-- Chat form -->
        <form id="chat-form">
            <div class="input-group">
                <input type="text" id="message" class="form-control" placeholder="Type your message..." required>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const chatBox = document.getElementById('chat-box');
        const apiUrl = "{{ url('/api/chat') }}"; // Laravel-safe dynamic API URL

        chatForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const messageInput = document.getElementById('message');
            const message = messageInput.value.trim();
            if (!message) return;

            // Display user message
            chatBox.innerHTML += `<div><strong>You:</strong> ${message}</div>`;
            messageInput.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error ${response.status}`);
                }

                const data = await response.json();

                // Display AI response
                chatBox.innerHTML += `<div><strong>AI:</strong> ${data.reply}</div>`;
                chatBox.scrollTop = chatBox.scrollHeight;

            } catch (err) {
                console.error('Chat error:', err);
                chatBox.innerHTML += `<div class="text-danger"><strong>Error:</strong> Could not connect to AI. Check your Laravel server or OpenAI key.</div>`;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>
</body>
</html>
