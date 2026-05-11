<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hulahup Desktop - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FBF9E4; } /* Pearl Perfect */
        .sidebar-active { background-color: #FBF9E4; color: #122C4F !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .food-card:hover img { transform: scale(1.1); }
        
        @keyframes bounce-in {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        .cart-item-anim { animation: bounce-in 0.4s ease-out; }
        .bg-midnight { background-color: #122C4F; }
        .text-pearl { color: #FBF9E4; }
    </style>
</head>
<body class="h-screen flex overflow-hidden">

    <aside class="w-72 bg-midnight text-white flex flex-col py-9 px-7 shrink-0 shadow-2xl z-20">
        <div class="mb-12">
            <h1 class="text-3xl font-black italic text-[#FBF9E4] tracking-tighter">Hulahup.</h1>
            <p class="text-[10px] opacity-50 tracking-[0.2em] font-bold mt-1 uppercase">Kantin Tel-U Purwokerto</p>
        </div>

        <nav class="flex-1 space-y-3">
            <a href="javascript:void(0)" class="sidebar-active flex items-center gap-4 px-5 py-4 rounded-[22px] font-bold transition-all duration-300">
                <i class="fa-solid fa-house text-lg"></i> 
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-4 px-5 py-4 rounded-[22px] font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all">
                <i class="fa-solid fa-utensils text-lg"></i> 
                <span>Menu Kantin</span>
            </a>
            <a href="/history" class="flex items-center gap-3 p-3 text-gray-400 hover:bg-blue-50 hover:text-blue-900 rounded-xl transition">
                <i class="fas fa-history"></i>
                <span>Riwayat Pesan</span>
            </a>
            <a href="/topup" class="flex items-center gap-3 p-3 text-gray-400 hover:bg-blue-50 hover:text-blue-900 rounded-xl transition">
                <i class="fas fa-wallet"></i>
                <span>Saldo TyU-Pay</span>
            </a>
        </nav>

        <div class="mt-auto bg-white/10 backdrop-blur-md p-5 rounded-[30px] border border-white/10">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-12 h-12 rounded-full bg-[#FBF9E4] p-0.5 overflow-hidden ring-2 ring-white/20">
                    <img src="https://ui-avatars.com/api/?name=Salsabilla&background=FBF9E4&color=122C4F" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate">Salsabilla Nurul</p>
                    <p class="text-[10px] text-[#FBF9E4] opacity-80 uppercase font-black tracking-widest">Premium Member</p>
                </div>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full text-center py-2 bg-red-400/20 hover:bg-red-400/40 text-red-100 rounded-xl text-[11px] font-bold transition-all">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i> SIGN OUT
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 h-screen overflow-y-auto p-10 no-scrollbar">
        <header class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-black text-midnight">Selamat Siang, Salsabilla! 👋</h2>
                <p class="text-slate-500 font-medium mt-1">Laper ngerjain tugas? Pesan makan yuk!</p>
            </div>
            <div class="relative w-[400px]">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Cari ayam bakar, seblak, atau minuman..." class="w-full pl-14 pr-6 py-4 rounded-2xl border-none shadow-md focus:ring-2 focus:ring-[#5B88B2] outline-none text-sm transition-all">
            </div>
        </header>

        <section class="bg-gradient-to-r from-[#5B88B2] to-[#122C4F] rounded-[45px] p-12 text-white flex justify-between items-center mb-12 shadow-xl relative overflow-hidden group">
            <div class="relative z-10 max-w-md">
                <span class="bg-[#FBF9E4] text-[#122C4F] px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">Flash Sale Hari Ini</span>
                <h3 class="text-6xl font-black mt-5 mb-3 italic tracking-tighter text-[#FBF9E4]">Diskon 25%</h3>
                <p class="text-lg opacity-90 font-medium leading-relaxed">Spesial untuk kamu mahasiswa Teknik Informatika yang lagi ngerjain tugas!</p>
                <button class="mt-8 bg-[#FBF9E4] text-[#122C4F] px-10 py-4 rounded-[20px] font-black text-sm shadow-lg hover:scale-105 transition-all uppercase">PAKAI VOUCHER</button>
            </div>
            <i class="fa-solid fa-burger text-[250px] absolute -right-10 -bottom-10 opacity-10 rotate-12 group-hover:rotate-0 transition-all duration-700"></i>
        </section>

        <div class="flex justify-between items-center mb-8">
            <div class="flex gap-3">
                <button onclick="filterMenu('all')" id="btn-all" class="filter-btn px-8 py-3 bg-midnight text-white rounded-full text-xs font-bold shadow-md transition-all">All</button>
                <button onclick="filterMenu('food')" id="btn-food" class="filter-btn px-8 py-3 bg-white text-slate-400 rounded-full text-xs font-bold shadow-sm border border-slate-100 hover:bg-slate-50 transition-all">Food</button>
                <button onclick="filterMenu('drinks')" id="btn-drinks" class="filter-btn px-8 py-3 bg-white text-slate-400 rounded-full text-xs font-bold shadow-sm border border-slate-100 hover:bg-slate-50 transition-all">Drinks</button>
            </div>
            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-[10px] uppercase font-bold text-slate-400">Saldo TyU-Pay</p>
                <p class="text-lg font-black text-midnight">RP 50.000</p>
            </div>
        </div>

        <div id="foodGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/chicken.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Mie Ayam Bakso</h3>
                        <p class="text-xs text-gray-500">Kenyang & Lezat</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.8</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 18.000</span>
                    <button onclick="addToCart('Mie Ayam Bakso', 18000, '{{ asset('images/chicken.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/seblak.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Seblak Jeletot</h3>
                        <p class="text-xs text-gray-500">Pedas Mantap</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.9</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 15.000</span>
                    <button onclick="addToCart('Seblak Jeletot', 15000, '{{ asset('images/seblak.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/katsu.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Chicken Katsu</h3>
                        <p class="text-xs text-gray-500">Kenyang & Crunchy</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.7</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 22.000</span>
                    <button onclick="addToCart('Chicken Katsu', 22000, '{{ asset('images/katsu.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/taichan.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Sate Taichan</h3>
                        <p class="text-xs text-gray-500">Gurih & Pedas</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.8</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 20.000</span>
                    <button onclick="addToCart('Sate Taichan', 20000, '{{ asset('images/taichan.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/siomay.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Siomay Bandung</h3>
                        <p class="text-xs text-gray-500">Ikan Tenggiri Asli</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.6</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 12.000</span>
                    <button onclick="addToCart('Siomay Bandung', 12000, '{{ asset('images/siomay.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="https://images.unsplash.com/photo-1512058560366-18510be2db19?q=80&w=500" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Nasi Goreng</h3>
                        <p class="text-xs text-gray-500">Spesial Telur Mata Sapi</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.9</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 15.000</span>
                    <button onclick="addToCart('Nasi Goreng', 15000, 'https://images.unsplash.com/photo-1512058560366-18510be2db19?q=80&w=500')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="drinks" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/ice-americano.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Ice Americano</h3>
                        <p class="text-xs text-gray-500">Segar & Melek</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.5</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 12.000</span>
                    <button onclick="addToCart('Ice Americano', 12000, '{{ asset('images/ice-americano.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="drinks" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="{{ asset('images/watermelon.png') }}" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Jus Semangka</h3>
                        <p class="text-xs text-gray-500">Manis Alami</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.5</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 8.000</span>
                    <button onclick="addToCart('Jus Semangka', 8000, '{{ asset('images/watermelon.png') }}')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

            <div data-category="food" class="bg-white p-4 rounded-[32px] shadow-sm hover:shadow-md transition">
                <img src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?q=80&w=500" class="w-full h-44 object-cover rounded-[24px] mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Ramen Shoyu</h3>
                        <p class="text-xs text-gray-500">Kuah Kaldu Gurih</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-1 rounded-full font-bold">⭐ 4.9</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-extrabold text-[#122C4F]">RP 25.000</span>
                    <button onclick="addToCart('Ramen Shoyu', 25000, 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?q=80&w=500')" class="bg-[#122C4F] text-white w-10 h-10 rounded-2xl flex items-center justify-center hover:bg-blue-800">+</button>
                </div>
            </div>

        </div>
    </main>

    <aside class="w-[380px] bg-white border-l border-slate-100 p-10 flex flex-col shrink-0 shadow-2xl relative z-20">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-2xl font-black text-midnight tracking-tight italic">Keranjang</h3>
            <span id="cartCount" class="bg-slate-100 text-slate-500 px-3 py-1 rounded-lg text-xs font-bold">0 Items</span>
        </div>
        
        <div id="cartItems" class="flex-1 space-y-8 overflow-y-auto no-scrollbar pr-2">
            <div class="text-center py-20 opacity-20">
                <i class="fa-solid fa-basket-shopping text-6xl mb-4"></i>
                <p class="text-sm font-bold uppercase tracking-widest">Belum ada pesanan</p>
            </div>
        </div>

        <div class="mt-10 pt-8 border-t-2 border-dashed border-slate-100">
            <div class="space-y-4 mb-8">
                <div class="flex justify-between text-[13px] text-slate-500 font-bold uppercase tracking-wider">
                    <span>Subtotal</span>
                    <span id="subtotal" class="text-midnight">RP 0</span>
                </div>
                <div class="flex justify-between items-end pt-4 border-t border-slate-50">
                    <span class="text-lg font-black text-midnight italic">Total</span>
                    <span id="totalPrice" class="text-3xl font-black text-[#5B88B2] tracking-tighter">RP 0</span>
                </div>
            </div>
            
            <div class="mt-6">
                <p class="font-bold text-gray-800 mb-3">Metode Pembayaran</p>
                <div class="grid grid-cols-1 gap-2">
                    <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment" value="qris" checked>
                            <span>QRIS</span>
                        </div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-4">
                    </label>

                    <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment" value="ewallet">
                            <span>E-Wallet (OVO/Dana/GoPay)</span>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment" value="bank">
                            <span>Transfer Bank</span>
                        </div>
                    </label>
                </div>
            </div>
            
            <button onclick="checkout()" class="w-full bg-[#5B88B2] text-white py-5 rounded-[25px] font-black text-sm shadow-xl shadow-blue-100 hover:bg-midnight transition-all uppercase tracking-widest active:scale-95">
                Bayar Sekarang
            </button>
        </div>
    </aside>

    <div id="paymentModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-[40px] p-10 shadow-2xl animate-bounce-in">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-black text-midnight italic">Pilih Pembayaran</h3>
                <button onclick="closePayment()" class="text-slate-400 hover:text-midnight transition"><i class="fa-solid fa-circle-xmark text-2xl"></i></button>
            </div>

            <div class="space-y-4">
                <button onclick="showQR()" class="w-full flex items-center justify-between p-5 border-2 border-slate-50 rounded-3xl hover:border-[#5B88B2] hover:bg-slate-50 transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#5B88B2]"><i class="fa-solid fa-qrcode text-xl"></i></div>
                        <span class="font-bold text-slate-700">QRIS / TyU-Pay</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-[#5B88B2]"></i>
                </button>
            </div>

            <div id="qrContainer" class="hidden mt-8 text-center bg-slate-50 p-8 rounded-[35px] border-2 border-dashed border-slate-200">
                <p class="text-[10px] font-black uppercase text-slate-400 mb-5 tracking-[0.2em]">Scan QR Untuk Membayar</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=HULAHUP-SALSABILLA" class="mx-auto shadow-xl rounded-2xl mb-6 border-4 border-white">
                <button onclick="processPayment()" class="w-full bg-[#5B88B2] text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-midnight transition shadow-lg shadow-blue-100">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function addToCart(name, price, img) {
            const existingItem = cart.find(item => item.name === name);
            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ name, price, img, qty: 1 });
            }
            updateCartUI();
        }

        function updateCartUI() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('totalPrice');

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center py-20 opacity-20">
                        <i class="fa-solid fa-basket-shopping text-6xl mb-4"></i>
                        <p class="text-sm font-bold uppercase tracking-widest">Belum ada pesanan</p>
                    </div>`;
            } else {
                cartItems.innerHTML = '';
            }

            let subtotal = 0;
            cart.forEach((item, index) => {
                subtotal += item.price * item.qty;
                cartItems.innerHTML += `
                    <div class="flex items-center gap-5 group cart-item-anim">
                        <div class="w-20 h-20 bg-slate-100 rounded-[25px] overflow-hidden shrink-0 shadow-sm border border-slate-50">
                            <img src="${item.img}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <p class="text-[13px] font-bold text-midnight mb-1 leading-tight uppercase">${item.name}</p>
                            <p class="text-xs text-[#5B88B2] font-black italic">RP ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex flex-col items-center gap-2 bg-slate-50 rounded-2xl p-2">
                            <button onclick="changeQty(${index}, 1)" class="text-[#5B88B2] hover:scale-125 transition"><i class="fa-solid fa-plus text-[10px]"></i></button>
                            <span class="text-xs font-black text-midnight">${item.qty}</span>
                            <button onclick="changeQty(${index}, -1)" class="text-slate-300 hover:text-red-500 transition"><i class="fa-solid fa-minus text-[10px]"></i></button>
                        </div>
                    </div>`;
            });

            cartCount.innerText = `${cart.length} Items`;
            subtotalEl.innerText = `RP ${subtotal.toLocaleString('id-ID')}`;
            totalEl.innerText = `RP ${subtotal.toLocaleString('id-ID')}`;
        }

        function changeQty(index, delta) {
            cart[index].qty += delta;
            if (cart[index].qty <= 0) cart.splice(index, 1);
            updateCartUI();
        }

        function filterMenu(category) {
            const items = document.querySelectorAll('#foodGrid [data-category]');
            const buttons = document.querySelectorAll('.filter-btn');

            buttons.forEach(btn => {
                btn.classList.remove('bg-midnight', 'text-white', 'shadow-md');
                btn.classList.add('bg-white', 'text-slate-400');
            });

            const activeBtn = document.getElementById(`btn-${category}`);
            activeBtn.classList.add('bg-midnight', 'text-white', 'shadow-md');
            activeBtn.classList.remove('bg-white', 'text-slate-400');

            items.forEach(item => {
                item.style.display = (category === 'all' || item.dataset.category === category) ? 'block' : 'none';
            });
        }

        function checkout() {
            if (cart.length === 0) return alert("Pilih menu dulu!");
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePayment() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('qrContainer').classList.add('hidden');
        }

        function showQR() {
            document.getElementById('qrContainer').classList.remove('hidden');
        }

        function processPayment() {
            alert("Salsabilla, Pembayaran Berhasil! Pesananmu sedang diproses kantin.");
            cart = [];
            updateCartUI();
            closePayment();
        }

        document.getElementById('searchInput').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.food-card').forEach(item => {
                const name = item.querySelector('.food-name').innerText.toLowerCase();
                item.style.display = name.includes(query) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>