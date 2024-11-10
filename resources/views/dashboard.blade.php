<x-layout>
    <div class="relative overflow-x-auto shadow-xl rounded-lg">
        <div class="px-2 py-2">
            {{-- 搜尋 --}}
            <form class="max-w-4xl mx-auto px-2 py-2 flex justify-center items-center gap-1" method="GET">
                @if (isset($trade))
                    <div class="px-3 py-2 text-sm font-medium text-white bg-gray-700 rounded-lg shadow-sm">
                        搜尋筆數: {{ sizeof($trade) }}
                    </div>
                @endif

                <input type="search" name="cardId"
                    class="w-32 ms-2 me-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ isset($_GET['cardId']) ? $_GET['cardId'] : '' }}" placeholder="身分證" />

                <div class="w-100 grid gap-4 grid-cols-5">

                    <select name="selectShift"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                        <option value="" selected>年查詢</option>
                        @for ($i = ((int) date('Y')) - 1913; $i < ((int) date('Y')) - 1908; $i++)
                            <option value="{{ $i }}"
                                {{ isset($_GET['selectYear']) && $_GET['selectYear'] == $i ? 'selected' : '' }}>
                                {{ $i . '年' }}</option>
                        @endfor
                    </select>
                    <select name="selectMonth" onchange="setLastDate()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                        <option value="" selected>月查詢</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}"
                                {{ isset($_GET['selectMonth']) && $_GET['selectMonth'] == $i ? 'selected' : '' }}>
                                {{ $i . '月' }}</option>
                        @endfor
                    </select>
                    <select name="selectDay"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                        <option value="" selected>日查詢</option>
                    </select>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm"
                        data-modal-target="Modal"
                        data-modal-toggle="Modal">搜尋</button>
                </div>
            </form>
            @php
                if (isset($trade)) {
                    $CurrentArray = [];
                    $titleArray = [];

                    foreach ($trade as $trades) {
                        if (!array_key_exists($trades->l_Current, $CurrentArray)) {
                            $CurrentArray[$trades->l_Current] = 1;
                            $titleArray[$trades->l_Current] = $trades->t_lTitle;
                        } elseif (array_key_exists($trades->l_Current, $CurrentArray)) {
                            $CurrentArray[$trades->l_Current] += 1;
                        }
                    }

                    echo '<div class="max-w-lg mx-auto flex justify-around items-center">';

                    $keys = array_keys($titleArray);
                    foreach ($CurrentArray as $key => $value) {
                        if ($key == 'day') {
                            echo '<div class="text-center border-b-2 border-gray-600"><div
                        class="text-white py-1 px-3 bg-red-500">' .
                                $value .
                                '</div>' .
                                $titleArray[$key] .
                                '</div>';
                        } elseif ($key == 'shift') {
                            echo '<div class="text-center border-b-2 border-gray-600"><div
                        class="text-white py-1 px-3 bg-green-500">' .
                                $value .
                                '</div>' .
                                $titleArray[$key] .
                                '</div>';
                        } elseif ($key == 'all') {
                            echo '<div class="text-center border-b-2 border-gray-600"><div
                        class="text-white py-1 px-3 bg-blue-500">' .
                                $value .
                                '</div>' .
                                $titleArray[$key] .
                                '</div>';
                        }
                    }
                    echo '</div>';
                }
            @endphp

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
                            <tr class="bg-white border-b hover:bg-gray-200">
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
                                            onclick="labelConten({{ $trades }});"
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
                                    {{ $trades->created_at }}
                                </td>
                                <td>
                                    @if (session('Level') == '2')
                                        @if ($trades->l_Current != 'all' && $trades->id == $trades->resetId)

                                            {{-- <form id="formUpdate" data-action="{{ route('trade_update') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="tId" value="{{ $trades->t_Id }}"> --}}
                                            <button type="button" onclick="confirm_modal({{ $trades }})"
                                                data-modal-target="popup-modal-confirm"
                                                data-modal-toggle="popup-modal-confirm"
                                                class="px-2 py-1.5 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
                                                重置
                                            </button>
                                            {{-- </form> --}}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        {{ $trade->onEachSide(5)->links() }}
                    @endif
                </tbody>
            </table>
        </div>
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
    {{-- Modal Confirm Detail --}}
    <div id="popup-modal-confirm" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal-confirm">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-red-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-bold text-gray-500" id="confirm-label">
                    </h3>
                    <h3 class="mb-2 text-lg font-normal text-gray-500" id="confirm-member"></h3>
                    <p class="mb-5 text-md font-normal text-gray-500" id="confirm-created"></p>

                    <form id="formUpdate" data-action="{{ route('trade_update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tId" id="confirm-tId" value="">
                        <button data-modal-hide="popup-modal-confirm" type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-7 py-2 text-center">
                            確認
                        </button>

                        <button data-modal-hide="popup-modal-confirm" type="button"
                            class="py-2 px-7 ms-10 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                            取消</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Back to top button -->
    <button type="button" data-twe-ripple-init data-twe-ripple-color="light"
        class="!fixed bottom-10 right-44 hidden opacity-75 rounded-full bg-slate-500 p-3 font-medium text-white shadow-xl transition duration-150 ease-in-out hover:bg-slate-700"
        id="btn-back-to-top" onclick="backToTop()">
        <span class="[&>svg]:w-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
            </svg>
        </span>
    </button>

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

        // 搜尋日期
        function setLastDate() {
            var year = document.getElementsByName('selectYear')[0].value;
            var month = document.getElementsByName('selectMonth')[0].value;
            var day = document.getElementsByName('selectDay')[0];

            for (var i = day.length; i > 0; i--) {
                day.remove(i);
            }

            if (year != '' && month != '') {
                var last = new Date(year + '-' + month + '-01');
                last.setMonth(last.getMonth() + 1);
                last.setDate(0);

                setTimeout(function() {
                    for (var i = 1; i <= last.getDate(); i++) {

                        var opt1 = document.createElement('option');
                        opt1.value = i.toString();
                        opt1.text = i.toString() + '號';
                        opt1.selected = false;
                        day.add(opt1, null);
                    }
                }, 250);
            } else if (month == '') {
                day.value = '';
            }
        }

        setLastDate();

        var url_string = window.location.href;
        var url = new URL(url_string);
        var selectDay = url.searchParams.get('selectDay');

        if (selectDay != null && selectDay != '') {
            document.getElementsByName('selectDay')[0].value = selectDay;
        }

        // Go Top
        window.addEventListener('scroll', function() {

            var mybutton = document.getElementById('btn-back-to-top');

            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.classList.remove("hidden");
            } else {
                mybutton.classList.add("hidden");
            }
        });

        function backToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
        // 重置確認視窗
        function confirm_modal(data) {
            document.getElementById('confirm-tId').value = data.t_Id;
            document.getElementById('confirm-label').innerText = '標籤(' + data.t_lTitle + ')重置';
            document.getElementById('confirm-member').innerText = data.t_mName + ' ' + data.t_mCardId;

            var createdDate = new Date(data.created_at);
            createdDate = createdDate.getFullYear() + '-' + (createdDate.getMonth() + 1) + '-' + createdDate.getDate() +
                ' ' +
                ('0' + createdDate.getHours()).slice(-2) + ':' + ('0' + createdDate.getMinutes()).slice(-2) + ':' + ('0' +
                    createdDate.getSeconds()).slice(-2);
            document.getElementById('confirm-created').innerText = '日期:' + createdDate;
        }
    </script>
</x-layout>
