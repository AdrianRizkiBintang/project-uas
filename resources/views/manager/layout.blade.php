<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel {{ auth()->user()->role === 'owner' ? 'Owner' : (auth()->user()->role === 'manager' ? 'Manager' : 'Karyawan') }} — FoodOrder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-gray-900 text-white px-6 py-3 flex items-center justify-between">
    <span class="font-bold text-lg">FoodOrder
        <span class="text-xs px-2 py-0.5 rounded ml-2
            {{ auth()->user()->role === 'owner' ? 'bg-red-500' : 'bg-orange-500' }}">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </span>

    <div class="flex items-center gap-6 text-sm">
    <a href="{{ route('manager.dashboard') }}" class="hover:text-orange-400">Dashboard</a>

    @if(auth()->user()->isOwner() || auth()->user()->isManager())
        <a href="{{ route('manager.menu.index') }}" class="hover:text-orange-400">Menu</a>
        <a href="{{ route('manager.outlet.index') }}" class="hover:text-orange-400">Outlet</a>
        <a href="{{ route('manager.promo.index') }}" class="hover:text-orange-400">Promo</a>
        <a href="{{ route('manager.user.index') }}" class="hover:text-orange-400">Users</a>
    @endif

    <a href="{{ route('manager.order.index') }}" class="hover:text-orange-400">Pesanan</a>

    <a href="{{ route('manager.revenue') }}" class="hover:text-orange-400">
        Pendapatan Harian
    </a>

    <a href="{{ route('home') }}" class="hover:text-orange-400">← Ke Web</a>

    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="hover:text-red-400">Keluar</button>
    </form>
</div>
</nav>

<main class="max-w-7xl mx-auto p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</main>

</body>
</html>