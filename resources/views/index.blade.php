@extends('layout.main')
@section('main')
    <main class="flex-1 flex flex-col relative min-w-0 h-full">
        <!-- Global Top Navbar (Desktop Only) -->
        <nav class="hidden lg:flex h-14 border-b border-white/5 items-center px-8 gap-8 shrink-0 bg-black/10 backdrop-blur-sm">
            <a href="#" class="text-xs font-bold tracking-[2px] uppercase text-white border-b-2 border-white h-full flex items-center">Assistant</a>
            <a href="{{ route('journals.index') }}" class="text-xs font-bold tracking-[2px] uppercase text-slate-500 hover:text-slate-300 transition-colors h-full flex items-center">Journals</a>
            <a href="#" class="text-xs font-bold tracking-[2px] uppercase text-slate-500 hover:text-slate-300 transition-colors h-full flex items-center">Analytics</a>
            <div class="ml-auto flex items-center gap-4">
                <span class="text-[10px] text-slate-600 font-mono">ID: 882-AXV</span>
            </div>
        </nav>

        <!-- Sub-Header (Context Navigation) -->
        <header class="h-16 flex items-center justify-between px-4 md:px-6 border-b border-white/5 backdrop-blur-md bg-black/20 shrink-0 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
                    <span id="mode-label" class="text-xs font-semibold tracking-wide truncate">Hybrid Engine</span>
                </div>
            </div>

            <!-- Thread Mode Tabs -->
            <div class="flex items-center p-1 bg-white/5 rounded-full border border-white/5 scale-90 md:scale-100">
                <button onclick="setMode('hybrid')" id="btn-hybrid" class="px-3 md:px-4 py-1.5 rounded-full text-[10px] md:text-xs font-medium transition-all bg-white/10 text-white shadow-sm">Hybrid</button>
                <button onclick="setMode('immessage')" id="btn-immessage" class="px-3 md:px-4 py-1.5 rounded-full text-[10px] md:text-xs font-medium transition-all text-slate-500 hover:text-slate-300">Context</button>
            </div>
            
            <button class="p-2 text-slate-400 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
        </header>

        <!-- Chat Area -->
        <div id="chat-container" class="custom-scrollbar">
            <div class="max-w-3xl mx-auto w-full flex flex-col gap-6 md:gap-10 py-8 px-4 md:px-8" id="message-list">
                <div class="flex justify-start animate-msg">
                    <div class="relative max-w-[90%] md:max-w-[85%] px-5 py-4 rounded-2xl bg-white/[0.03] border border-white/[0.05] text-slate-300 rounded-tl-none leading-relaxed text-sm md:text-[0.95rem]">
                        Welcome to Hive. I've synced your latest journals. How can I assist your workflow today?
                        <span class="block mt-2 text-[10px] text-slate-600">Today, 10:24 AM</span>
                    </div>
                </div>
                
                <!-- Placeholder long content to demonstrate scrollability -->
                <div class="flex justify-start animate-msg">
                    <div class="relative max-w-[90%] md:max-w-[85%] px-5 py-4 rounded-2xl bg-white/[0.03] border border-white/[0.05] text-slate-300 rounded-tl-none leading-relaxed text-sm md:text-[0.95rem]">
                        I have analyzed your recent entries. It seems you are making progress on the 'Hive' project. Would you like a deep-dive into the technical constraints we identified yesterday?
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 md:p-8 pt-2 bg-gradient-to-t from-[#050505] via-[#050505] to-transparent shrink-0">
            <div class="max-w-3xl mx-auto relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-[20px] md:rounded-[24px] blur-xl opacity-0 group-focus-within:opacity-100 transition-opacity pointer-events-none"></div>
                <div class="relative flex items-center glass-panel rounded-[20px] md:rounded-[24px] p-1.5 md:p-2 pr-3 md:pr-4 border-white/10 focus-within:border-white/20 focus-within:bg-white/[0.05]">
                    <input id="chat-input" type="text" autocomplete="off" placeholder="Ask Hive..." class="flex-1 bg-transparent border-none outline-none px-4 md:px-6 py-3 md:py-4 text-sm md:text-[0.95rem] text-white placeholder:text-slate-600">
                    <button id="send-btn" class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white flex items-center justify-center text-black hover:scale-105 active:scale-95 transition-all shadow-lg shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="black" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection