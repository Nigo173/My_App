<x-layout>
    @if (isset($msg) && $msg != '')
        <div id="toast-success"
            class="absolute right-10 top-10 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ strpos($msg, '成功') ? 'text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200' : 'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200' }}  ">
                @if (strpos($msg, '成功'))
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                @else
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                    </svg>
                @endif
            </div>
            <div class="ms-3 text-sm font-normal">{{ $msg }}</div>
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
        <div class="pX-2 py-5">
            {{-- 搜尋 --}}
            <form class="max-w-md mx-auto">
                {{-- <div class="relative mb-3">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" name="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="關鍵字 身分證 或 姓名" />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">搜尋</button>
                </div> --}}

                <div class="grid gap-4 grid-cols-2 p-4 bg-gray-300">
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
                    <select name="selectMonth" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>月查詢</option>
                        <option value="1" {{ isset($selectMonth) && $selectMonth == '1' ? 'selected' : '' }}>1月
                        </option>
                        <option value="2" {{ isset($selectMonth) && $selectMonth == '2' ? 'selected' : '' }}>2月
                        </option>
                        <option value="3" {{ isset($selectMonth) && $selectMonth == '3' ? 'selected' : '' }}>3月
                        </option>
                        <option value="4" {{ isset($selectMonth) && $selectMonth == '4' ? 'selected' : '' }}>4月
                        </option>
                        <option value="5" {{ isset($selectMonth) && $selectMonth == '5' ? 'selected' : '' }}>5月
                        </option>
                        <option value="6" {{ isset($selectMonth) && $selectMonth == '6' ? 'selected' : '' }}>6月
                        </option>
                        <option value="7" {{ isset($selectMonth) && $selectMonth == '7' ? 'selected' : '' }}>7月
                        </option>
                        <option value="8" {{ isset($selectMonth) && $selectMonth == '8' ? 'selected' : '' }}>8月
                        </option>
                        <option value="9" {{ isset($selectMonth) && $selectMonth == '9' ? 'selected' : '' }}>9月
                        </option>
                        <option value="10" {{ isset($selectMonth) && $selectMonth == '10' ? 'selected' : '' }}>10月
                        </option>
                        <option value="11" {{ isset($selectMonth) && $selectMonth == '11' ? 'selected' : '' }}>11月
                        </option>
                        <option value="12" {{ isset($selectMonth) && $selectMonth == '12' ? 'selected' : '' }}>12月
                        </option>
                    </select>
                </div>
            </form>
            {{-- 表格清單 --}}
            <table class="w-full mt-5 text-md text-center text-gray-600 border border-gray-400">
                <thead class="bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            會員姓名
                        </th>
                        <th scope="col" class="px-6 py-3">
                            會員身分證
                        </th>
                        <th scope="col" class="px-6 py-3">
                            管理員
                        </th>
                        <th scope="col" class="px-6 py-3">
                            標籤
                        </th>
                        <th scope="col" class="px-6 py-3">
                            資料日期
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($trade))

                        @foreach ($trade as $trades)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $trades->t_mName }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $trades->t_mCardId }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $trades->t_aId }}:{{ $trades->t_aName }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $trades->t_lTitle }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $trades->created_at }}<br>
                                    {{ $trades->updated_at }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- Modal Loading --}}
    <div id="Modal"
        class="absolute left-0 top-0 z-50 flex items-center justify-center w-full h-full bg-gray-400/50 mx-auto">
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

    <script>
        let second = {{ isset($trade) || isset($data) || !isset($Id) ? 0 : 6000 }};

        setTimeout(() => {
            document.getElementById('Modal').classList.add('hidden');
        }, second);

        let seconds = {{ isset($msg) && $msg != '' ? 3000 : 0 }};

        setTimeout(() => {
            document.getElementById('toast-success-button').click();
        }, seconds);
    </script>
</x-layout>
