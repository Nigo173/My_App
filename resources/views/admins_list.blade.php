<x-layout>
    <div
        class="relative {{ !isset($admin) ? 'max-w-lg bg-slate-200 mx-auto' : '' }} overflow-x-auto shadow-xl rounded-lg">
        <div class="px-2 py-2">
            @if (isset($admin))
                {{-- 表單 --}}
                <form class="max-w-2xl mx-auto flex justify-center items-center gap-1">
                    @if (isset($admin))
                        <div class="px-3 py-3 text-sm font-medium text-white bg-gray-700 rounded-lg shadow-sm">
                            搜尋筆數: {{ sizeof($admin) }}
                        </div>
                    @endif
                    <div class="w-96 relative">
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
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                            data-modal-target="Modal"
                            data-modal-toggle="Modal">搜尋</button>
                    </div>
                </form>
                {{-- 表格清單 --}}
                <table class="w-full mt-5 text-md text-center text-gray-600 border border-gray-400">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3">
                                帳號
                            </th>
                            <th scope="col">
                                姓名
                            </th>
                            <th scope="col">
                                權限
                            </th>
                            {{-- <th scope="col">
                                電腦
                            </th> --}}
                            <th scope="col">
                                狀態
                            </th>
                            <th scope="col">
                                管理員身分
                            </th>
                            <th scope="col">
                                資料日期
                            </th>
                            @if ($action == 'admins_update' || $action == 'admins_delete')
                                <th scope="col">
                                    {{ $action == 'admins_update' ? '編輯' : '刪除' }}
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $admins)
                            <tr id="{{ $admins->a_Id }}"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td>
                                    {{ $admins->a_Id }}
                                </td>
                                <td>
                                    {{ $admins->a_Name }}
                                </td>
                                <td>
                                    {{ $admins->member_Permissions }}
                                    @if (strlen($admins->admins_Permissions) > 10)
                                        <br> {{ $admins->admins_Permissions }}
                                    @endif
                                </td>
                                {{-- <td>
                                    {{ $admins->a_Mac }}
                                </td> --}}
                                <td>
                                    @if ($admins->a_State == '1')
                                        正常
                                    @else
                                        停權
                                    @endif
                                </td>
                                <td>
                                    @if ($admins->a_Level == '1')
                                        一般管理員
                                    @elseif($admins->a_Level == '2')
                                        權限管理員
                                    @elseif($admins->a_Level == '3')
                                        最高權限管理員
                                    @endif
                                </td>
                                <td>
                                    {{ $admins->created_at }}<br>
                                    {{ $admins->updated_at }}
                                </td>
                                @if ($action != 'admins_list')
                                    <td>
                                        @if (intval(session('Level')) > 0)
                                            @if ($action == 'admins_update')
                                                <form action="" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="account" value="{{ $admins->a_Id }}">
                                                    <button type="submit"
                                                        class="px-2 py-1.5 mt-3 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
                                                        編輯
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($action == 'admins_delete' && $admins->a_Id != session('Account'))
                                                <form id="formDelete" data-action="{{ route($action) }}">
                                                    @csrf
                                                    <input type="hidden" name="delete" value="delete">
                                                    <input type="hidden" name="account" value="{{ $admins->a_Id }}">

                                                    <button type="submit"
                                                        class="px-2 py-1.5 mt-3 text-white bg-red-700 hover:bg-red-800 text-md text-center">
                                                        刪除</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{-- 表單 --}}
                <form id="formCreate" class="max-w-md mx-auto" data-action="{{ route($action) }}" method="POST">
                    @csrf

                    @if (isset($data) && $action == 'admins_update')
                        <input type="hidden" name="update" value="update">
                    @endif

                    <div class="grid md:grid-cols-2 md:gap-6">
                        {{-- 帳號 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="account"
                                value="{{ $action == 'admins_update' && isset($data) ? $data->a_Id : $Id }}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required readonly />
                            <label for="account"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">帳號</label>
                        </div>
                        {{-- 姓名 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="name"
                                value="{{ $action == 'admins_update' && isset($data) ? $data->a_Name : '' }}"
                                maxlength="10" pattern="[A-Za-z\u4e00-\u9fa5]{2,10}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">姓名</label>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        {{-- 密碼 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="password" value="" maxlength="20"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " {{ $action == 'admins_create' ? 'required' : '' }} />
                            <label for="password"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">密碼</label>
                        </div>
                        {{-- 電腦 --}}
                        <div class="relative z-0 w-full mb-5 group hidden">
                            <input type="text" name="mac" value="" maxlength="20"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required readonly />
                            <label for="mac"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">電腦</label>
                        </div>
                    </div>
                    {{-- 一般管理員權限 --}}
                    <div class="relative z-0 w-full mb-5 group">
                        <div class="flex flex-wrap py-4 px-0 w-full text-sm">
                            <div class="flex items-center me-4">
                                <input checked id="state" type="radio" value="1" name="state"
                                    @if ($action == 'admins_update' && isset($data)) onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                            {{ $data->a_State == '1' ? 'checked' : '' }}
                            @else
                            onclick="{{ intval(session('Level')) < 2 ? 'return false' : '' }}" checked @endif
                                    class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="state"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">正常使用</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input id="state" type="radio" value="0" name="state"
                                    @if ($action == 'admins_update' && isset($data)) onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                            {{ $data->a_State == '0' ? 'checked' : '' }}
                            @else
                            onclick="{{ intval(session('Level')) < 2 ? 'return false' : '' }}" @endif
                                    class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="state"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">停權使用</label>
                            </div>
                        </div>
                        <label for="state"
                            class="peer-focus:font-medium absolute text-lg text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            狀態</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <div class="flex flex-wrap py-4 px-0 w-full text-sm">
                            <div class="flex items-center me-4">
                                <input id="state" type="radio" value="1" name="level" checked
                                    {{ isset($data) && $data->a_Level == '1' && session('Level') == '2' ? 'checked' : '' }}
                                    onclick="{{ isset($data) && ($data->a_Id == session('Account') || $data->a_Level == '1') ? 'return false' : '' }}"
                                    class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="state"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">一般管理員</label>
                            </div>
                            @if (isset($action) && $action == 'admins_update')
                                <div class="flex items-center me-4 {{ $data->a_Level == '2' ? '' : 'hidden' }}">
                                    <input id="state" type="radio" value="2" name="level"
                                        {{ isset($data) && $data->a_Level == '2' ? 'checked' : '' }}
                                        onclick="{{ isset($data) && ($data->a_Id == session('Account') || $data->a_Level == '1') ? 'return false' : '' }}"
                                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="level"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">權限管理員</label>
                                </div>
                            @endif
                        </div>
                        <label for="state"
                            class="peer-focus:font-medium absolute text-lg text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            管理員身分</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <div class="flex py-4 px-0 w-full text-sm">
                            <div class="flex items-center me-4">
                                <input id="inline-checkbox" type="checkbox" name="member_Permissions[]"
                                    value="c"
                                    @if (isset($action) && $action == 'admins_update' && isset($data)) onclick="{{ $data->a_Level == '2' ? 'return false' : '' }}"
                                    {{ explode('_', $data->member_Permissions)[0] == 'member' && strpos(explode('_', $data->member_Permissions)[1], 'c') > -1 ? 'checked' : '' }}
                                    onclick="return false" @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checkbox"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">新增</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input id="inline-checkbox" type="checkbox" name="member_Permissions[]"
                                    value="r" checked onclick="return false"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checkbox"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">查詢</label>
                            </div>
                            <div class="flex items-center me-4">
                                <input id="inline-checkbox" type="checkbox" name="member_Permissions[]"
                                    value="u"
                                    @if (isset($action) && $action == 'admins_update' && isset($data)) onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                    {{ explode('_', $data->member_Permissions)[0] == 'member' && strpos(explode('_', $data->member_Permissions)[1], 'u') > -1 ? 'checked' : '' }}
                                    onclick="return false" @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="inline-checkbox"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">編輯</label>
                            </div>
                            @if (isset($action) && $action == 'admins_update')
                                <div class="flex items-center me-4 {{ $data->a_Level == '2' ? '' : 'hidden' }}">
                                    <input id="inline-checkbox" type="checkbox" name="member_Permissions[]"
                                        value="d"
                                        @if (isset($action) && $action == 'admins_update' && isset($data)) onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                        {{ explode('_', $data->member_Permissions)[0] == 'member' && strpos(explode('_', $data->member_Permissions)[1], 'd') > -1 ? 'checked' : '' }}
                                    onclick="return false" @endif
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="inline-checkbox"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">刪除</label>
                                </div>
                            @endif
                        </div>

                        <label for="member_Permissions"
                            class="peer-focus:font-medium absolute text-lg text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            管理員身分</label>
                    </div>

                    @if (isset($action) && $action == 'admins_update')
                        @if ($data->a_Id == session('Account'))
                            <div class="relative z-0 w-full mb-5 group">
                                <div class="flex py-4 px-0 w-full text-sm">
                                    <div class="flex items-center me-4">
                                        <input id="inline-checkbox" type="checkbox" name="admins_Permissions[]"
                                            value="c"
                                            onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'c') > -1 ? 'checked' : '' }} @endif
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="inline-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">新增</label>
                                    </div>
                                    <div class="flex items-center me-4">
                                        <input id="inline-checkbox" type="checkbox" name="admins_Permissions[]"
                                            value="r"
                                            onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'r') > -1 ? 'checked' : '' }} @endif
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="inline-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">查詢</label>
                                    </div>
                                    <div class="flex items-center me-4">
                                        <input id="inline-checkbox" type="checkbox" name="admins_Permissions[]"
                                            value="u"
                                            onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'u') > -1 ? 'checked' : '' }} @endif
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="inline-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">編輯</label>
                                    </div>
                                    <div class="flex items-center me-4">
                                        <input id="inline-checkbox" type="checkbox" name="admins_Permissions[]"
                                            value="d"
                                            onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'd') > -1 ? 'checked' : '' }} @endif
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="inline-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">刪除</label>
                                    </div>
                                </div>

                                <label for="admins_Permissions"
                                    class="peer-focus:font-medium absolute text-lg text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    管理員身分</label>
                            </div>
                        @endif
                    @endif
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
                            if (response.msg.indexOf('成功') > -1) {} else {
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
                                setTimeout(function() {
                                    window.location.href = 'delete';
                                }, 1000);
                            } else if (url.indexOf('create') > -1) {
                                setTimeout(function() {
                                    window.location.href = 'list';
                                }, 1000);
                            } else if (url.indexOf('update') > -1) {
                                setTimeout(function() {
                                    window.history.back();
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
                            }, 2500);
                        }
                    });
                }
            });
        });
    </script>
</x-layout>
