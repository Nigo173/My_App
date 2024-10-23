<x-layout>
    <div
        class="relative {{ !isset($member) ? 'max-w-lg bg-slate-200 mx-auto' : '' }} overflow-x-auto shadow-xl rounded-lg">
        <div class="pX-2 py-5">
            @if (isset($member))
                {{-- 表單 --}}
                <form class="max-w-md mx-auto">
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
                {{-- 表格清單 --}}
                <table class="w-full mt-5 text-md text-center text-gray-600 border border-gray-400">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                圖片
                            </th>
                            <th scope="col" class="px-6 py-3">
                                編號
                            </th>
                            <th scope="col" class="px-6 py-3">
                                身分證
                            </th>
                            <th scope="col" class="px-6 py-3">
                                姓名
                            </th>
                            <th scope="col" class="px-6 py-3">
                                生日
                            </th>
                            <th scope="col" class="px-6 py-3">
                                地址
                            </th>
                            <th scope="col" class="px-6 py-3">
                                電話
                            </th>
                            <th scope="col" class="px-6 py-3">
                                備註
                            </th>
                            <th scope="col" class="px-6 py-3">
                                資料日期
                            </th>
                            @if ($action == 'member_update' || $action == 'member_delete')
                                <th scope="col" class="px-6 py-3">
                                    {{ $action == 'member_update' ? '編輯' : '刪除' }}
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $members)
                            <tr id="{{ $members->m_Id }}"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    @if (strlen($members->m_Img) > 10)
                                        <img src="{{ $members->m_Img }}" style="width:50px;height:50px;"
                                            onclick="showImage(this.src)" class="cursor-pointer"
                                            data-modal-target="popup-modal" data-modal-toggle="popup-modal" />
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $members->m_Id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $members->m_CardId }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $members->m_Name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $members->m_Birthday }}
                                </td>
                                <td class="px-6 py-4 text-ellipsis overflow-hidden">
                                    {{ $members->m_Address }}
                                </td>
                                <td class="px-6 py-4 text-ellipsis overflow-hidden">
                                    {{ $members->m_Phone }}
                                </td>
                                <td class="px-6 py-4 text-ellipsis overflow-hidden">
                                    {{ $members->m_Remark }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $members->created_at }}<br>
                                    {{ $members->updated_at }}
                                </td>
                                @if ($action != 'member_list')
                                    <td class="px-6 py-4 text-ellipsis overflow-hidden">
                                        @if (intval(session('Level')) > 0)
                                            @if ($action == 'member_update')
                                                <form data-action="{{ route($action) }}" method="POST">
                                                    <input type="hidden" name="Id" value="{{ $members->m_Id }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-2 py-1.5 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
                                                        編輯
                                                    </button>
                                            @endif
                                            @if ($action == 'member_delete')
                                                <form id="formDelete" data-action="{{ route($action) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="delete" value="delete">
                                                    <input type="hidden" name="Id" value="{{ $members->m_Id }}">

                                                    <button type="submit"
                                                        class="px-2 py-1.5 text-white bg-red-700 hover:bg-red-800 text-md text-center">
                                                        刪除</button>
                                            @endif
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{-- 表單 --}}
                <form id="formCreate" class="max-w-md mx-auto" data-action="{{ route($action) }}" method="POST"
                    charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="update" value="update">
                    <input type="hidden" name="Id"
                        value="{{ $action == 'member_update' && isset($data) ? $data->m_Id : '' }}">
                    {{-- 照片 --}}
                    <div class="relative h-100 h-1/4 z-0 w-full mb-8 group">
                        <div class="absolute bottom-0 top-5 w-full h-full bg-slate-300">
                            <div class="relative">
                                <label for="myfileid" class="cursor-pointer" title="上傳圖片">
                                    <img class="w-full h-full" id="imgView"
                                        src="{{ $action == 'member_update' && isset($data) ? $data->m_Img : '' }}">
                                    <div class="absolute left-0 top-0 w-10 h-10">
                                        <input type="file" name="img" id="myfileid"
                                            accept="image/png, image/gif, image/jpeg"
                                            class="text-sm w-24 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            {{ $action == 'member_update' && isset($data) ? $data->m_Img : 'required' }} />
                                    </div>
                                </label>
                                <input type="hidden" name="oldImg"
                                    value="{{ $action == 'member_update' && isset($data) ? $data->m_Img : '' }}">
                            </div>
                        </div>

                        <label for="img"
                            class="text-red-700 peer-focus:font-medium absolute text-sm z-10 right-0 -top-1">照片
                            *圖片小於2MB*</label>
                    </div>
                    {{-- 編號 --}}
                    <div class="grid md:grid-cols-1">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="cardId" name="Id"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_Id : $Id }}"
                                class="text-center block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required readonly />
                            <label for="cardId"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">編號</label>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        {{-- 姓名 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="name"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_Name : '' }}"
                                maxlength="10" pattern="[A-Za-z\u4e00-\u9fa5]{2,10}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">姓名</label>
                        </div>
                        {{-- 身分證 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="cardId"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_CardId : '' }}"
                                maxlength="10" pattern="^[A-Z]{1}[0-9]{9}$"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="cardId"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">身分證</label>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        {{-- 生日 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="date" class="absolute bg-transparent top-0 right-0 border-0"
                                onchange="dateChange()" />
                            <input type="text" name="birthday"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_Birthday : '' }}"
                                pattern="^[0-1]{1}[0-9]{2}-(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))-(([0]{1}[1-9]{1})|([1]{1}[0-9]{1})|([3]{1}[0-1]{1}))$"
                                maxlength="9"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="birthday"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">生日</label>
                        </div>
                        {{-- 電話 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="phone"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_Phone : '' }}"
                                maxlength="20"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="phone"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">電話</label>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        {{-- 信箱 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="email"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_Email : '' }}"
                                maxlength="30"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " />
                            <label for="email"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">信箱</label>
                        </div>
                        {{-- 地址 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="address"
                                value="{{ $action == 'member_update' && isset($data) ? $data->m_Address : '' }}"
                                maxlength="50"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " />
                            <label for="address"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">地址</label>
                        </div>
                    </div>
                    {{-- 備註 --}}
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="remark"
                            value="{{ $action == 'member_update' && isset($data) ? $data->m_Remark : '' }}"
                            maxlength="50"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " />
                        <label for="remark"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            備註</label>
                    </div>
                    <div class="text-center">
                        @if (isset($data))
                            <button type="submit"
                                class="text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-10 py-2 text-center dark:bg-yellow-300 dark:hover:bg-yellow-400 dark:focus:ring-yellow-600">編輯</button>
                        @else
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-10 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">新增</button>
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
                                $('#toast-success').toggleClass(
                                    'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'
                                );
                                $('#toast-success').find('path').attr('d',
                                    'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                                );
                            }
                            // 刪除tr
                            if (url.indexOf('delete') > -1) {
                                if (response.msg.indexOf('成功') > -1) {
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                }
                            } else if (url.indexOf('create')) {
                                setTimeout(function() {
                                    window.location.href = 'list';
                                }, 2000);
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
                            $('#Modal').addClass('hidden');

                            setTimeout(function() {
                                form.trigger('reset');
                                $('#toast-success').addClass('hidden');
                            }, 3000);
                        }
                    });
                }
            });

            // 生日 * 民國年
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

        document.getElementById('myfileid').addEventListener('change', function(event) {
            var preview = document.getElementById('imgView');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        });

        // 日期選擇
        // document.querySelector('input[name="birthday"]').addEventListener("click", function(e) {
        //     setTimeout(function() {
        //         document.querySelector('input[type="date"]').showPicker();
        //     }, 250);
        // });

        // Modal圖片
        function showImage(url) {
            document.getElementById('modalImg').src = url;
        }
    </script>
</x-layout>
