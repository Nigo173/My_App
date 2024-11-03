<x-layout>
    <div class="relative overflow-x-auto shadow-xl rounded-lg">
        <div class="px-2 py-2">
            {{-- 搜尋 --}}
            <form class="max-w-3xl mx-auto px-2 py-2 bg-gray-300 flex justify-center items-center gap-1" method="GET">
                @if (isset($trade))
                    <div class="px-3 py-2.5 text-sm font-medium text-white bg-gray-700 rounded-lg shadow-sm">
                        搜尋筆數: {{ sizeof($trade) }}
                    </div>
                @endif
                <div class="w-100 grid gap-4 grid-cols-5">
                    <select name="selectShift"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>班查詢</option>
                        <option value="早班"
                            {{ isset($_GET['selectShift']) && $_GET['selectShift'] == '早班' ? 'selected' : '' }}>早班
                        </option>
                        <option value="中班"
                            {{ isset($_GET['selectShift']) && $_GET['selectShift'] == '中班' ? 'selected' : '' }}>中班
                        </option>
                        <option value="晚班"
                            {{ isset($_GET['selectShift']) && $_GET['selectShift'] == '晚班' ? 'selected' : '' }}>晚班
                        </option>
                    </select>
                    <select name="selectYear" onchange="setLastDate()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>年查詢</option>
                        @for ($i = ((int) date('Y')) - 1913; $i < ((int) date('Y')) - 1908; $i++)
                            <option value="{{ $i }}"
                                {{ isset($_GET['selectYear']) && $_GET['selectYear'] == $i ? 'selected' : '' }}>
                                {{ $i . '年' }}</option>
                        @endfor
                    </select>
                    <select name="selectMonth" onchange="setLastDate()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>月查詢</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}"
                                {{ isset($_GET['selectMonth']) && $_GET['selectMonth'] == $i ? 'selected' : '' }}>
                                {{ $i . '月' }}</option>
                        @endfor
                    </select>
                    <select name="selectDay"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>日查詢</option>
                    </select>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm">搜尋</button>
                </div>
            </form>

            {{-- 表格清單 --}}
            <table class="w-full mt-5 text-md text-center text-gray-600 border border-gray-400">
                <thead class="bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3">
                            圖片
                        </th>
                        <th scope="col">
                            會員姓名
                        </th>
                        <th scope="col">
                            會員身分證
                        </th>
                        <th scope="col">
                            管理員
                        </th>
                        <th scope="col">
                            標籤
                        </th>
                        <th scope="col">
                            交易編號
                        </th>
                        <th scope="col">
                            列印次數
                        </th>
                        <th scope="col">
                            上傳日期
                        </th>
                        @if (session('Level') == '2')
                            <th scope="col">
                                編輯
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (isset($trade))
                        @foreach ($trade as $trades)
                            <tr onclick="labelConten({{ $trades }});"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td class="px-2 py-4">
                                    @if (strlen($trades->t_mImg) > 10)
                                        <img src="{{ $trades->t_mImg }}" style="width:50px;height:50px;"
                                            onclick="showImage(this.src)" class="cursor-pointer"
                                            data-modal-target="popup-modal" data-modal-toggle="popup-modal" />
                                    @endif
                                </td>
                                <td>
                                    {{ $trades->t_mName }}
                                </td>
                                <td>
                                    {{ $trades->t_mCardId }}
                                </td>
                                <td>
                                    {{ $trades->t_aId }} {{ $trades->t_aName }}
                                </td>
                                <td>
                                    <div class="flex justify-center items-center">

                                        @if ($trades->l_Current == 'day')
                                            <div
                                                class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2">
                                            </div>
                                        @elseif($trades->l_Current == 'shift')
                                            <div
                                                class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-green-500 border-2 border-white rounded-full -top-2 -end-2">
                                            </div>
                                        @elseif($trades->l_Current == 'all')
                                            <div
                                                class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-500 border-2 border-white rounded-full -top-2 -end-2">
                                            </div>
                                        @endif
                                        <button type="button" data-modal-target="popup-label-modal"
                                            data-modal-toggle="popup-label-modal"
                                            class="text-blue-500 border-b-2 border-blue-400">
                                            {{ $trades->t_lTitle }}
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    {{ $trades->t_No }}
                                </td>
                                <td>
                                    {{ $trades->t_Print }}
                                </td>
                                <td>
                                    {{ $trades->created_at . '' }}
                                </td>
                                <td>
                                    @if (session('Level') == '2')
                                        @if ($trades->l_Current != 'all')
                                            <form id="formUpdate" data-action="{{ route('trade_update') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="tId" value="{{ $trades->t_Id }}">
                                                <button type="submit"
                                                    class="px-2 py-1.5 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
                                                    重置
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- Toast --}}
    <div id="toast-success"
        class="hidden fixed right-10 top-20 z-40 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
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
        class="hidden fixed left-0 top-0 z-30 flex items-center justify-center w-full h-full bg-gray-400/50 mx-auto">
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
    {{-- Modal Image --}}
    <div id="popup-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow w-96 h-96 dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <img class="w-full h-full mx-auto" id="modalImg" src="">
            </div>
        </div>
    </div>
    {{-- Modal Content Detail --}}
    <div id="popup-label-modal" tabindex="-1"
        class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-label-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <h5 id="label-title" class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    </h5>
                    <h6 id="label-TitleOne" class="text-lg text-gray-700 dark:text-gray-400">
                    </h6>
                    <div class="grid grid-cols-2">
                        <p id="label-TitleTwo" class="text-lg text-gray-700 dark:text-gray-400"></p>
                        <p id="label-TitleThree" class="text-lg text-gray-700 dark:text-gray-400"></p>
                    </div>
                    <div class="grid grid-cols-2">
                        <p id="label-MId" class="text-lg text-gray-700 dark:text-gray-400"></p>
                        <p id="label-MName" class="text-lg text-gray-700 dark:text-gray-400"></p>
                    </div>
                    <div class="grid grid-cols-1">
                        <p id="label-No" class="text-lg text-gray-700 dark:text-gray-400"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            var form = $('#formUpdate');

            $(document).on('submit', '#formUpdate', function(event) {

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
                            $('#toast-success-msg').text('會員資料不完整，會員管理編輯');
                            $('#toast-success').toggleClass(
                                'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'
                            );
                            $('#toast-success').find('path').attr('d',
                                'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                            );
                        },
                        complete: function() {
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    });
                }
            });

            // 生日(民國年)
            setTimeout(function() {
                dateChange();
            }, 1000);

            function dateChange() {
                document.querySelector('input[type="date"]').addEventListener('change', function(
                    event) {
                    var selectDate = document.querySelector('input[type="date"]').value;
                    var year = (parseInt(selectDate.substring(0, 4), 10) - 1911).toString();
                    var newVal = year + '' + selectDate.substring(4, 10);
                    document.querySelector('input[name="birthday"]').value = newVal;
                });
            }
        });

        function labelConten(data) {
            document.getElementById('label-title').innerText = data.l_Title === undefined ? '' : data.l_Title;
            document.getElementById('label-TitleOne').innerText = data.l_TitleOne === undefined ? '' : data.l_TitleOne;
            document.getElementById('label-TitleTwo').innerText = data.l_TitleTwo === undefined ? '' : data.l_TitleTwo;
            document.getElementById('label-TitleThree').innerText = data.l_TitleThree === undefined ? '' : data
                .l_TitleThree;
            document.getElementById('label-MId').innerText = data.t_mId === undefined ? '' : data.t_mId;
            document.getElementById('label-MName').innerText = data.t_mName === undefined ? '' : data.t_mName;
            document.getElementById('label-No').innerText = data.t_No === undefined ? '' : data.t_No;
        }
        // Modal圖片
        function showImage(url) {
            document.getElementById('modalImg').src = url;
        }

        function setLastDate() {
            var year = document.getElementsByName('selectYear')[0].value;
            var month = document.getElementsByName('selectMonth')[0].value;

            if (year != '' && month != '') {
                var last = new Date(year + '-' + month + '-01');
                last.setMonth(last.getMonth() + 1);
                last.setDate(0);

                for (var i = 1; i <= last.getDate(); i++) {

                    var opt1 = document.createElement("option");
                    opt1.value = i;
                    opt1.text = i.toString() + '號';
                    opt1.selected = false;
                    document.getElementsByName('selectDay')[0].add(opt1, null);
                }
            }
        }

        setLastDate();

        var url_string = window.location.href;
        var url = new URL(url_string);
        var selectDay = url.searchParams.get('selectDay');

        if (selectDay != null && selectDay != '') {
            document.getElementsByName('selectDay')[0].value = selectDay;
        }
    </script>
</x-layout>
