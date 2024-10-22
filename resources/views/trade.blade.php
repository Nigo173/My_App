<x-layout>
    <div class="relative overflow-x-auto sm:rounded-lg overflow-y-auto">
        <div class="max-w-sm rounded overflow-hidden shadow-lg mx-auto text-xl">
            <div class="h-full relative">
                {{-- 照片 --}}
                <div class="relative h-100 h-1/4 z-0 w-full mb-8 group">
                    <div class="absolute bottom-0 top-5 w-full h-full bg-slate-300">
                        <div class="relative">
                            <label for="myfileid" class="cursor-pointer" title="上傳圖片">
                                <img class="w-full h-full" id="imgView"
                                    src="{{ isset($data) ? $data->m_CardId : '' }}">
                                <div class="absolute left-0 top-0 w-10 h-10">
                                    <input type="file" name="img" id="myfileid"
                                        accept="image/png, image/gif, image/jpeg"
                                        class="text-sm w-24 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        required />
                                </div>
                            </label>
                            <input type="hidden" name="mImg" value="">
                        </div>
                    </div>

                    <label for="img"
                        class="text-red-700 peer-focus:font-medium absolute text-sm z-10 right-0 -top-1">照片
                        *圖片小於2MB*</label>
                </div>
                {{-- <canvas id="my_canvas"></canvas>
                <video id="my_video" poster="https://alldata.sgp1.digitaloceanspaces.com/images%2Fwebcam_hint.png"
                    playsinline autoplay muted></video> --}}


                <form class="max-w-sm mx-auto" action="{{ route('trade_list') }}" action="POST">
                    @csrf
                    <select onchange="this.form.submit()" name="searchMember"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        @if (isset($member))
                            @foreach ($member as $members)
                                <option value="" selected>選擇清單</option>
                                <option value="{{ $members->m_Id }}">{{ $members->m_Name }}</option>
                            @endforeach
                        @endif
                    </select>
                </form>

                <form action="{{ route('trade_list') }}" method="POST">
                    @csrf
                    <div class="flex items-center mb-6 mt-5">
                        <div class="md:w-1/3">
                            <label class="block text-center" for="cardId">
                                身分證:
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" name="cardId" value="{{ isset($data) ? $data->m_CardId : '' }}"
                                maxlength="10"
                                class="py-1 text-blue-900 bg-transparent border-0 border-b-2 dark:focus:border-gray-400 focus:outline-none" />
                        </div>
                    </div>
                    <div class="flex items-center mb-6 mt-5">
                        <div class="md:w-1/3">
                            <label class="block text-center" for="Id">
                                編號:
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" name="Id" value="{{ isset($data) ? $data->m_Id : '' }}"
                                maxlength="10"
                                class="py-1 text-blue-900 bg-transparent border-0 border-b-2 dark:focus:border-gray-400 focus:outline-none" />
                        </div>
                    </div>
                    <div class="flex items-center mb-6 mt-5">
                        <div class="md:w-1/3">
                            <label class="block text-center" for="name">
                                姓名:
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" name="name" value="{{ isset($data) ? $data->m_Name : '' }}"
                                maxlength="10"
                                class="py-1 text-blue-900 bg-transparent border-0 border-b-2 dark:focus:border-gray-400 focus:outline-none" />
                        </div>
                    </div>
                    <div class="flex items-center mb-6 mt-5">
                        <div class="md:w-1/3">
                            <label class="block text-center" for="birther">
                                生日:
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" name="birther" value="{{ isset($data) ? $data->m_Birther : '' }}"
                                maxlength="10"
                                class="py-1 text-blue-900 bg-transparent border-0 border-b-2 dark:focus:border-gray-400 focus:outline-none" />
                        </div>
                    </div>
                    <div class="flex items-center mb-6 mt-5">
                        <div class="md:w-1/3">
                            <label class="block text-center" for="phone">
                                電話:
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" name="phone" value="{{ isset($data) ? $data->m_Phone : '' }}"
                                maxlength="20"
                                class="py-1 text-blue-900 bg-transparent border-0 border-b-2 dark:focus:border-gray-400 focus:outline-none" />
                        </div>
                    </div>
                    <input type="submit" class="text-white hidden" name="search" value="" />
                </form>

                {{-- 交易紀錄 --}}
                <div class="grid grid-cols-2 gap-1 mb-6 mt-5 text-center w-full bg-slate-300">
                    <div class="h5 font-bold">
                        紀錄
                    </div>
                    <div class="h5 font-bold">
                        次數
                    </div>
                    @if (isset($memberlabel))
                        @foreach ($memberlabel as $memberlabels)
                            <div>{{ $memberlabels->t_lTitle }}</div>
                            <div>{{ $memberlabels->t_Count }}</div>
                        @endforeach
                    @endif
                </div>

                <form action="{{ route('trade_create') }}" method="POST" class="mx-2 text-center" name="form">
                    <span class="m-auto">#標籤機連結</span>
                    @csrf

                    <input type="hidden" name="Id" value="{{ isset($data) ? $data->m_Id : '' }}" />
                    <input type="hidden" name="cardId" value="{{ isset($data) ? $data->m_CardId : '' }}" />
                    <input type="hidden" name="name" value="{{ isset($data) ? $data->m_Name : '' }}" />
                    <div class="grid grid-cols-4 gap-1 mt-3">
                        @if (isset($label))
                            @foreach ($label as $labels)
                                <input type="hidden" name="lId" value="{{ $labels->l_Id }}" />
                                <input type="{{ isset($data) ? 'submit' : 'text' }}" name="lTitle"
                                    {{ isset($data) ? '' : 'readonly' }}
                                    class=" bg-gray-200 border-2 border-blue-800 rounded-full p-1 mx-auto text-center text-sm font-semibold text-gray-700 w-10 h-10 cursor-pointer hover:bg-blue-400"
                                    value="{{ $labels->l_Title }}" onclick="clearText()"
                                    @if (isset($data)) data-modal-target="Modal" data-modal-toggle="Modal" @endif />
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>
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


    {{-- Printer Table --}}
    @if (isset($trade) && $trade != '')
        <section class="table" id="tables">
            <div class="row titleOne">
                <div>大同店</div>
            </div>
            <div class="row">
                <div>限本人使用</div>
            </div>
            <div class="row">
                <div>{{ $trade->t_lTitle }}</div>
                <div>{{ $trade->t_lId }}</div>
            </div>
            <div class="row">
                <div>{{ $trade->t_mCardId }}</div>
                <div>{{ $trade->t_mName }}</div>
            </div>
            <div class="row">
                <div>NO: {{ $trade->t_Id }}</div>
            </div>
        </section>
    @endif

    @if (isset($trade) && $trade != '')
        <script>
            let divContents = document.getElementById("tables").innerHTML;
            let printWindow = window.open('', '', 'height=1280, width=765');
            printWindow.document.write(`
                <html>
                <head>
                    <title>標籤列印</title>
                    <style>
                    @media print {
                        @page {
                            margin: 0;
                            size: 264px 188px;
                        }
                        *
                        {
                            -webkit-print-color-adjust: exact !important;
                            text-align: center;
                        }
                        div.row > div {
                            display: inline-block;
                            margin: 0.1cm;
                            font-size: 1rem;
                        }
                        div.row {
                            display: block;
                            margin: 0.2cm 1cm;
                            font-size: 0;
                            white-space: nowrap;
                        }
                        .table {
                            transform: translate(8.5in, -100%) rotate(90deg);
                            transform-origin: bottom left;
                            display: block;
                            position: absolute;
                        }
                        .titleOne {
                            font-size: 1.5rem !important;
                            font-weight: bold;
                        }
                    }
                    </style>
                </head>
                <body>
                    ${divContents}
                </body>
                </html>
            `);

            printWindow.print();
            setTimeout(function() {
                printWindow.close();
            }, 10);
        </script>
    @endif
    <script>
        // function clearText(event) {
        //     event.disabled = true;

        //     setTimeout(() => {
        //         let allInputs = document.querySelectorAll('input');
        //         allInputs.forEach(singleInput => singleInput.value = '');
        //     }, 4000);
        // }

        // let second = {{ isset($member) || isset($data) || !isset($Id) ? 0 : 5000 }};

        // setTimeout(() => {
        //     document.getElementById('Modal').classList.add('hidden');
        // }, second);

        // let seconds = {{ isset($msg) && $msg != '' ? 3000 : 0 }};

        // setTimeout(() => {
        //     document.getElementById('toast-success-button').click();
        // }, seconds);

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
    </script>
</x-layout>
