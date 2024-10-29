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
    <header class="bg-slate-800 shadow-xl text-lg font-bold">
        <nav class="font-semibold text-white">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <span class="px-2 rtl:space-x-reverse border-2 border-white text-white">
                    @php
                        $hr_Sub = date('H');

                        if ($hr_Sub == '00') {
                            $hr_Sub = '24';
                        }

                        if ($hr_Sub >= 8 && $hr_Sub < 16) {
                            echo '早班';
                        } elseif ($hr_Sub >= 16 && $hr_Sub < 24) {
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

                    <!-- Dropdown menu -->
                    <div id="dropdownDivider" class="z-10 hidden bg-blue-600 px-4">
                        <div class="py-2">
                            <a href="{{ route('logout') }}" class="block text-center text-sm hover:text-whit"
                                data-modal-target="Modal" data-modal-toggle="Modal">登 出</a>
                        </div>
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

    <main class="relative py-8 mx-auto px-2 max-w-screen-2xl text-slate-900 h-screen">
        {{ $slot }}
    </main>

    {{-- Modal Loading --}}
    <div id="Modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden absolute left-0 top-0 z-50 flex items-center justify-center w-full h-full bg-gray-400/50 mx-auto">
        <svg aria-hidden="true" class="w-40 h-40 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill" />
        </svg>
    </div>
</body>

</html>
