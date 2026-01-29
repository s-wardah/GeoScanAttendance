<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GeoScan Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }

        /* Animasi Background Melayang */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .float-animation { animation: float 6s infinite ease-in-out; }

        /* Animasi Denyut Logo */
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.6; }
        }
        .pulse-circle {
            position: absolute; width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(30, 27, 75, 0) 70%);
            animation: logoPulse 4s infinite ease-in-out;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-[1100px] h-auto md:h-[700px] rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
        
        <div class="w-full md:w-[55%] p-10 md:p-16 flex flex-col justify-center">
            <div class="mb-8">
                <img src="{{ asset('image/geoscan_logo.png') }}" alt="GeoScan Logo" class="h-12 w-auto mb-6">
                <h1 class="text-4xl font-extrabold text-[#1e1b4b] tracking-tight">Selamat Datang</h1>
                <p class="text-gray-400 mt-2 font-medium">Silakan masuk untuk mengelola kehadiran Anda.</p>
            </div>

            @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm font-semibold border border-red-100 flex items-center">
                <span class="mr-2">⚠️</span> {{ session('error') }}
            </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf
                <div class="group">
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[2px] group-focus-within:text-indigo-600 transition-colors">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" required placeholder="name@school.com"
                            class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all text-gray-800 placeholder:text-gray-300">
                    </div>
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[2px] group-focus-within:text-indigo-600 transition-colors">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all text-gray-800 placeholder:text-gray-300">
                </div>

                <div class="flex items-center justify-between pt-2 text-sm">
                    <label class="flex items-center text-gray-500 cursor-pointer">
                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2"> Ingat saya
                    </label>
                    <a href="#" class="text-indigo-600 font-bold hover:underline">Lupa Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#1e1b4b] to-[#312e81] text-white py-4 rounded-2xl font-bold text-lg hover:shadow-2xl hover:scale-[1.02] transition-all active:scale-95 shadow-lg shadow-indigo-200 mt-4">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm font-medium uppercase tracking-widest mb-4">Atau masuk dengan</p>
                <div class="flex justify-center space-x-4">
                    <button class="p-3 bg-white border border-gray-100 rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6" alt="Google">
                    </button>
                    <button class="p-3 bg-[#1877F2] rounded-xl hover:brightness-110 transition-all shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden md:flex w-[45%] bg-[#1e1b4b] relative items-center justify-center overflow-hidden">
            <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-indigo-500 rounded-full opacity-20 blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-blue-400 rounded-full opacity-20 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center px-12">
                <div class="pulse-circle"></div>
                <img src="{{ asset('image/geoscan_logo.png') }}" alt="Logo"
                    class="relative z-20 w-64 drop-shadow-[0_20px_20px_rgba(0,0,0,0.3)] float-animation filter brightness-125">
                
                <div class="mt-12">
                    <h2 class="text-white text-2xl font-bold mb-4">GeoScan Presence</h2>
                    <p class="text-indigo-200 font-medium leading-relaxed opacity-80">
                        Solusi terbaik absensi digital berbasis Geolocation dan QR-Code yang presisi.
                    </p>
                </div>
            </div>

            <div class="absolute bottom-8 text-indigo-300 text-xs opacity-50 font-bold tracking-widest">
                VERSI 2.0.26
            </div>
        </div>
    </div>

</body>

</html>