<x-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="pX-2 py-10 bg-slate-800 grid md:grid-cols-3">
            {{-- 會員清單 --}}
            <div
                class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-white rounded-lg bg-gray-900 text-white">
                <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">權限設定</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    管理員權限設定
                </div>
                <a href="{{ route('admins') }}"
                    class="text-white bg-transparent border border-white font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-white hover:text-gray-600 focus:ring-white-800">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    View more
                </a>
            </div>
            {{-- 會員清單 --}}
            <div
                class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-white rounded-lg bg-gray-900 text-white">
                <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">標籤設定</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    標籤機格式和內容
                </div>
                <a href="{{ route('label') }}"
                    class="text-white bg-transparent border border-white font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-white hover:text-gray-600 focus:ring-white-800">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    View more
                </a>
            </div>
            {{-- 會員清單 --}}
            <div
                class="p-4 sm:mb-4 sm:mt-5 mx-5 border border-white rounded-lg bg-gray-900 text-white">
                <div class="flex items-center">
                    <svg class="me-2 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-medium">系統紀錄</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    系統操作紀錄查詢
                </div>
                <a href="{{ route('log') }}"
                    class="text-white bg-transparent border border-white font-medium rounded-lg text-sm px-3 py-2 inline-flex text-center hover:bg-white hover:text-gray-600 focus:ring-white-800">
                    <svg class="me-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    View more
                </a>
            </div>
        </div>
    </div>
</x-layout>
