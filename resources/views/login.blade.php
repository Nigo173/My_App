<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登入</title>
    <title>{{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center px-10 py-10">
    <section class="bg-gray-900 w-full h-full flex items-center justify-center rounded bg-opacity-5">
        <div
            class="w-80 border-2 border-slate-600 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl font first-letter:-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    點餐系統
                    <span class="text-red-600">
                        {{ isset($err) && $err != '' ? $err : '' }}
                    </span>
                </h1>
                <form class="space-y-8 md:space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="account"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">帳號</label>
                        <input type="text" name="account" value="{{ old('account') }}"
                            class="bg-gray-50 border
                                border-gray-300
                                text-gray-900 rounded-lg focus:ring-primary-600
                                focus:border-primary-600 block w-full p-2.5
                                 dark:bg-gray-700 dark:border-gray-600
                                  dark:placeholder-gray-400
                                   dark:text-white
                                    dark:focus:ring-blue-500
                                 dark:focus:border-blue-500">
                        <p class="text-red-600">
                            @error('account')
                                輸入錯誤
                            @enderror
                        </p>
                    </div>
                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">密碼</label>
                        <input type="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @error('password')
                            <p class="text-red-600">
                                輸入格式錯誤
                            </p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full text-white font-semibold bg-slate-700 hover:bg-slate-600 rounded-lg text-sm px-5 py-2.5 text-center">登入
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
