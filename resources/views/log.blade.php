<x-layout>
    <div class="relative overflow-x-auto shadow-xl rounded-lg">
        <div class="px-2 py-2">
            @if (isset($log))
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
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                            data-modal-target="Modal"
                            data-modal-toggle="Modal">搜尋</button>
                    </div>
                </form>
                {{-- 表格清單 --}}
                <table class="w-full mt-5 text-md text-gray-600 border border-gray-400">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="px-2 py-3">
                                事件
                            </th>
                            <th scope="col" class="px-2 py-3">
                                更新日期
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($log as $logs)
                            <tr
                                class="bg-white border-b hover:bg-gray-200">
                                <td class="px-2 py-2">
                                    {{ $logs->log }}
                                </td>
                                <td>
                                    {{ $logs->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
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
    </script>
</x-layout>
