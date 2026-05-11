<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hulahup - Food-TyU</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Playfair+Display:wght@900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif-custom { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-200 flex justify-center items-center min-h-screen">

    <div class="w-[375px] h-[812px] bg-[#FDFBD7] shadow-[0_20px_50px_rgba(0,0,0,0.2)] overflow-hidden relative flex flex-col items-center p-6 rounded-[40px] border-[8px] border-white">
        
        <div class="w-full flex justify-between px-4 pt-2 text-[14px] font-bold text-black mb-10">
            <span>9:41</span>
            <div class="flex gap-1.5 items-center">
                <i class="fa-solid fa-signal text-[12px]"></i>
                <i class="fa-solid fa-wifi text-[12px]"></i>
                <i class="fa-solid fa-battery-full text-[16px]"></i>
            </div>
        </div>

        <div class="mt-12 mb-6">
            <div class="w-64 h-64 rounded-full bg-white flex items-center justify-center shadow-xl overflow-hidden border-[6px] border-white ring-4 ring-[#A7C7E7]/30">
                <img src="{{ asset('images/logo-foodtyu.png') }}" 
                     alt="Food-TyU Illustration" 
                     class="w-full h-full object-cover"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/256x256/5D89B3/FFFFFF?text=Food-TyU+Logo';">
            </div>
        </div>

        <div class="text-center mt-4">
            <h1 class="text-5xl font-serif-custom font-black text-black tracking-tight">Food-TyU</h1>
        </div>

        <div class="w-full px-6 absolute bottom-12 text-center">
            
            <a href="/home" class="block w-full bg-[#5D89B3] text-white py-4 rounded-2xl font-bold shadow-lg active:scale-95 transition-transform duration-150 mb-4 uppercase tracking-wider">
                Get Started
            </a>
            
            <p class="text-sm text-gray-600 font-medium">
                Already a member? 
                <a href="/login" class="text-black font-extrabold border-b-2 border-black ml-1">Login</a>
            </p>
            
            <div class="w-32 h-1.5 bg-black mx-auto mt-10 rounded-full opacity-90"></div>
        </div>
    </div>

</body>
</html>