<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hulahup - Sign Up Desktop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F3F4F6] min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-5xl rounded-[50px] shadow-2xl overflow-hidden flex h-[700px] border-[10px] border-white">
        
        <div class="w-full md:w-1/2 p-16 flex flex-col justify-center bg-[#FDFBD7]/20 overflow-y-auto no-scrollbar">
            <div class="mb-8">
                <h2 class="text-4xl font-black text-gray-800 tracking-tight">Sign Up</h2>
                <p class="text-gray-500 mt-2 font-medium">Buat akun untuk mulai memesan makanan.</p>
            </div>

            <form action="/signup" method="POST" class="space-y-4">
                @csrf 
                
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" required 
                        class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 px-6 outline-none focus:ring-4 focus:ring-[#3A6D8C]/10 focus:border-[#3A6D8C] transition-all"
                        placeholder="Masukkan nama lengkap">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700 ml-1">Email Student</label>
                    <input type="email" name="email" required 
                        class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 px-6 outline-none focus:ring-4 focus:ring-[#3A6D8C]/10 focus:border-[#3A6D8C] transition-all"
                        placeholder="nama@student.telkomuniversity.ac.id">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700 ml-1">Nomor WhatsApp</label>
                    <input type="text" name="phone" required 
                        class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 px-6 outline-none focus:ring-4 focus:ring-[#3A6D8C]/10 focus:border-[#3A6D8C] transition-all"
                        placeholder="0812xxxx">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700 ml-1">Password</label>
                    <input type="password" name="password" required 
                        class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 px-6 outline-none focus:ring-4 focus:ring-[#3A6D8C]/10 focus:border-[#3A6D8C] transition-all"
                        placeholder="••••••••">
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-[#3A6D8C] text-white py-4 rounded-[20px] font-black shadow-xl shadow-blue-900/20 hover:bg-[#5D89B3] hover:scale-[1.01] active:scale-95 transition-all uppercase tracking-widest text-sm">
                        Buat Akun Sekarang
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-sm text-gray-500 font-medium">
                Sudah punya akun? 
                <a href="/" class="text-[#3A6D8C] font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>

        <div class="hidden md:flex w-1/2 bg-[#3A6D8C] items-center justify-center p-16 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-[#EAD8B1]/20 rounded-full"></div>
            <div class="absolute -bottom-20 -left-10 w-80 h-80 bg-white/5 rounded-full"></div>
            
            <div class="z-10 text-center">
                <div class="bg-white p-6 rounded-[40px] shadow-2xl mb-8 rotate-3 hover:rotate-0 transition-transform duration-500">
                     <h1 class="text-5xl font-black italic text-[#3A6D8C] tracking-tighter">Hulahup.</h1>
                </div>
                <h3 class="text-white text-2xl font-bold mb-4 italic">Kenapa pilih kami?</h3>
                <ul class="text-white/80 text-sm space-y-3 font-medium text-left inline-block">
                    <li><i class="fas fa-check-circle text-[#EAD8B1] mr-2"></i> Tanpa antri panjang di kantin</li>
                    <li><i class="fas fa-check-circle text-[#EAD8B1] mr-2"></i> Notifikasi pesanan real-time</li>
                    <li><i class="fas fa-check-circle text-[#EAD8B1] mr-2"></i> Pembayaran TyU-Pay praktis</li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>