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
                                                    class="px-2 py-1.5 mt-3 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
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
    <x-success-layout />
    {{-- Modal Loading --}}
    <x-loading-layout />

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
                            } else {
                                $('#toast-success').removeClass('text-green-500');
                                $('#toast-success').addClass('text-red-500');
                                $('#success-path').attr('d',
                                    'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                                );
                            }

                            $('#toast-success-msg').text(response.msg);
                            $('#toast-success').removeClass('hidden');

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
</x-layout>
