<x-layout>
    @if (isset($trade))
        <div id="toast-success"
            class="absolute z-50 right-10 top-10 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200 ">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>

            </div>
            <div class="ms-3 text-sm font-semibold">搜尋筆數: {{ sizeof($trade) }}</div>
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
    @endif
    <div class="relative overflow-x-auto shadow-xl rounded-lg">
        <div class="px-2 py-2">
            {{-- 搜尋 --}}
            <form class="max-w-lg mx-auto px-5 bg-gray-300 rounded-full py-2">
                <div class="grid gap-4 grid-cols-4">
                    <select name="selectShift" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>班查詢</option>
                        <option value="早班" {{ isset($selectShift) && $selectShift == '早班' ? 'selected' : '' }}>早班
                        </option>
                        <option value="中班" {{ isset($selectShift) && $selectShift == '中班' ? 'selected' : '' }}>中班
                        </option>
                        <option value="晚班" {{ isset($selectShift) && $selectShift == '晚班' ? 'selected' : '' }}>晚班
                        </option>
                    </select>
                    <select name="selectYear" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>年查詢</option>
                        @for ($i = ((int) date('Y')) - 1913; $i < ((int) date('Y')) - 1908; $i++)
                            <option value="{{ $i }}"
                                {{ isset($selectYear) && $selectYear == $i ? 'selected' : '' }}>{{ $i . '年' }}
                        @endfor
                    </select>
                    <select name="selectMonth" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>月查詢</option>
                        @if (isset($selectYear))
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}"
                                    {{ isset($selectMonth) && $selectMonth == $i ? 'selected' : '' }}>
                                    {{ $i . '月' }}
                            @endfor
                        @endif
                    </select>
                    <select name="selectDay" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>日查詢</option>
                        @if (isset($selectYear) && isset($selectMonth))
                            @for ($i = 1; $i <= cal_days_in_month(0, $selectMonth, $selectYear); $i++)
                                <option value="{{ $i }}"
                                    {{ isset($selectDay) && $selectDay == $i ? 'selected' : '' }}>
                                    {{ $i . '號' }}
                            @endfor
                        @endif
                    </select>
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
                            上傳日期
                        </th>
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
                                    <button type="button" data-modal-target="popup-label-modal"
                                        data-modal-toggle="popup-label-modal"
                                        class="text-blue-500 border-b-2 border-blue-400">
                                        {{ $trades->t_lTitle }}
                                    </button>
                                </td>
                                <td>
                                    {{ $trades->t_No }}
                                </td>
                                <td>
                                    {{ $trades->created_at.'' }}
                                </td>
                            </tr>
                        @endforeach
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
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
        function labelConten(data) {
            document.getElementById('label-title').innerText = data.l_Title === undefined ? '' : data.l_Title;
            document.getElementById('label-TitleOne').innerText = data.l_TitleOne === undefined ? '' : data.l_TitleOne;
            document.getElementById('label-TitleTwo').innerText = data.l_TitleTwo === undefined ? '' : data.l_TitleTwo;
            document.getElementById('label-MId').innerText = data.t_mId === undefined ? '' : data.t_mId;
            document.getElementById('label-MName').innerText = data.t_mName === undefined ? '' : data.t_mName;
            document.getElementById('label-No').innerText = data.t_No === undefined ? '' : data.t_No;
        }
        // Modal圖片
        function showImage(url) {
            document.getElementById('modalImg').src = url;
        }
    </script>
</x-layout>
