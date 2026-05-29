<!-- biểu tượng CHAT -->
<div id="berrynice-chat-toggle" 
     class="fixed top-1/2 -translate-y-1/2 right-6 z-[9999] w-14 h-14 sm:w-16 sm:h-16 bg-[#9CC69B] hover:bg-[#8BB98A] text-white rounded-full cursor-pointer shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 flex items-center justify-center select-none">
    <i class="fas fa-comment-dots text-xl sm:text-2xl"></i>
</div>

<!-- Khung chat -->
<div id="berrynice-chat-container" 
     class="hidden fixed top-1/2 -translate-y-1/2 right-6 w-[350px] sm:w-[380px] h-[520px] bg-white rounded-2xl shadow-2xl border border-slate-100 z-[9999] flex-col overflow-hidden transition-all duration-300">
    
    <!-- Header -->
    <div class="bg-white border-b border-slate-100 p-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-[#F0F7EE] rounded-lg flex items-center justify-center text-[#557A5E]">
                <i class="fas fa-sparkles text-xs animate-pulse"></i>
            </div>
            <div>
                <h3 class="font-medium text-slate-800 text-sm leading-tight">Trợ lý ảo BerryNice</h3>
                <p class="text-[10px] text-emerald-600 flex items-center gap-1 mt-0.5">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block animate-ping"></span>
                    Trực tuyến
                </p>
            </div>
        </div>
        <button id="berrynice-chat-close" class="text-slate-400 hover:text-slate-600 transition text-lg cursor-pointer p-1 focus:outline-none">&times;</button>
    </div>

    <!-- Khu vực chat -->
    <div id="berrynice-chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 flex flex-col min-h-0 scroll-smooth bg-slate-50/50">
        <!-- Hi -->
        <div class="flex items-start gap-2 max-w-[85%] self-start">
            <div class="w-7 h-7 rounded-lg bg-[#F0F7EE] flex items-center justify-center text-[#557A5E] text-[10px] font-bold flex-shrink-0">AI</div>
            <div class="bg-white text-slate-700 text-sm p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 leading-relaxed">
                Xin chào! Mình là trợ lý ảo BerryNice. Hãy chia sẻ tình trạng da hoặc nhu cầu của bạn để mình gợi ý dịch vụ phù hợp nhé! 🥰
            </div>
        </div>
    </div>

    <!-- Ô nhập liệu -->
    <div class="p-3 bg-white border-t border-slate-100 flex-shrink-0">
        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-1 focus-within:bg-white focus-within:border-[#9CC69B] focus-within:ring-1 focus-within:ring-[#9CC69B] transition">
            <input type="text" id="berrynice-chat-input" 
                   class="w-full bg-transparent px-2.5 py-1.5 text-sm text-slate-700 focus:outline-none placeholder-slate-400" 
                   placeholder="Nhập nhu cầu/tình trạng da của bạn..." 
                   autocomplete="off">
            <button id="berrynice-chat-send-btn" 
                    class="w-8 h-8 bg-[#9CC69B] hover:bg-[#8BB98A] text-white rounded-lg flex items-center justify-center transition flex-shrink-0">
                <i class="fas fa-paper-plane text-xs"></i>
            </button>
        </div>
    </div>
</div>

<script>
    // Logic ẩn/hiện đồng bộ: khi mở khung chat thì ẩn nút toggle và ngược lại
    const toggleBtn = document.getElementById('berrynice-chat-toggle');
    const container = document.getElementById('berrynice-chat-container');
    const closeBtn = document.getElementById('berrynice-chat-close');
    const messagesContainer = document.getElementById('berrynice-chat-messages');

    toggleBtn.addEventListener('click', function() {
        container.classList.remove('hidden');
        container.classList.add('flex');
        toggleBtn.classList.add('hidden'); // Ẩn nút tròn khi mở khung chat
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });

    closeBtn.addEventListener('click', function() {
        container.classList.add('hidden');
        container.classList.remove('flex');
        toggleBtn.classList.remove('hidden'); // Hiện lại nút tròn khi đóng chat
    });

    // Xử lý sự kiện gửi tin nhắn
    document.getElementById('berrynice-chat-send-btn').addEventListener('click', sendUserMessage);
    document.getElementById('berrynice-chat-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendUserMessage();
    });

    function sendUserMessage() {
        const input = document.getElementById('berrynice-chat-input');
        const message = input.value.trim();
        if (!message) return;

        // 1. Hiển thị tin nhắn của Người dùng
        const userWrapper = document.createElement('div');
        userWrapper.className = "flex items-start justify-end max-w-[85%] self-end";
        userWrapper.innerHTML = `<div class="bg-[#9CC69B] text-white text-sm p-3 rounded-2xl rounded-tr-none shadow-sm leading-relaxed">${message}</div>`;
        messagesContainer.appendChild(userWrapper);
        
        input.value = ''; 
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // 2. Hiển thị hiệu ứng loading "AI đang suy nghĩ"
        const loadingId = 'loading-' + Date.now();
        const loadingWrapper = document.createElement('div');
        loadingWrapper.id = loadingId;
        loadingWrapper.className = "flex items-start gap-2 max-w-[85%] self-start animate-pulse";
        loadingWrapper.innerHTML = `
            <div class="w-7 h-7 rounded-lg bg-[#F0F7EE] flex items-center justify-center text-[#557A5E] text-[10px] font-bold flex-shrink-0">AI</div>
            <div class="bg-white text-slate-400 font-medium italic text-xs p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 flex items-center gap-1.5">
                Trợ lý ảo BerryNice đang suy nghĩ...
            </div>
        `;
        messagesContainer.appendChild(loadingWrapper);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // 3. Gửi request AJAX lên Laravel Controller
        fetch("{{ route('chatbot.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            const currentLoading = document.getElementById(loadingId);
            if (currentLoading) messagesContainer.removeChild(currentLoading);

            if (data.success) {
                // Hiển thị câu thoại phản hồi từ Trợ lý AI
                const aiWrapper = document.createElement('div');
                aiWrapper.className = "flex items-start gap-2 max-w-[85%] self-start";
                
                const aiBubble = document.createElement('div');
                aiBubble.className = "bg-white text-slate-700 text-sm p-3 rounded-2xl rounded-tl-none shadow-sm leading-relaxed border border-slate-100";
                aiBubble.textContent = data.reply;
                aiBubble.style.whiteSpace = "pre-line";

                aiWrapper.innerHTML = `<div class="w-7 h-7 rounded-lg bg-[#F0F7EE] flex items-center justify-center text-[#557A5E] text-[10px] font-bold flex-shrink-0">AI</div>`;
                aiWrapper.appendChild(aiBubble);
                messagesContainer.appendChild(aiWrapper);

                // Render danh sách các dịch vụ gợi ý nếu có
                if (data.services && data.services.length > 0) {
                    data.services.forEach(service => {
                        appendServiceCard(service, messagesContainer);
                    });
                }
            } else {
                appendSystemErrorMsg(data.reply, messagesContainer);
            }
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .catch(error => {
            const currentLoading = document.getElementById(loadingId);
            if (currentLoading) messagesContainer.removeChild(currentLoading);
            appendSystemErrorMsg('Có lỗi kết nối xảy ra, vui lòng thử lại sau!', messagesContainer);
            console.error("Error:", error);
        });
    }

    // Hàm phụ trợ xuất Card thông tin Dịch Vụ tối giản
    function appendServiceCard(service, container) {
        const wrapper = document.createElement('div');
        wrapper.className = "flex items-start gap-2 max-w-[85%] self-start w-full";
        
        const formatter = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
        const formattedPrice = formatter.format(service.price).replace('₫', 'đ');

        wrapper.innerHTML = `
            <div class="w-7 flex-shrink-0"></div>
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden w-full hover:border-[#9CC69B] transition-all">
                <div class="p-3">
                    <h4 class="font-semibold text-slate-800 text-xs sm:text-sm mb-1 hover:text-[#557A5E] transition">
                        ${service.name}
                    </h4>
                    <div class="flex items-center gap-3 text-[11px] text-slate-500 mb-2">
                        <span class="flex items-center gap-1"><i class="far fa-clock"></i> ${service.duration} phút</span>
                        <span class="font-semibold text-[#557A5E]">${formattedPrice}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 line-clamp-2 mb-2.5 leading-relaxed">
                        ${service.short_description || 'Nhấn để xem chi tiết thông tin và quy trình trị liệu nâng cao tại Spa.'}
                    </p>
                    <a href="/services/${service.slug}" target="_blank" 
                       class="block w-full text-center bg-[#F0F7EE] hover:bg-[#9CC69B] hover:text-white text-[#557A5E] text-[11px] font-medium py-1.5 rounded-lg transition">
                        Chi tiết & Đặt lịch
                    </a>
                </div>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function appendSystemErrorMsg(text, container) {
        const errorWrapper = document.createElement('div');
        errorWrapper.className = "flex items-start gap-2 max-w-[85%] self-start";
        errorWrapper.innerHTML = `
            <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center text-red-500 text-[10px] font-bold flex-shrink-0"><i class="fas fa-exclamation"></i></div>
            <div class="bg-white text-red-500 text-xs p-3 rounded-2xl rounded-tl-none shadow-sm border border-red-50">${text}</div>
        `;
        container.appendChild(errorWrapper);
        container.scrollTop = container.scrollHeight;
    }
</script>