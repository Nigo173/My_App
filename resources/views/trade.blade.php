<x-layout>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <div class="max-w-sm rounded shadow-lg mx-auto">
            {{-- 照片 --}}
            @if (isset($data))
                <div class="relative h-100 h-1/4 z-0 w-full mb-8 group">
                    <div class="absolute bottom-0 top-5 w-full h-full bg-slate-300">
                        <div class="relative">
                            {{-- <label for="myfileid" class="cursor-pointer" title="上傳圖片"> --}}
                            <img class="h-full w-full" id="imgView" src="{{ isset($data) ? $data->m_Img : '' }}">
                            {{-- <div class="absolute left-0 top-0 w-10 h-10">
                                    <input type="file" id="myfileid" accept="image/png, image/gif, image/jpeg"
                                        class="text-sm w-24 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        required />
                                </div> --}}
                            {{-- </label> --}}
                        </div>
                    </div>

                    {{-- <label for="img"
                        class="text-red-700 peer-focus:font-medium absolute text-sm z-10 right-0 -top-1">照片
                        *圖片小於2MB*</label> --}}
                </div>
            @endif
            {{-- <canvas id="my_canvas"></canvas>
                <video id="my_video" poster="https://alldata.sgp1.digitaloceanspaces.com/images%2Fwebcam_hint.png"
                    playsinline autoplay muted></video> --}}
            @if (!isset($data))
                <form class="w-10/12 mx-auto" action="{{ route('trade_list') }}" method="POST">
                    @csrf
                    <select onchange="this.form.submit()" name="searchMember"
                        class="text-base block py-1.5 w-full text-gray-500 bor bg-gray-200 border-0 border-b-2 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                        <option value="" selected>
                            {{ isset($member) && sizeof($member) > 0 ? '選擇清單' : '無查詢結果' }}{{ isset($member) ? sizeof($member) : '0' }}
                        </option>
                        @if (isset($member) && sizeof($member) > 0)
                            @foreach ($member as $members)
                                <option value="{{ $members->m_CardId }}">姓名:{{ $members->m_Name }}
                                    電話:{{ $members->m_Phone }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </form>
            @endif

            <form id="formUpdate" action="{{ route('trade_list') }}" method="POST">
                @csrf
                <div class="flex justify-center items-center mt-2">
                    <label class="font-bold text-right pr-1 w-1/6" for="cardId">
                        身分證:
                    </label>
                    <input type="text" name="cardId" value="{{ isset($data) ? $data->m_CardId : '' }}"
                        maxlength="10" pattern="^[A-Z]{1}[0-9]{9}$"
                        class="py-1 text-gray-600 bg-transparent border-0 border-b-2 border-gray-400 focus:outline-none focus:border-gray-300 focus:ring-gray-500"
                        placeholder="英文大寫開頭" />
                </div>
                <div class="flex justify-center items-center mt-4">
                    <label class="font-bold text-right pr-1 w-1/6" for="Id">
                        編號:
                    </label>

                    <input type="text" name="Id" value="{{ isset($data) ? $data->m_Id : '' }}" maxlength="10"
                        class="py-1 text-gray-600 bg-transparent border-0 border-b-2 border-gray-400 focus:outline-none focus:border-gray-300 focus:ring-gray-500" />
                </div>
                <div class="flex justify-center items-center mt-4">
                    <label class="font-bold text-right pr-1 w-1/6" for="name">
                        姓名:
                    </label>

                    <input type="text" name="name" value="{{ isset($data) ? $data->m_Name : '' }}" maxlength="20"
                        class="py-1 text-gray-600 bg-transparent border-0 border-b-2 border-gray-400 focus:outline-none focus:border-gray-300 focus:ring-gray-500" />
                </div>
                <div class="flex justify-center items-center mt-4">
                    <label class="font-bold text-right pr-1 w-1/6" for="birthday">
                        生日:
                    </label>

                    <input type="text" name="birthday" value="{{ isset($data) ? $data->m_Birthday : '' }}"
                        pattern="^[0-1]{1}[0-9]{2}-(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))-(([0]{1}[1-9]{1})|([1-2]{1}[0-9]{1})|([3]{1}[0-1]{1}))$"
                        maxlength="9"
                        class="py-1 text-gray-600 bg-transparent border-0 border-b-2 border-gray-400 focus:outline-none focus:border-gray-300 focus:ring-gray-500"
                        placeholder="格式xxx-xx-xx" />
                </div>
                <div class="flex justify-center items-center mb-3 mt-4">
                    <label class="font-bold text-right pr-1 w-1/6" for="phone">
                        電話:
                    </label>

                    <input type="text" name="phone" value="{{ isset($data) ? $data->m_Phone : '' }}"
                        maxlength="20"
                        class="py-1 text-gray-600 bg-transparent border-0 border-b-2 border-gray-400 focus:outline-none focus:border-gray-300 focus:ring-gray-500" />
                </div>
                <input type="submit" class="text-white hidden" name="search" />
            </form>

            <hr class="h-px mx-4 my-2  {{ isset($memberlabel) ? 'bg-gray-400' : '' }} border-0">
            @if (isset($memberlabel))
                {{-- 交易紀錄 --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-center font-bold">
                                <th scope="col" class="px-2 py-2">
                                    標籤
                                </th>
                                <th scope="col" class="px-2 py-2">
                                    次數
                                </th>
                                <th scope="col" class="px-2 py-2">
                                    日期
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberlabel as $memberlabels)
                                <tr class="text-center text-gray-600">
                                    <td class="px-2 py-2">
                                        {{ $memberlabels->t_lTitle }}
                                    </td>
                                    <td>
                                        {{ $memberlabels->t_Count }}
                                    </td>
                                    <td>
                                        {{ $memberlabels->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr class="h-px mx-4 my-2 bg-400 border-0">

                <p class="font-bold text-center w-28">標籤機連結</p>

                <div class=" grid grid-cols-4 pt-2 justify-items-center">

                    @if (isset($label))

                        @foreach ($label as $labels)
                            @php

                                $CountdownTimeArray = [];

                                if (isset($currentlabel)) {
                                    foreach ($currentlabel as $currentlabels) {
                                        if ($currentlabels->t_lId == $labels->l_Id) {
                                            if (
                                                !array_key_exists($labels->l_Id, $CountdownTimeArray) &&
                                                $currentlabels->countdownTime > 0
                                            ) {
                                                $CountdownTimeArray[$labels->l_Id] = $currentlabels->countdownTime;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            <form id="formCreate" data-action="{{ route('trade_create') }}" method="POST">
                                @csrf
                                <input type="hidden" name="Id" value="{{ isset($data) ? $data->m_Id : '' }}"
                                    required />
                                <input type="hidden" name="cardId" value="{{ isset($data) ? $data->m_CardId : '' }}"
                                    required />
                                <input type="hidden" name="name" value="{{ isset($data) ? $data->m_Name : '' }}"
                                    required />
                                <input type="hidden" name="birthday"
                                    value="{{ isset($data) ? $data->m_Birthday : '' }}" required />
                                <input type="hidden" name="phone" value="{{ isset($data) ? $data->m_Phone : '' }}"
                                    required />
                                <input type="hidden" name="mImg" value="{{ isset($data) ? $data->m_Img : '' }}"
                                    required />
                                <input type="hidden" name="lId" value="{{ $labels->l_Id }}" required />
                                <input type="hidden" name="lTitle" value="{{ $labels->l_Title }}" required />
                                <input type="hidden" name="lCurrent" value="{{ $labels->l_Current }}" required />

                                @if ($labels->l_Current == 'day')
                                    <div class="relative">
                                        @if (array_key_exists($labels->l_Id, $CountdownTimeArray))
                                            <input type="button"
                                                class="cursor-pointer text-white bg-gradient-to-r from-gray-400 via-gray-500 to-gray-600 hover:bg-gradient-to-br shadow-lg shadow-gray-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                                value="{{ $labels->l_Title }}"
                                                onclick="labelConten({{ $labels }})"
                                                data-modal-target="popup-modal" data-modal-toggle="popup-modal" />
                                            <div
                                                class="absolute inline-flex items-center justify-center w-9 h-5 text-xs font-bold text-white bg-yellow-400 rounded -bottom-2 -end-2">
                                                {{ $CountdownTimeArray[$labels->l_Id] }} </div>
                                        @else
                                            <input type="submit" id="btn-day"
                                                class="cursor-pointer text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br shadow-lg shadow-gray-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                                value="{{ $labels->l_Title }}" />
                                        @endif
                                    </div>
                                @elseif($labels->l_Current == 'shift')
                                    <div class="relative">
                                        @if (array_key_exists($labels->l_Id, $CountdownTimeArray))
                                            <input type="button"
                                                class="cursor-pointer text-white bg-gradient-to-r from-gray-400 via-gray-500 to-gray-600 hover:bg-gradient-to-br shadow-lg shadow-gray-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                                value="{{ $labels->l_Title }}"
                                                onclick="labelConten({{ $labels }})"
                                                data-modal-target="popup-modal" data-modal-toggle="popup-modal" />
                                            <div
                                                class="absolute inline-flex items-center justify-center w-9 h-5 text-xs font-bold text-white bg-yellow-400 rounded -bottom-2 -end-2">
                                                {{ $CountdownTimeArray[$labels->l_Id] }}</div>
                                        @else
                                            <input type="submit" id="btn-shift"
                                                class="cursor-pointer text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br shadow-lg shadow-gray-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                                value="{{ $labels->l_Title }}" />
                                        @endif
                                    </div>
                                @else
                                    <input type="submit"
                                        class="cursor-pointer text-white bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br shadow-lg shadow-gray-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                        value="{{ $labels->l_Title }}" />
                                @endif
                            </form>
                        @endforeach
                    @endif
                </div>

                <div class="flex justify-center items-center mb-8 py-8">
                    <label class="font-bold text-center" for="name">
                        備註
                    </label>

                    <input type="text" name="remark" value="{{ isset($data) ? $data->m_Remark : '' }}"
                        maxlength=50"
                        class="w-5/6 py-1 text-blue-900 bg-transparent border-0 border-b-2 focus:outline-none"
                        placeholder="會員備註" />
                </div>
            @endif
        </div>
    </div>
    {{-- Modal Content Detail --}}
    <div id="popup-modal" tabindex="-1"
        class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-red-400 w-10 h-10" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div class="grid grid-cols-3 text-2xl font-bold tracking-tight text-gray-900">
                        <p id="label-title"></p>
                        <p id="label-TitleOne"></p>
                        <p id="label-Current"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $(document).on("submit", '#formCreate', function() {
                event.preventDefault();

                var form = $('#formCreate');
                // 驗證表單
                var reportValidity = form[0].reportValidity();
                var reportValiditys = $('#formUpdate')[0].reportValidity();

                if (reportValidity && reportValiditys) {
                    $('#Modal').removeClass('hidden');
                    var url = $(this).attr('data-action');

                    var formData = new FormData(this);
                    formData.append('remark', $('input[name="remark"]').val());

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            if (response.msg.indexOf('成功') > -1) {
                                // 列印
                                setTimeout(() => {
                                    printLabel(response);
                                }, 1000);
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

            function printLabel(response) {
                var trade = JSON.parse(response.trade);
                var label = JSON.parse(response.label);
                // size: 264px 188px;
                var printWindow = window.open('', '', 'height=1080, width=1920');
                printWindow.document.write(`
                <html>
                <head>
                    <title>標籤列印</title>
                    <style>
                    @media print {
                        @page {
                            margin: 0;
                        }
                        * {
                            padding: 0;
                            margin: 0;
                            color: black;
                        }
                        #table {
                            text-align: center;
                            width:100%;
                            height:100%;
                        }
                        tr {
                            height: 100%;
                        }
                        td {
                            width: 100%;
                            font-size: 18px;
                            font-weight: 600;
                        }
                        #trOne {
                            height: 40px;
                        }
                        #tdOne {
                            font-size: 26px;
                            font-weight: bold;
                        }
                        #trTwo {
                            height: 20px;
                        }
                        #trThree {
                            height: 20px;
                        }
                        #trThree-left,
                        #trFour-left {
                            width: 65% !important;
                        }
                        #trThree-right,
                        #trFour-right {
                            width: 35% !important;
                        }
                        #trFour {
                            height: 20px;
                        }

                        #trFive {
                            height: 20px;
                        }
                    }
                    </style>
                </head>
                <body>
                    <table id="table">
                        <tr id="trOne">
                            <td id="tdOne" colspan="2" nowrap>${label.l_TitleOne}</td>
                        </tr>
                        <tr id="trTwo">
                            <td colspan="2" nowrap>${label.l_TitleTwo}</td>
                        </tr>
                        <tr id="trThree">
                            <td id="trThree-left" nowrap>${label.l_TitleThree}</td>
                            <td id="trThree-right" nowrap>${label.l_TitleFour}</td>
                        </tr>
                        <tr id="trFour">
                            <td id="trFour-left" nowrap>${trade.t_mId}</td>
                            <td id="trFour-right" nowrap>${trade.t_mName}</td>
                        </tr>
                        <tr id="trFive">
                            <td colspan="2" nowrap>${trade.t_No}</td>
                        </tr>
                    </table>
                </body>
                </html>
                `);
                printWindow.print();
                setTimeout(function() {
                    printWindow.close();
                }, 0);
            }
        });

        function labelConten(data) {
            document.getElementById('label-title').innerText = data.l_Title === undefined ? '' : data.l_Title;
            document.getElementById('label-TitleOne').innerText = data.l_TitleOne === undefined ? '' : data.l_TitleOne;
            var l_Current = '';
            if (data.l_Current !== undefined) {
                if (data.l_Current == 'day') {
                    l_Current = '整日限一次';
                } else if (data.l_Current == 'shift') {
                    l_Current = '班次限制';
                } else if (data.l_Current == 'shift') {
                    l_Current = '無限制';
                }
            }
            document.getElementById('label-Current').innerText = l_Current;
        }
    </script>
</x-layout>
