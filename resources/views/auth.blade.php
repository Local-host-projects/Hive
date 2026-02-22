<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hive - Auth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            overflow-y: auto; /* Ensure body can scroll */
        }
        
        /* Custom Scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            outline: none;
        }

        /* Form Visibility Toggle */
        .auth-view { display: none; }
        .auth-view.active { display: flex; animation: slideUp 0.4s ease-out; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .tab-active {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-[#050505] text-slate-200 min-h-screen flex flex-col items-center justify-start py-12 px-4">

    <!-- Ambient Lighting (Fixed) -->
    <div class="fixed top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-blue-900/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40vw] h-[40vw] bg-indigo-900/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <div class="w-full max-w-[420px] relative z-10 flex flex-col">
        
        <!-- Top Navigation Tabs -->
        <div class="flex items-center justify-center mb-8 shrink-0">
            <div class="glass-panel p-1 rounded-2xl flex w-full">
                <button onclick="switchTab('signin')" id="tab-signin" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-500 transition-all tab-active">
                    Sign In
                </button>
                <button onclick="switchTab('signup')" id="tab-signup" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-500 transition-all">
                    Create Account
                </button>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="glass-panel rounded-[32px] p-8 shadow-2xl relative overflow-visible">
            
            <!-- Branding inside the box -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="flex items-center gap-3 mb-8">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="black"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <h1 id="view-title" class="text-lg font-bold">Welcome Back</h1>
            </div>

            <!-- Sign In View -->
            <div id="signin-view" class="auth-view active flex-col gap-5">
                <div class="space-y-2">
                    @if ($errors->has('email_login'))
                    <div class="text-red-500 text-sm mb-4">
                        {{ $errors->first('email_login') }}
                    </div>
                    @endif
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email_login" placeholder="Enter your email" class="w-full input-field rounded-xl px-4 py-3.5 text-sm text-white placeholder:text-slate-700">
                </div>
                
                <div class="space-y-2">
                    @if ($errors->has('password_login'))
                    <div class="text-red-500 text-sm mb-4">
                        {{ $errors->first('password_login') }}  
                    </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Password</label>
                        <a href="#" class="text-[10px] font-bold text-blue-400 hover:text-blue-300 transition-colors uppercase">Forgot?</a>
                    </div>
                    <input type="password" name='password_login' placeholder="••••••••" class="w-full input-field rounded-xl px-4 py-3.5 text-sm text-white placeholder:text-slate-700">
                </div>

                <button type="submit" class="w-full bg-white text-black font-bold py-4 rounded-xl mt-2 hover:opacity-90 active:scale-95 transition-all shadow-lg">
                    Sign In
                </button>
            </div>
        </form>

            <!-- Sign Up View -->
            <div id="signup-view" class="auth-view flex-col gap-5">

        <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    @if ($errors->has('username'))
                    <div class="text-red-500 text-sm mb-4"> 
                        {{ $errors->first('username') }}  
                    </div>
                    @endif
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Username</label>
                    <input type="text" name="username" placeholder="Alexandra" class="w-full input-field rounded-xl px-4 py-3 text-sm text-white placeholder:text-slate-700">
                </div>
                <div class="space-y-2">
                    @if ($errors->has('email'))
                    <div class="text-red-500 text-sm mb-4">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" placeholder="name@example.com" class="w-full input-field rounded-xl px-4 py-3 text-sm text-white placeholder:text-slate-700">
                </div>
                
                <div class="space-y-2">
                    @if ($errors->has('password'))
                    <div class="text-red-500 text-sm mb-4">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Password</label>
                    <input type="password"  name="password" placeholder="Min. 8 chars" class="w-full input-field rounded-xl px-4 py-3 text-sm text-white placeholder:text-slate-700">
                </div>

                <button type="submit" class="w-full bg-white text-black font-bold py-4 rounded-xl mt-2 hover:opacity-90 active:scale-95 transition-all shadow-lg">
                    Create My Hive
                </button>
            </div>
        </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-6">
                <div class="h-px flex-1 bg-white/5"></div>
                <span class="text-[9px] font-bold text-slate-600 uppercase tracking-[2px]">Quick Access</span>
                <div class="h-px flex-1 bg-white/5"></div>
            </div>

            <!-- Social Auth -->
        </div>
        
        <p class="text-center my-8 text-[11px] text-slate-500 font-medium shrink-0">
            Hive uses AES-256 bit encryption to secure your health journey.
        </p>
    </div>

    <script>
        function switchTab(view) {
            const signinView = document.getElementById('signin-view');
            const signupView = document.getElementById('signup-view');
            const tabSignin = document.getElementById('tab-signin');
            const tabSignup = document.getElementById('tab-signup');
            const viewTitle = document.getElementById('view-title');

            // Reset classes
            signinView.classList.remove('active');
            signupView.classList.remove('active');
            tabSignin.classList.remove('tab-active');
            tabSignup.classList.remove('tab-active');

            if (view === 'signin') {
                signinView.classList.add('active');
                tabSignin.classList.add('tab-active');
                viewTitle.innerText = 'Welcome Back';
            } else {
                signupView.classList.add('active');
                tabSignup.classList.add('tab-active');
                viewTitle.innerText = 'Join the Hive';
            }
        }
    </script>
</body>
</html>