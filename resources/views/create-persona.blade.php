<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Hive - Create Persona</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .focus-text-area {
            background: transparent;
            border: none;
            outline: none;
            resize: none;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
        }
        .ambient-glow { animation: pulse-slow 8s infinite ease-in-out; }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        .animate-content { animation: slideInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
    </style>
</head>
<body class="bg-[#050505] text-slate-200 min-h-screen overflow-y-auto flex flex-col items-center">

    <!-- Ambient Background -->
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80vw] h-[80vw] bg-blue-600/5 rounded-full blur-[160px] pointer-events-none ambient-glow"></div>
    <div class="fixed top-1/4 left-1/4 w-[40vw] h-[40vw] bg-purple-600/5 rounded-full blur-[140px] pointer-events-none ambient-glow" style="animation-delay: -2s;"></div>

    <!-- Top Navigation (Exit) -->
    <nav class="sticky top-0 w-full h-20 px-8 flex items-center justify-between z-50 bg-[#050505]/50 backdrop-blur-md">
        <a href="hive_chat.html" class="group flex items-center gap-3 text-slate-500 hover:text-white transition-all">
            <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-white/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-[2px]">Cancel</span>
        </a>
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-white/20"></div>
            <div class="w-2 h-2 rounded-full bg-white/20"></div>
            <div class="w-2 h-2 rounded-full bg-white"></div>
        </div>
    </nav>

    <!-- Center Content Container -->
    <main class="w-full max-w-2xl px-6 z-10 animate-content py-12 md:py-20">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-light tracking-tight text-white mb-4">What's on your mind?</h1>
            <p class="text-slate-500 text-sm md:text-base leading-relaxed">
                Describe your current challenges, feelings, or the specific support you need. 
                <br class="hidden md:block"> We'll craft a persona tailored to your context created to represent many other people who can relate to the problem you are having.
            </p>
        </div>
        <form action='{{route('chats.create.persona.action')}}'  method="post">
        @csrf
        <div class="glass-panel rounded-[32px] p-2 md:p-3 shadow-2xl relative">
            <div class="p-6 md:p-8">
                <textarea 
                    id="persona-input"
                    name="problem_description"
                    placeholder="Speak freely. For example: 'I'm struggling with post-op isolation and need someone encouraging but grounded in clinical facts...'"
                    class="focus-text-area w-full min-h-[300px] md:min-h-[400px] text-lg md:text-xl text-white placeholder:text-slate-700 leading-relaxed"
                ></textarea>
            </div>

            <!-- Action Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white/[0.02] rounded-b-[28px] border-t border-white/5 gap-4">
                <div class="flex items-center gap-2 px-3">
                    <span id="char-count" class="text-[10px] font-mono text-slate-600">0 words</span>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto group relative px-8 py-3 bg-white text-black font-bold text-sm rounded-full overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-[0_0_30px_rgba(255,255,255,0.1)]"
                >
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Initialize Persona
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 7l5 5-5 5"></path></svg>
                    </span>
                </button>
            </div>
        </div>
        </form>

        <!-- Suggestion Chips -->
    </main>

    <!-- Success Modal -->
    <div id="loading-overlay" class="fixed inset-0 bg-[#050505] z-[60] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-700">
        <div class="text-center">
            <div class="w-16 h-16 border-2 border-white/10 border-t-white rounded-full animate-spin mb-6 mx-auto"></div>
            <p class="text-xs font-bold uppercase tracking-[4px] text-white">Synthesizing Context</p>
        </div>
    </div>

    <script>
        

        window.onload = () => {
            setTimeout(() => input.focus(), 800);
        };
    </script>
</body>
</html>