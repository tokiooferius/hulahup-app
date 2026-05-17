<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hulahup - Kantin Digital Tel-U</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-foodtyu.png') }}">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FBF9E4; }
        .bg-pattern {
            background-image: url("https://www.transparenttextures.com/patterns/cubes.png");
            opacity: 0.05;
        }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-pattern"></div>

    <div class="relative z-10 text-center px-6">
        <div class="mb-8 flex justify-center">
            <div class="p-6 bg-white rounded-[50px] shadow-2xl shadow-orange-200/50 animate-bounce duration-[3000ms]">
                <img src="{{ asset('images/logo-foodtyu.png') }}" alt="Logo Hulahup" class="w-32 h-32 object-contain">
            </div>
        </div>

        <h1 class="text-6xl font-black italic text-[#122C4F] tracking-tighter mb-2">Hulahup.</h1>
        <div class="flex items-center justify-center gap-2 mb-8">
            <span class="h-[2px] w-8 bg-[#5B88B2]"></span>
            <p class="text-slate-500 font-bold uppercase tracking-[0.3em] text-xs">Kantin Digital Tel-U</p>
            <span class="h-[2px] w-8 bg-[#5B88B2]"></span>
        </div>

        <p class="text-slate-400 max-w-md mx-auto mb-12 font-medium leading-relaxed">
            Pesan makanan kantin favoritmu tanpa antri. Cepat, praktis, dan langsung dari genggamanmu.
        </p>

        <div class="flex gap-4 justify-center">
            <a href="/login" class="bg-[#122C4F] text-white px-10 py-4 rounded-full font-bold shadow-xl hover:scale-105 transition-all">
                Masuk
            </a>
            <a href="/signup" class="border-2 border-[#122C4F] text-[#122C4F] px-10 py-4 rounded-full font-bold hover:bg-[#122C4F] hover:text-white transition-all">
                Daftar Akun
            </a>
        </div>

        <p class="mt-20 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            Made with ❤️ for Telkom University Purwokerto
        </p>
    </div>

    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-[#5B88B2] opacity-10 rounded-full blur-3xl"></div>
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-orange-400 opacity-10 rounded-full blur-3xl"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></script>
</body>
</html>