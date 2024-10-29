<x-layout>
    <div
        class="relative {{ !isset($label) ? 'max-w-lg bg-slate-200 mx-auto' : '' }} overflow-x-auto shadow-xl rounded-lg">
        <div class="pX-2 py-2">
            @if (isset($label) && !isset($data))
                {{-- 表單 --}}
                <div class="flex justify-center mx-auto w-100 items-center gap-2">
                    <form class="max-w-md mx-auto w-full">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" name="search"
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="關鍵字 帳號 或 姓名" />
                            <button type="submit"
                                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">搜尋</button>
                        </div>
                    </form>
                    @if (isset($label))
                        @if (sizeof($label) <= 7 && session('Level') == '2')
                            <form action="{{ route('label') }}" method="POST">
                                @csrf
                                <input type="hidden" name="create" value="create">
                                <input type="submit" value="新增"
                                    class="text-white end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2" />
                            </form>
                        @endif
                    @endif
                </div>
                {{-- 表格清單 --}}
                <table class="w-full mt-5 text-md text-center text-gray-600 border border-gray-400">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3">
                                標籤代號
                            </th>
                            <th scope="col">
                                標題1
                            </th>
                            <th scope="col">
                                標題2
                            </th>
                            <th scope="col">
                                標題3
                            </th>
                            <th scope="col">
                                標題4
                            </th>
                            <th scope="col">
                                格式
                            </th>
                            <th scope="col">
                                資料日期
                            </th>
                            @if (session('Level') == '2')
                                <th scope="col">
                                    編輯
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($label))
                            @foreach ($label as $labels)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $labels->l_Title }}
                                    </td>
                                    <td>
                                        {{ $labels->l_TitleOne }}
                                    </td>
                                    <td>
                                        {{ $labels->l_TitleTwo }}
                                    </td>
                                    <td>
                                        {{ $labels->l_TitleThree }}
                                    </td>
                                    <td>
                                        {{ $labels->l_TitleFour }}
                                    </td>
                                    <td>
                                        <div class="flex justify-center items-center">
                                            @if ($labels->l_Current == 'day')
                                                <div
                                                    class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2">
                                                </div>
                                                整日限一次
                                            @elseif($labels->l_Current == 'shift')
                                                <div
                                                    class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-green-500 border-2 border-white rounded-full -top-2 -end-2">
                                                </div>
                                                班次限制
                                            @elseif($labels->l_Current == 'all')
                                                <div
                                                    class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-500 border-2 border-white rounded-full -top-2 -end-2">
                                                </div>
                                                無限制
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $labels->created_at }}
                                    </td>
                                    @if (session('Level') == '2')
                                        <td>
                                            <form action="{{ route('label') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="Id" value="{{ $labels->id }}">
                                                <button type="submit"
                                                    class="px-2 py-1.5 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
                                                    編輯
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @else
                {{-- 表單 --}}
                <form id="formCreate" class="max-w-md mx-auto" data-action="{{ route($action) }}" method="POST">
                    @csrf
                    @if (isset($data))
                        <input type="hidden" name="Id" value="{{ isset($data) ? $data->id : '' }}">
                        <input type="hidden" name="update">
                    @else
                        <input type="hidden" name="create">
                    @endif

                    <div class="grid grid-rows-4 grid-cols-1 gap-3 mb-5 border-2 border-gray-500">
                        {{-- 代號 --}}
                        <div class="mx-auto">
                            <input type="text" name="title" maxlength="3"
                                value="{{ isset($data) ? $data->l_Title : '' }}"
                                class="block py-2.5 px-0 w-50 text-xl text-center text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder="標籤代號" required />
                        </div>
                        {{-- 標題1 --}}
                        <div class="mx-auto">
                            <input type="text" name="titleOne" maxlength="10"
                                value="{{ isset($data) ? $data->l_TitleOne : '' }}"
                                class="block py-2.5 px-0 w-50 text-xl text-center text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                        </div>
                        {{-- 標題2 --}}
                        <div class="mx-auto">
                            <input type="text" name="titleTwo" maxlength="10"
                                value="{{ isset($data) ? $data->l_TitleTwo : '' }}"
                                class="block py-2.5 px-0 w-50 text-xl text-center text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                        </div>
                        {{-- 標題2 3 --}}
                        <div class="grid grid-rows-subgrid gap-4 mb-5 row-span-1">
                            <div class="row-start-2">
                                <input type="text" name="titleThree" maxlength="5"
                                    value="{{ isset($data) ? $data->l_TitleThree : '' }}"
                                    class="block py-2.5 px-0 w-50 text-lg text-center text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                            </div>
                            <div class="row-start-2">
                                <input type="text" name="titleFour" maxlength="5"
                                    value="{{ isset($data) ? $data->l_TitleFour : '' }}"
                                    class="block py-2.5 px-0 w-50 text-lg text-center text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                            </div>
                        </div>
                        {{-- 格式篩選 --}}
                        <div class="flex justify-around py-4 px-0 w-full text-sm">
                            <div class="flex items-center me-4">
                                <input id="state" type="radio" value="all" name="current"
                                    {{ isset($data) && $data->l_Current == 'all' ? 'checked' : 'checked' }}
                                    class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="state"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">無限制</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input id="state" type="radio" value="shift" name="current"
                                    {{ isset($data) && $data->l_Current == 'shift' ? 'checked' : '' }}
                                    class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="state"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">班次限制</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input id="state" type="radio" value="day" name="current"
                                    {{ isset($data) && $data->l_Current == 'day' ? 'checked' : '' }}
                                    class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="level"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">整日限一次</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        @if (isset($data))
                            <button type="submit"
                                class="text-white bg-yellow-400 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-10 py-2 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                編輯
                            </button>
                        @else
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-10 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                新增
                            </button>
                        @endif
                    </div>
                </form>
            @endif
        </div>
    </div>
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
            var form = $('#formCreate,#formDelete');

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
                                form.trigger("reset");
                            } else {
                                $('#toast-success').toggleClass(
                                    'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'
                                );
                                $('#toast-success').find('path').attr('d',
                                    'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                                );
                            }
                            // 刪除tr
                            if (url.indexOf("delete") > -1) {
                                if (response.msg.indexOf('成功') > -1) {
                                    var jsonstringify = JSON.stringify(form.serializeArray());
                                    var jsonEle = JSON.parse(jsonstringify);
                                    $('#' + jsonEle[2]['value']).remove();
                                }
                            } else if (url.indexOf('create')) {
                                setTimeout(function() {
                                    window.location.href = 'label';
                                }, 1000);
                            }
                            $('#toast-success').removeClass('hidden');
                            $('#toast-success-msg').text(response.msg);
                        },
                        error: function(response) {},
                        complete: function() {
                            $('#Modal').addClass('hidden');

                            setTimeout(function() {
                                form.trigger('reset');
                                $('#toast-success').addClass('hidden');
                            }, 2000);
                        }
                    });
                }
            });
        });
    </script>
</x-layout>
