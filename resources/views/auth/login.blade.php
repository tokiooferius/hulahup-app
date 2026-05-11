<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hulahup - Login Desktop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F3F4F6] min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-5xl rounded-[50px] shadow-2xl overflow-hidden flex h-[650px] border-[10px] border-white">
        
        <div class="hidden md:flex w-1/2 bg-[#3A6D8C] items-center justify-center p-16 relative overflow-hidden">
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full"></div>
            <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-[#EAD8B1]/20 rounded-full"></div>
            
            <div class="z-10 text-center">
                <h1 class="text-6xl font-black italic text-[#EAD8B1] mb-6 tracking-tighter">Hulahup.</h1>
                <p class="text-white text-lg opacity-80 leading-relaxed font-medium">
                    Pesan makanan kantin Tel-U <br> jadi lebih mudah dan cepat.
                </p>
                <div class="mt-10 inline-block bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20">
                    <p class="text-white text-sm font-bold">#InformatikaMakanEnak</p>
                </div>
            </div>
        </div>
        
        <div class="w-full md:w-1/2 p-16 flex flex-col justify-center bg-[#FDFBD7]/20">
            <div class="mb-10">
                <h2 class="text-4xl font-black text-gray-800 tracking-tight">Login</h2>
                <p class="text-gray-500 mt-2 font-medium">Selamat datang kembali, silakan masuk.</p>
            </div>

            <form action="/login" method="POST" class="space-y-6">
                @csrf <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Email Mahasiswa</label>
                    <input type="email" name="email" required 
                        class="w-full bg-white border border-gray-200 rounded-2xl py-4 px-6 outline-none focus:ring-4 focus:ring-[#3A6D8C]/10 focus:border-[#3A6D8C] transition-all"
                        placeholder="nama@student.telkomuniversity.ac.id">
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-sm font-bold text-gray-700">Password</label>
                        <a href="#" class="text-xs font-bold text-[#3A6D8C] hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" required 
                            class="w-full bg-white border border-gray-200 rounded-2xl py-4 px-6 outline-none focus:ring-4 focus:ring-[#3A6D8C]/10 focus:border-[#3A6D8C] transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-[#3A6D8C] text-white py-4 rounded-[20px] font-black shadow-xl shadow-blue-900/20 hover:bg-[#5D89B3] hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest text-sm">
                        Masuk Sekarang
                    </button>
                </div>

                <div class="relative flex py-3 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-xs font-bold uppercase">Atau</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <button type="button" class="w-full bg-white border border-gray-200 py-4 rounded-2xl font-bold flex items-center justify-center gap-3 shadow-sm hover:bg-gray-50 transition-all text-gray-700 text-sm">
                    <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5">
                    Login dengan SSO Tel-U
                </button>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500 font-medium">
                Belum punya akun? 
                <a href="/signup" class="text-[#3A6D8C] font-bold hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>

</body>
</html>