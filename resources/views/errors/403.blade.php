<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="text-8xl font-bold text-orange-500 mb-4">403</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-8">Kamu tidak punya izin untuk mengakses halaman ini.</p>

        <div class="flex gap-4 justify-center">
            @auth
                @if(auth()->user()->isStaff())
                    <a href="{{ route('manager.dashboard') }}"
                       class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                        Ke Panel Manager
                    </a>
                @else
                    <a href="{{ route('home') }}"
                       class="bg-orange-500 text-white px-6 py-6 rounded-lg hover:bg-orange-600">
                        Ke Beranda
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                    Login
                </a>
            @endauth

            <a href="javascript:history.back()"
               class="border border-gray-300 text-gray-600 px-6 py-2 rounded-lg hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </div>
</body>
</html>