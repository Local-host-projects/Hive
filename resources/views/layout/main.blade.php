<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Hive - Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-msg { animation: fadeInSlide 0.4s ease forwards; }

        #mobile-sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @media (max-width: 1023px) {
            .sidebar-hidden {
                transform: translateX(-100%);
            }
        }

        .nav-link-active {
            color: white;
            background: rgba(255, 255, 255, 0.08);
        }

        /* Ensure the chat container takes up all available space but allows scrolling */
        #chat-container {
            flex: 1 1 0%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-[#050505] text-slate-200 h-screen overflow-hidden flex flex-col lg:flex-row">

    <!-- Ambient Background -->
    <div class="fixed top-[-10%] left-[-10%] w-[60vw] h-[60vw] bg-blue-900/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[60vw] h-[60vw] bg-purple-900/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Overlay for Mobile -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    <!-- Sidebar (Drawer on Mobile) -->
    <aside id="mobile-sidebar" class="fixed lg:relative inset-y-0 left-0 w-72 bg-[#080808] lg:bg-white/[0.01] border-r border-white/5 backdrop-blur-2xl z-50 flex flex-col sidebar-hidden lg:transform-none">
        <div class="p-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="black"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <a href='{{route('index')}}'><span class="font-bold tracking-tight text-white">Hive</span></a>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Section Navigation (Mobile Visible) -->
        <nav class="px-4 mb-4 flex flex-col gap-1 lg:hidden">
            <a href="#" class="px-4 py-2 rounded-lg text-sm font-medium nav-link-active">Assistant</a>
            <a href="{{ route('journals.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-400">Journals</a>
            <a href="#" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-400">Browse</a>
        </nav>

        <div class="px-4 mb-4">
            <a href="{{route('chats.create.persona')}}" class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all group">
                <span class="text-sm font-medium">New Thread</span>
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </a>
        </div>
        @section('side-bar')
        <div class="flex-1 overflow-y-auto px-4 custom-scrollbar">
            <div class="mb-6">
                <h3 class="px-2 text-[10px] uppercase tracking-[2px] text-slate-500 font-bold mb-4">Chat History</h3>
                <div class="flex flex-col gap-1">
                    <button class="w-full text-left px-3 py-3 rounded-lg text-sm bg-white/5 border border-white/10 text-white truncate">Glassmorphic Design Trends</button>
                    <button class="w-full text-left px-3 py-3 rounded-lg text-sm text-slate-400 hover:bg-white/[0.03] hover:text-slate-200 transition-all truncate">Quantum Computing Basics</button>
                    <button class="w-full text-left px-3 py-3 rounded-lg text-sm text-slate-400 hover:bg-white/[0.03] hover:text-slate-200 transition-all truncate">Deep Learning Models</button>
                    <button class="w-full text-left px-3 py-3 rounded-lg text-sm text-slate-400 hover:bg-white/[0.03] hover:text-slate-200 transition-all truncate">UI Interaction Patterns</button>
                    <button class="w-full text-left px-3 py-3 rounded-lg text-sm text-slate-400 hover:bg-white/[0.03] hover:text-slate-200 transition-all truncate">System Architecture v2</button>
                </div>
            </div>
        </div>
        @show

        <div class="p-6 border-t border-white/5 mt-auto">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 border border-white/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"></path></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold truncate text-white">Alex Rivard</p>
                    <p class="text-[10px] text-slate-500 truncate">Pro Account</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    @yield('main')
    @stack('scripts')
    <script>
        const chatContainer = document.getElementById('chat-container');
        const messageList = document.getElementById('message-list');
        const chatInput = document.getElementById('chat-input');
        const sendBtn = document.getElementById('send-btn');
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('sidebar-hidden');
            overlay.classList.toggle('hidden');
        }

        // Improved scroll function
        function scrollToBottom() {
            chatContainer.scrollTo({
                top: chatContainer.scrollHeight,
                behavior: 'smooth'
            });
        }

        window.onload = scrollToBottom;

        function setMode(mode) {
            const btnHybrid = document.getElementById('btn-hybrid');
            const btnImmessage = document.getElementById('btn-immessage');
            const label = document.getElementById('mode-label');

            if (mode === 'hybrid') {
                btnHybrid.className = 'px-3 md:px-4 py-1.5 rounded-full text-[10px] md:text-xs font-medium transition-all bg-white/10 text-white shadow-sm';
                btnImmessage.className = 'px-3 md:px-4 py-1.5 rounded-full text-[10px] md:text-xs font-medium transition-all text-slate-500 hover:text-slate-300';
                label.innerText = 'Hybrid Engine';
            } else {
                btnImmessage.className = 'px-3 md:px-4 py-1.5 rounded-full text-[10px] md:text-xs font-medium transition-all bg-white/10 text-white shadow-sm';
                btnHybrid.className = 'px-3 md:px-4 py-1.5 rounded-full text-[10px] md:text-xs font-medium transition-all text-slate-500 hover:text-slate-300';
                label.innerText = 'Immessage Context';
            }
        }

        function handleSend() {
            const text = chatInput.value.trim();
            if (!text) return;
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            messageList.insertAdjacentHTML('beforeend', `
                <div class="flex justify-end animate-msg">
                    <div class="relative max-w-[90%] md:max-w-[85%] px-5 py-4 rounded-2xl bg-white/10 border border-white/10 text-white shadow-2xl rounded-tr-none leading-relaxed text-sm md:text-[0.95rem]">
                        ${text}
                        <span class="block mt-2 text-[10px] text-white/40 text-right">${time}</span>
                    </div>
                </div>
            `);
            chatInput.value = '';
            
            // Allow DOM to update before scrolling
            setTimeout(scrollToBottom, 50);
        }

        sendBtn.addEventListener('click', handleSend);
        chatInput.addEventListener('keypress', (e) => { 
            if (e.key === 'Enter') handleSend(); 
        });

        // Handle resize (mobile keyboard appearance)
        window.visualViewport.addEventListener('resize', scrollToBottom);
    </script>
</body>
</html>