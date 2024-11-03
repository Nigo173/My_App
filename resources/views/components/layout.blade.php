<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ url('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ url('assets/jquery.min.js') }}"></script>

</head>

<body class="bg-slate-200">
    <header class="bg-slate-800 shadow-xl text-lg font-bold fixed w-full z-40">
        <nav class="font-semibold text-white">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <span class="px-2 rtl:space-x-reverse border-2 border-white text-white">
                    @php
                        $hr_Sub = date('H');

                        if ($hr_Sub >= 8 && $hr_Sub < 16) {
                            echo '早班';
                        } elseif ($hr_Sub >= 16) {
                            echo '中班';
                        } else {
                            echo '晚班';
                        }
                    @endphp
                </span>

                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

                    <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium text-sm px-3 py-2 text-center inline-flex items-center"
                        type="button">{{ session('Name') }}<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>

                    </button>
                    <div id="dropdownDivider" class="z-10 hidden bg-white rounded-sm shadow-xl w-28">
                        <ul class="px-2 py-2 text-sm text-gray-700 text-center">
                            @if (intval(session('Level')) > 1)
                                <li>
                                    @if (Route::current()->getName() == 'settings')
                                        <form action="{{ url('settings/admins/update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="account" value="{{ session('Account') }}">
                                            <a href="#" class="block px-4 py-3 hover:bg-gray-200"
                                                onclick="this.closest('form').submit()" title="編 輯">編 輯</a>
                                        </form>
                                    @endif
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}" class="block px-4 py-3 hover:bg-gray-200"
                                    title="登 出">登 出</a>
                            </li>
                        </ul>
                    </div>

                    <button data-collapse-toggle="navbar-cta" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100"
                        aria-controls="navbar-cta" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
                    <ul
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="{{ route('member') }}"
                                class="block py-2 px-3 md:p-0 hover:text-blue-500 {{ Request::segment(1) == 'member' ? 'text-blue-500' : '' }}">會員管理</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="block py-2 px-3 md:p-0 hover:text-blue-500 {{ Request::segment(1) == 'dashboard' ? 'text-blue-500' : '' }}">來店統計</a>
                        </li>
                        <li>
                            <a href="{{ route('trade') }}"
                                class="block py-2 px-3 md:p-0 hover:text-blue-500 {{ Request::segment(1) == 'trade' ? 'text-blue-500' : '' }}">點餐系統</a>
                        </li>
                        <li>
                            <a href="{{ route('settings') }}"
                                class="block py-2 px-3 md:p-0 hover:text-blue-500 {{ Request::segment(1) == 'settings' ? 'text-blue-500' : '' }}">系統管理</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="relative py-8 mx-auto px-2 max-w-screen-2xl text-slate-900 h-screen pt-24">
        {{ $slot }}
    </main>

    {{-- Modal Loading --}}
    <x-loading-layout />
</body>

</html>
