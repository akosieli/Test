    const chatIcon = document.getElementById('chat-icon');
    const chatBox = document.getElementById('chat-box');
    const closeBtn = document.getElementById('close-btn');
    const chatContainer = document.getElementById('chat-container');

    // Show chat box
    chatIcon.addEventListener('click', () => {
        chatBox.style.display = 'flex';
        chatIcon.style.display = 'none';
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });

    // Close chat box
    closeBtn.addEventListener('click', () => {
        chatBox.style.display = 'none';
        chatIcon.style.display = 'block';
    });

    // Auto-scroll to bottom
    chatContainer.scrollTop = chatContainer.scrollHeight;


     const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('open') === '1') {
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('chat-box').style.display = 'flex';
                chatContainer.scrollTop = chatContainer.scrollHeight;
            });
        }

    