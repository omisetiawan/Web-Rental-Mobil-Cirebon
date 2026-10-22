{{-- Aurora Chatbot Widget: Circular Signal Blue trigger, rectilinear 8px Paper White / Hailstone panel, no shadows --}}
<div id="chatbot-widget" class="fixed bottom-6 right-6 z-50">
    {{-- Toggle Button (The singular circle allowed in Aurora: 9999px radius, Signal Blue #006aed, Paper White icon) --}}
    <button type="button"
            id="chatbot-toggle"
            aria-label="Buka Asisten Virtual RentGo"
            class="w-[52px] h-[52px] bg-[#006aed] hover:bg-[#0056c7] rounded-full flex items-center justify-center text-white cursor-pointer transition-colors duration-200 border border-[#0056c7]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
    </button>

    {{-- Chat Panel (Rectilinear 8px radius, Paper White surface, 1px Mist border, zero shadow) --}}
    <div id="chatbot-container"
         role="dialog"
         aria-label="Asisten Virtual RentGo"
         class="absolute bottom-16 right-0 w-[340px] sm:w-[380px] h-[520px] bg-white rounded-[8px] hidden flex-col border border-[#d1d6e0] overflow-hidden">

        {{-- Header: Horizon Navy (#001733) field with Aurora Spectrum top bar --}}
        <div class="bg-[#001733] text-white p-4 flex justify-between items-center relative">
            <div class="absolute top-0 left-0 w-full h-[3px] aurora-spectrum-bg"></div>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-[8px] bg-[#006aed] flex items-center justify-center text-white font-semibold text-sm">
                    RG
                </div>
                <div>
                    <h3 class="font-semibold text-[14px] text-white leading-tight">Asisten RentGo</h3>
                    <p class="text-[#d1d6e0] text-[12px] flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-[#18dcdc] rounded-full"></span>
                        <span>Aktif 24 Jam</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" id="chatbot-clear" class="px-2 py-1 rounded-[4px] text-[11px] font-medium text-[#d1d6e0] hover:text-white hover:bg-white/10 transition-colors" title="Reset percakapan">
                    Reset
                </button>
                <button type="button" id="chatbot-close" class="w-8 h-8 rounded-[8px] flex items-center justify-center text-[#d1d6e0] hover:text-white hover:bg-white/10 transition-colors" aria-label="Tutup chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Messages Area: Hailstone (#f3f4f8) background --}}
        <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto bg-[#f3f4f8] space-y-3">
            <div class="flex justify-start">
                <div class="bg-white rounded-[8px] p-4 max-w-[90%] border border-[#e6e9f0]">
                    <div class="eyebrow-label !text-[10px] mb-1.5">ASISTEN RENTGO</div>
                    <p class="text-[#001733] text-[14px] leading-[1.5]">Halo, selamat datang di RentGo Cirebon. Silakan tanyakan informasi yang Anda butuhkan:</p>
                    <ul class="text-[13px] text-[#68748d] mt-2.5 space-y-1.5">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-[#006aed] rounded-full"></span>
                            <span>Ketersediaan unit & tarif harian</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-[#006aed] rounded-full"></span>
                            <span>Syarat sewa lepas kunci / dengan pengemudi</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-[#006aed] rounded-full"></span>
                            <span>Layanan antar-jemput stasiun & hotel</span>
                        </li>
                    </ul>
                    <span class="text-[11px] text-[#68748d] mt-2.5 block" id="current-time"></span>
                </div>
            </div>
        </div>

        {{-- Input Area: Paper White surface --}}
        <div class="p-3.5 border-t border-[#e6e9f0] bg-white">
            <div class="flex gap-2">
                <input type="text"
                       id="chatbot-text"
                       placeholder="Ketik pertanyaan Anda..."
                       class="input-aurora !py-2.5 flex-1">
                <button type="button"
                        id="chatbot-send"
                        class="button-pill !py-2.5 !px-4 !min-h-[40px]">
                    <span>Kirim</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeEl = document.getElementById('current-time');
    if (timeEl) {
        timeEl.textContent = new Date().toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatbotClear = document.getElementById('chatbot-clear');
    const chatbotSend = document.getElementById('chatbot-send');
    const chatbotText = document.getElementById('chatbot-text');
    const chatbotMessages = document.getElementById('chatbot-messages');

    loadChatHistory();

    function closeChat() {
        chatbotContainer.classList.add('hidden');
        chatbotContainer.classList.remove('flex');
    }

    chatbotToggle.addEventListener('click', () => {
        const isHidden = chatbotContainer.classList.contains('hidden');
        if (isHidden) {
            chatbotContainer.classList.remove('hidden');
            chatbotContainer.classList.add('flex');
            chatbotText.focus();
        } else {
            closeChat();
        }
    });

    chatbotClose.addEventListener('click', closeChat);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !chatbotContainer.classList.contains('hidden')) {
            closeChat();
        }
    });

    chatbotClear.addEventListener('click', clearChatHistory);
    chatbotSend.addEventListener('click', sendMessage);
    chatbotText.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    async function sendMessage() {
        const message = chatbotText.value.trim();
        if (!message) return;

        if (message.toLowerCase() === 'clear' || message.toLowerCase() === 'hapus') {
            clearChatHistory();
            chatbotText.value = '';
            return;
        }

        addMessage(message, 'user');
        chatbotText.value = '';
        showLoading();

        try {
            const response = await fetch('/chatbot/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            hideLoading();
            if (data.success) {
                addMessage(data.bot_response, 'bot', data.timestamp);
            } else {
                addMessage('Maaf, terjadi kendala teknis. Silakan coba lagi atau hubungi WhatsApp kami.', 'bot');
            }
            saveChatToHistory();
        } catch (error) {
            hideLoading();
            addMessage('Koneksi sedang sibuk. Silakan coba kembali.', 'bot');
            saveChatToHistory();
        }
    }

    function addMessage(text, sender, timestamp = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'}`;

        const messageBubble = document.createElement('div');
        if (sender === 'user') {
            messageBubble.className = 'bg-[#006aed] text-white rounded-[8px] p-3.5 max-w-[88%]';
        } else {
            messageBubble.className = 'bg-white text-[#001733] rounded-[8px] p-3.5 max-w-[88%] border border-[#e6e9f0]';
            const avatarDiv = document.createElement('div');
            avatarDiv.className = 'eyebrow-label !text-[10px] mb-1';
            avatarDiv.textContent = 'ASISTEN RENTGO';
            messageBubble.appendChild(avatarDiv);
        }

        const messageText = document.createElement('p');
        messageText.className = 'text-[13px] leading-[1.5]';
        if (sender === 'bot') {
            messageText.innerHTML = formatMessage(text);
        } else {
            messageText.textContent = text;
        }

        const timeSpan = document.createElement('span');
        timeSpan.className = sender === 'user' ? 'text-[11px] text-white/80 mt-1.5 block' : 'text-[11px] text-[#68748d] mt-1.5 block';
        timeSpan.textContent = timestamp || new Date().toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        messageBubble.appendChild(messageText);
        messageBubble.appendChild(timeSpan);
        messageDiv.appendChild(messageBubble);

        chatbotMessages.appendChild(messageDiv);
        scrollToBottom();
    }

    function showLoading() {
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'flex justify-start chatbot-loading';
        loadingDiv.innerHTML = `
            <div class="bg-white rounded-[8px] p-3.5 border border-[#e6e9f0] text-[12px] text-[#68748d]">
                Menyiapkan jawaban...
            </div>
        `;
        chatbotMessages.appendChild(loadingDiv);
        scrollToBottom();
    }

    function hideLoading() {
        const loadingEl = chatbotMessages.querySelector('.chatbot-loading');
        if (loadingEl) loadingEl.remove();
    }

    function clearChatHistory() {
        chatbotMessages.innerHTML = `
            <div class="flex justify-start">
                <div class="bg-white rounded-[8px] p-3.5 max-w-[90%] border border-[#e6e9f0]">
                    <div class="eyebrow-label !text-[10px] mb-1">ASISTEN RENTGO</div>
                    <p class="text-[#001733] text-[13px] leading-[1.5]">Riwayat percakapan telah direset. Silakan tulis pertanyaan Anda mengenai armada atau tarif sewa.</p>
                    <span class="text-[11px] text-[#68748d] mt-1.5 block">${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</span>
                </div>
            </div>
        `;
        localStorage.removeItem('rental_chatbot_history');
    }

    function saveChatToHistory() {
        const messages = [];
        const messageRows = chatbotMessages.querySelectorAll(':scope > .flex');
        messageRows.forEach(messageDiv => {
            if (messageDiv.classList.contains('chatbot-loading')) return;
            const messageBubble = messageDiv.querySelector('div');
            const pElement = messageBubble?.querySelector('p');
            const timeElement = messageBubble?.querySelector('span');
            if (pElement && timeElement) {
                messages.push({
                    text: pElement.textContent,
                    sender: messageDiv.classList.contains('justify-end') ? 'user' : 'bot',
                    timestamp: timeElement.textContent
                });
            }
        });
        localStorage.setItem('rental_chatbot_history', JSON.stringify(messages));
    }

    function loadChatHistory() {
        const savedChat = localStorage.getItem('rental_chatbot_history');
        if (savedChat) {
            try {
                const messages = JSON.parse(savedChat);
                if (Array.isArray(messages) && messages.length > 0) {
                    chatbotMessages.innerHTML = '';
                    messages.forEach(msg => addMessage(msg.text, msg.sender, msg.timestamp));
                }
            } catch (e) {}
        }
    }

    function scrollToBottom() {
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function formatMessage(text) {
        let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong class="font-semibold text-[#001733]">$1</strong>');
        formatted = formatted.replace(/\n/g, '<br>');
        formatted = formatted.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" class="text-[#006aed] underline">$1</a>');
        return formatted;
    }
});
</script>