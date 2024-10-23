<x-layout>
    <div
        class="relative {{ !isset($admin) ? 'max-w-lg bg-slate-200 mx-auto' : '' }} overflow-x-auto shadow-xl rounded-lg">
        <div class="pX-2 py-5">
            @if (isset($admin))
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
                                帳號
                            </th>
                            <th scope="col" class="px-6 py-3">
                                姓名
                            </th>
                            <th scope="col" class="px-6 py-3">
                                權限
                            </th>
                            <th scope="col" class="px-6 py-3">
                                電腦
                            </th>
                            <th scope="col" class="px-6 py-3">
                                狀態
                            </th>
                            <th scope="col" class="px-6 py-3">
                                管理員身分
                            </th>
                            <th scope="col" class="px-6 py-3">
                                資料日期
                            </th>
                            @if ($action == 'admins_update' || $action == 'admins_delete')
                                <th scope="col" class="px-6 py-3">
                                    {{ $action == 'admins_update' ? '編輯' : '刪除' }}
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $admins)
                            <tr id="{{ $admins->a_Id }}"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $admins->a_Id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $admins->a_Name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $admins->member_Permissions }}
                                    @if (strlen($admins->admins_Permissions) > 10)
                                        <br> {{ $admins->admins_Permissions }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $admins->a_Mac }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($admins->a_State == '1')
                                        正常
                                    @else
                                        停權
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($admins->a_Level == '1')
                                        一般管理員
                                    @elseif($admins->a_Level == '2')
                                        權限管理員
                                    @elseif($admins->a_Level == '3')
                                        最高權限管理員
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $admins->created_at }}<br>
                                    {{ $admins->updated_at }}
                                </td>
                                @if ($action != 'admins_list')
                                    <td class="px-6 py-4 text-ellipsis overflow-hidden">
                                        @if (intval(session('Level')) > 0)
                                            @if ($action == 'admins_update')
                                                <form action="" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="Id" value="{{ $admins->a_Id }}">
                                                    <button type="submit"
                                                        class="px-2 py-1.5 text-gray-600 bg-yellow-300 hover:bg-yellow-400 text-md text-center">
                                                        編輯
                                                    </button>
                                            @endif

                                            @if ($action == 'admins_delete' && $admins->a_Id != session('Account'))
                                                <form id="formDelete" data-action="{{ route($action) }}">
                                                    @csrf
                                                    <input type="hidden" name="delete" value="delete">
                                                    <input type="hidden" name="Id" value="{{ $admins->a_Id }}">

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
                <form id="formCreate" class="max-w-md mx-auto" data-action="{{ route($action) }}" method="POST">
                    @csrf
                    <input type="hidden" name="update" value="update">
                    <input type="hidden" name="Id"
                        value="{{ $action == 'admins_update' && isset($data) ? $data->a_Id : '' }}">

                    <div class="grid md:grid-cols-2 md:gap-6">
                        {{-- 身分證 --}}
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
                                value="{{ $action == 'admins_update' && isset($data) ? $data->a_Name : old('name') }}"
                                maxlength="10" pattern="[A-Za-z\u4e00-\u9fa5]{2,10}"
                                onkeyup="this.value = this.value.replace(/[^A-Za-z\u4e00-\u9fa5]/g,'')"
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
                                placeholder=" " {{ $action == 'admins_create' ? 'required' : old('password') }} />
                            <label for="password"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">密碼</label>
                        </div>
                        {{-- 電腦 --}}
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="mac" value="{{ strtok(exec('getmac'), ' ') }}"
                                maxlength="20"
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
                                <input id="state" type="radio" value="1" name="level"
                                    {{ isset($data) && $data->a_Level == '1' ? 'checked' : '' }}
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
                                    {{ explode('_', $data->member_Permissions)[0] == 'member' && strpos(explode('_', $data->member_Permissions)[1], 'd') > -1 ? 'checked' : '' }}
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
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'd') > -1 ? 'checked' : '' }} @endif
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="inline-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">新增</label>
                                    </div>
                                    <div class="flex items-center me-4">
                                        <input id="inline-checkbox" type="checkbox" name="admins_Permissions[]"
                                            value="r"
                                            onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'd') > -1 ? 'checked' : '' }} @endif
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="inline-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">查詢</label>
                                    </div>
                                    <div class="flex items-center me-4">
                                        <input id="inline-checkbox" type="checkbox" name="admins_Permissions[]"
                                            value="u"
                                            onclick="{{ isset($data) && $data->a_Level == '2' ? 'return false' : '' }}"
                                            @if (isset($data)) {{ explode('_', $data->admins_Permissions)[0] == 'admins' && strpos(explode('_', $data->admins_Permissions)[1], 'd') > -1 ? 'checked' : '' }} @endif
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
                            // if (response.msg.indexOf("成功") > -1) {
                            //     form.trigger("reset");
                            // }
                            // 刪除tr
                            if (url.indexOf("delete") > -1) {
                                if (response.msg.indexOf('成功') > -1) {
                                    var jsonstringify = JSON.stringify(form.serializeArray());
                                    var jsonEle = JSON.parse(jsonstringify);
                                    $('#' + jsonEle[2]['value']).remove();
                                }
                            } else if (url.indexOf("create")) {
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                            $('#toast-success').removeClass('hidden');
                            $('#toast-success-msg').text(response.msg);
                        },
                        error: function(response) {
                            $('#toast-success').toggleClass(
                                'text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'
                            );
                            $('#toast-success').find('path').attr('d',
                                'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z'
                            );
                        },
                        complete: function() {
                            $('#Modal').addClass('hidden');

                            setTimeout(() => {
                                form.trigger('reset');
                                $('#toast-success').addClass('hidden');
                            }, 3000);
                        }
                    });
                }
            });
        });
    </script>
</x-layout>
