@extends('layout.main')
@section('side-bar')
<div class="flex-1 overflow-y-auto px-4 custom-scrollbar">
            <div class="mb-6">
                <h3 class="px-2 text-[10px] uppercase tracking-[2px] text-slate-500 font-bold mb-4">Chat History</h3>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('journals.show') }}" class="w-full text-left px-3 py-3 rounded-lg text-sm bg-white/5 border border-white/10 text-white truncate">Chat</a>
                    <a href="{{ route('journals.show') }}" class="w-full text-left px-3 py-3 rounded-lg text-sm text-slate-400 hover:bg-white/[0.03] hover:text-slate-200 transition-all truncate">Jounals</a>
                    <a href="{{ route('journals.show') }}" class="w-full text-left px-3 py-3 rounded-lg text-sm text-slate-400 hover:bg-white/[0.03] hover:text-slate-200 transition-all truncate">Browse</a>
                </div>
            </div>
</div>    
@endsection
@section('main')
    <main class="flex-1 flex flex-col h-full overflow-hidden">
            
            <!-- Header -->
            <header class="h-16 flex items-center justify-between px-6 border-b border-white/5 backdrop-blur-md bg-black/20 z-10 shrink-0">
                <div class="flex items-center gap-4">
                    <h1 class="text-lg font-bold tracking-tight">Personal Journals</h1>
                    <div class="h-4 w-px bg-white/10"></div>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[2px]">Private Vault</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <div class="max-w-3xl mx-auto py-10 px-6 flex flex-col gap-10">
                    
                    
                    <section class="animate-entry">
                        <div class="glass-panel rounded-[28px] p-8 border-white/10 shadow-2xl">
                            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">New Entry</h2>
                            <form action='{{route('journals.store')}}' method="POST">
                                @csrf
                                <div class="flex flex-col gap-5">
                                    <!-- Condition Input -->
                                    <div class="relative group">
                                        <label class="absolute -top-2.5 left-4 px-2 bg-[#0a0a0a] text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Condition / Ailment</label>
                                        <input name="condition" type="text" placeholder="e.g. Chronic Migraine, Recovery Day 12..." 
                                            class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder:text-slate-700 outline-none input-focus-effect transition-all">
                                    </div>
    
                                    <!-- Narrative Textarea -->
                                    <div class="relative group">
                                        <label class="absolute -top-2.5 left-4 px-2 bg-[#0a0a0a] text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Experience & Coping</label>
                                        <textarea name="story" placeholder="How are you feeling today? What strategies helped you cope?" 
                                            class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-4 py-4 text-[0.95rem] text-slate-200 placeholder:text-slate-700 outline-none input-focus-effect transition-all h-36 resize-none leading-relaxed"></textarea>
                                    </div>
    
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex gap-3">
                                            <button title="Mood Check" class="p-2.5 rounded-full bg-white/5 border border-white/5 text-slate-500 hover:text-white transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                            <button title="Privacy Level" class="flex items-center gap-2 px-3 py-1 text-[10px] font-bold uppercase tracking-tighter text-slate-500 bg-white/5 rounded-full border border-white/5">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                                Encrypted
                                            </button>
                                        </div>
                                        <button class="px-8 py-3 rounded-full bg-white text-black font-bold text-sm shadow-[0_10px_20px_rgba(255,255,255,0.1)] hover:scale-[1.02] active:scale-95 transition-all">Save Entry</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>

                    <!-- Past Journals Timeline -->
                    <section class="flex flex-col gap-6">
                        <div class="flex items-center justify-between px-2">
                            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-[3px]">Past History</h2>
                            <span class="text-[10px] text-slate-600">Sorted by Date</span>
                        </div>
                        @forelse ($journals as $journal)
                            

                        <!-- Journal Card 1 -->
                        <div class="glass-card rounded-2xl p-6 animate-entry relative" style="animation-delay: 0.1s;">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest bg-blue-400/10 px-2 py-1 rounded border border-blue-400/20">
                                        {{ $journal->condition }}
                                    </span>
                                    <h3 class="text-slate-500 text-[11px] mt-2 font-medium">
                                        February 20, 2024 • 09:15 AM
                                    </h3>
                                </div>

                                <!-- 3 DOT BUTTON -->
                                <div class="relative">
                                    <button 
                                        onclick="toggleMenu(this)" 
                                        class="text-slate-700 hover:text-white transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- DROPDOWN -->
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-32 bg-black/90 backdrop-blur-xl border border-white/10 rounded-xl shadow-xl overflow-hidden z-50">
                                        <a href="{{ route('journals.update.page', $journal->id) }}"
                                        class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/10 hover:text-white transition">
                                            Update
                                        </a>

                                        <form method="POST" action="{{ route('journals.destroy', $journal->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <p class="text-slate-300 leading-relaxed text-[0.95rem]">
                                {{ $journal->story }}
                            </p>
                        </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-slate-500">No journal entries yet. Your personal vault is empty.</p>
                            </div>
                        @endforelse

                    </section>
                </div>
            </div>
        </main>
@endsection
@push('scripts')
<script>
function toggleMenu(button) {
    // close all other dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
    });

    // toggle this one
    const menu = button.parentElement.querySelector('.dropdown-menu');
    menu.classList.toggle('hidden');
}

// close if clicked outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>
@endpush