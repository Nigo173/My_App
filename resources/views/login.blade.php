<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ url('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ url('assets/jquery.min.js') }}"></script>

    <script>
        setTimeout(function() => {
            window.history.forward();
        }, 0);
        window.onunload = function() {
            null;
        }
    </script>
</head>

<body class="flex items-center justify-center px-10 py-10">
    <section class="bg-gray-900 w-full h-full flex items-center justify-center rounded bg-opacity-5">
        <div
            class="w-80 border-2 border-slate-600 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl font first-letter:-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    點餐系統
                </h1>
                <form class="space-y-8 md:space-y-6" class="max-w-md mx-auto" data-action="{{ route('user_login') }}"
                    method="POST">
                    @csrf
                    <div>
                        <label for="account"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">帳號</label>
                        <input type="text" name="account" value=""
                            class="bg-gray-50 border
                                border-gray-300
                                text-gray-900 rounded-lg focus:ring-primary-600
                                focus:border-primary-600 block w-full p-2.5
                                 dark:bg-gray-700 dark:border-gray-600
                                  dark:placeholder-gray-400
                                   dark:text-white
                                    dark:focus:ring-blue-500
                                 dark:focus:border-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">密碼</label>
                        <input type="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                    </div>
                    <button type="submit"
                        class="w-full text-white font-semibold bg-slate-700 hover:bg-slate-600 rounded-lg text-sm px-5 py-2.5 text-center">登入
                    </button>
                </form>
            </div>
        </div>
    </section>
    {{-- Toast --}}
    <x-success-layout />
    {{-- Modal Loading --}}
    <x-loading-layout />

    <script>
        $(function() {
            var form = $('form');

            $(form).on('submit', function(event) {
                event.preventDefault();
                // 驗證表單
                var reportValidity = form[0].reportValidity();

                if (reportValidity) {
                    $('#Modal').removeClass('hidden');
                    var url = $(this).attr('data-action');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            if (response.msg.indexOf('成功') > -1) {
                                setTimeout(function() {
                                    window.location.href = 'dashboard';
                                }, 500);
                            } else {
                                $('#toast-success').removeClass('text-green-500');
                                $('#toast-success').addClass('text-red-500');
                                $('#success-path').attr('d',
                                    'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                                );
                            }

                            $('#toast-success-msg').text(response.msg);
                            $('#toast-success').removeClass('hidden');
                        },
                        error: function(response) {
                            $('#toast-success-msg').text('資料異常');
                            $('#toast-success').removeClass('text-green-500');
                            $('#toast-success').addClass('text-red-500');
                            $('#success-path').attr('d',
                                'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                            );
                            $('#toast-success').removeClass('hidden');
                        },
                        complete: function() {
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
