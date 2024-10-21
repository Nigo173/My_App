<x-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="pX-2 py-10 bg-slate-800 grid md:grid-cols-4">
            {{-- 會員清單 --}}
            <div
                class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-white rounded-lg bg-gray-900 text-white">
                <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">{{ $title }}清單</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    管理員權限限制才能使用此功能
                </div>
                <a href="{{ isset($permissions) && strpos($permissions, 'r') > -1 ? route($action.'_list') : '#' }}"
                    class="text-white bg-transparent border border-white font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-white hover:text-gray-600 focus:ring-white-800">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    {{ isset($permissions) && strpos($permissions, 'r') > -1 ? 'View more' : '權限不足' }}
                </a>
            </div>
            {{-- 會員新增 --}}
            <div
            class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-green-500 rounded-lg bg-gray-900 text-green-400">
            <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">{{ $title }}新增</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    管理員權限限制才能使用此功能
                </div>

                <a href="{{ isset($permissions) && strpos($permissions, 'c') > -1 ? route($action.'_create') : '#' }}"
                    class="text-green-400 bg-transparent border border-green-500 font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-green-500 hover:text-white focus:ring-white-800">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    {{ isset($permissions) && strpos($permissions, 'c') > -1 ? 'View more' : '權限不足' }}
                </a>
            </div>
            {{-- 會員編輯 --}}
            <div
            class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-yellow-300 rounded-lg bg-gray-900 text-yellow-300">
            <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">{{ $title }}編輯</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    管理員權限限制才能使用此功能
                </div>

                <a href="{{ isset($permissions) && strpos($permissions, 'c') > -1 ? route($action.'_update') : '#' }}"
                    class="text-yellow-300 bg-transparent border border-yellow-300 font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-yellow-300 hover:text-gray-600 focus:ring-white">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    {{ isset($permissions) && strpos($permissions, 'u') > -1 ? 'View more' : '權限不足' }}
                </a>
            </div>
            {{-- 會員刪除 --}}
            <div
            class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-red-500 rounded-lg bg-gray-900 text-red-500">
            <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">{{ $title }}刪除</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    管理員權限限制才能使用此功能
                </div>

                <a href="{{ isset($permissions) && strpos($permissions, 'c') > -1 ? route($action.'_delete') : '#' }}"
                    class="text-red-500 bg-transparent border border-red-500 font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-red-500 hover:text-white focus:ring-white">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    {{ isset($permissions) && strpos($permissions, 'd') > -1 ? 'View more' : '權限不足' }}
                </a>
            </div>
        </div>
    </div>
</x-layout>
