<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ url('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/jquery.min.js') }}"></script>

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
                    </div>
                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">密碼</label>
                        <input type="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <button type="submit"
                        class="w-full text-white font-semibold bg-slate-700 hover:bg-slate-600 rounded-lg text-sm px-5 py-2.5 text-center">登入
                    </button>
                </form>
            </div>
        </div>
    </section>
    {{-- Toast --}}
    <div id="toast-success"
        class="hidden absolute right-10 top-10 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200 ">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-normal" id="toast-success-msg"></div>
        <button type="button" id="toast-success-button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    {{-- Modal Loading --}}
    <div id="Modal" data-modal-backdrop="static" tabindex="-1"
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
                                }, 1000);
                            } else {
                                $('#toast-success').toggleClass(
                                    'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'
                                );
                                $('#toast-success').find('path').attr('d',
                                    'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                                );
                            }
                            $('#toast-success').removeClass('hidden');
                            $('#toast-success-msg').text(response.msg);
                        },
                        error: function(response) {
                            $('#toast-success').removeClass('hidden');
                            $('#toast-success-msg').text('會員資料異常');
                            $('#toast-success').toggleClass(
                                'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'
                            );
                            $('#toast-success').find('path').attr('d',
                                'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                            );
                        },
                        complete: function() {
                            setTimeout(function() {
                                $('#Modal').addClass('hidden');
                                form.trigger('reset');
                                $('#toast-success').addClass('hidden');
                            }, 800);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
