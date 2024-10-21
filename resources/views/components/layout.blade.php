<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-200">
    <header class="bg-slate-800 shadow-lg text-lg font-bold">
        <nav class="flex">
            <div class="flex items-center justify-center gap-20  pt-5 pb-5 w-5/6">
                <a href="{{ route('member') }}" class="nav-link text-slate-100">會員管理</a>
                <a href="{{ route('dashboard') }}" class="nav-link text-slate-100">來店統計</a>
                <a href="{{ route('trade') }}" class="nav-link text-slate-100">點餐系統</a>
                <a href="{{ route('settings') }}" class="nav-link text-slate-100">系統管理</a>
            </div>

            <div class="flex items-center justify-center gap-20 w-1/6">
                <span class="text-slate-300 border-b-4 border-indigo-500">{{ session('Name') }}</span>
                <a href="{{ route('logout') }}" class="nav-link text-slate-100">登出</a>
            </div>
        </nav>
    </header>

    <main class="relative py-8 mx-auto px-2 max-w-screen-2xl text-slate-900">
        {{ $slot }}
    </main>
</body>

</html>
