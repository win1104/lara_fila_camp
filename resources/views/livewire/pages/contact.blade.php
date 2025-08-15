<div class="bg-white">

    <div class="relative">
        <img src="{{ asset('bg_contact_us.png') }}" class="absolute inset-0 object-cover w-full h-full" alt="" />
        <div class="relative  bg-opacity-75">
            <div class="max-w-[1600px] mx-auto px-8 py-28 lg:px-32">

                <div class="sm:text-left">
                    <div class="flex justify-between items-center flex-wrap md:flex-nowrap gap-0 lg:gap-14 flex-col lg:flex-row">
                        <div class="max-w-[507px] w-full">
                            <h2 class="mb-8 font-sans text-2xl font-black leading-none text-white sm:text-5xl">
                                溝通的訊號
                            </h2>
                            <p class="text-xl text-white font-medium md:text-3xl">
                                我們將與您一同創造心中美好作品，將理想與現實接軌、實踐
                            </p>
                        </div>


                        <div class="max-w-3xl mx-auto mt-16 px-6 py-8 bg-white rounded-3xl shadow-md w-full">
                            {{-- <h2 class="text-2xl font-bold mb-6 text-center">取得聯繫</h2> --}}

                            {{-- <form wire:submit.prevent="submit" id="contact-form" class="space-y-6"> --}}
                            <form wire:submit.prevent="submit" id="contact-form" class="space-y-6" wire:key="{{ $formKey }}">
                                <div>
                                    <label for="member_name" class="block text-sm font-medium text-gray-700">
                                        <span class="text-red-500">*</span> 您的姓名
                                    </label>
                                    <input type="text" id="member_name" wire:model="member_name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('member_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="member_phone" class="block text-sm font-medium text-gray-700">聯絡電話</label>
                                    <input type="text" id="member_phone" wire:model="member_phone"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label for="member_email" class="block text-sm font-medium text-gray-700">
                                        <span class="text-red-500">*</span> 電子信箱
                                    </label>
                                    <input type="email" id="member_email" wire:model="member_email"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('member_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="member_company" class="block text-sm font-medium text-gray-700">公司名稱</label>
                                    <input type="text" id="member_company" wire:model="member_company"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label for="question_category" class="block text-sm font-medium text-gray-700">洽詢項目</label>
                                    <select id="question_category" wire:model="question_category"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">請選擇洽詢項目</option>
                                        <option value="技術問題">技術問題</option>
                                        <option value="製作網站">製作網站</option>
                                        <option value="其它問題">其它問題</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="member_note" class="block text-sm font-medium text-gray-700">備註</label>
                                    <textarea id="member_note" rows="5" wire:model="member_note"
                                        class="mt-1 h-16 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                </div>

                                <div>
                                    <label for="captcha" class="block text-sm font-medium text-gray-700">
                                        <span class="text-red-500">*</span> 驗證碼
                                    </label>
                                    <div class="flex items-center mt-1 flex-col xl:flex-row flex-wrap">
                                        <img src="{{ url(app()->getLocale() . '/captcha') }}" alt="驗證碼" class="mb-4 xl:mb-0 mr-0 xl:mr-4 cursor-pointer"
                                            onclick="this.src='{{ url(app()->getLocale() . '/captcha') }}?'+Math.random()">
                                        <input id="captcha" type="text" wire:model="captcha" placeholder="請輸入驗證碼">
                                        @if (session('success'))
                                            <div class="text-green-500 text-sm">{{ session('success') }}</div>
                                        @else
                                            @error('captcha') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                                        @endif
                                        {{-- @error('captcha') <div class="text-red-600">{{ $message }}</div> @enderror --}}
                                        <div class="text-center mt-12 2xl:mt-0 ml-0 2xl:ml-12">
                                            <button type="submit"
                                                class="inline-flex text-white bg-[#9BBF3E] rounded-3xl border-0 py-3 px-12 focus:outline-none hover:bg-[#8cb02f] text-lg">
                                                確定送出
                                            </button>
                                            {{-- <button type="button" wire:click="resetForm">清空</button> --}}
                                        </div>
                                    </div>
                                    {{-- <p class="text-sm text-gray-500 mt-1">(驗證碼不分大小寫)</p> --}}
                                </div>



                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div  class="max-w-[1600px] mx-auto px-8 py-24 lg:px-32">
        <p class="sm:text-4xl text-3xl mb-6 font-black text-gray-800 font-sans text-center">混合無限智慧科技</p>
        <p class="text-lg font-medium text-center text-[#666666]">設計不只是設計，<br>混合無限創意，為您提供好設計與專屬的品牌網站！</p>
        <div class="grid gap-8 row-gap-5 sm:grid-cols-2 lg:grid-cols-3 my-14">
            <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm bg-[#F2F6F9]">
                <div>
                    <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                        <img src="{{ asset('nobg_ai.png') }}" alt="" class="bg-[#146CDF]">
                    </div>
                    <h3 class="mb-3 font-black leading-5 ">超越客服，打造沉浸式品牌體驗</h3>
                    <p class="mb-3 text-base ">
                        AI 客服助理能即時解決客戶問題，減少等待時間，也減少人工客服壓力，讓客服人員專注於複雜問題
                    </p>
                </div>
            </div>
            <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm bg-[#F2F6F9]">
                <div>
                    <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                        <img src="{{ asset('Communication - Chat_Circle_Check.png') }}" alt="" class="bg-[#146CDF]">
                    </div>
                    <h3 class="mb-3 font-black leading-5 ">告別制式化回應，讓每個對話都獨特</h3>
                    <p class="mb-3 text-base ">
                        透過對話，理解客戶需求，AI 客服助理提供個性化建議
                    </p>
                </div>
            </div>
            <div class="flex flex-col justify-between p-5 rounded-3xl shadow-sm bg-[#F2F6F9]">
                <div>
                    <div class="flex items-center w-16 h-8 mb-5 rounded-full">
                        <img src="{{ asset('User - User_Voice.png') }}" alt="" class="bg-[#146CDF]">
                    </div>
                    <h3 class="mb-3 font-black leading-5 ">您的客戶，值得最智能的即時服務</h3>
                    <p class="mb-3 text-base ">
                        提升客戶滿意度、品牌忠誠度
                    </p>
                </div>
            </div>
        </div>
    </div>




</div>


{{-- <div>
    <div class="max-w-[1600px] mx-auto px-8 py-28 lg:px-32">
        <div class="form_box">
            <h2>取得聯繫</h2>

            @if (session()->has('success'))
                <div class="text-green-600">{{ session('success') }}</div>
            @endif

            <form wire:submit.prevent="submit">
                <div>
                    <label>您的姓名：</label>
                    <input type="text" wire:model="member_name">
                    @error('member_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>聯絡電話：</label>
                    <input type="text" wire:model="member_phone">
                </div>

                <div>
                    <label>電子信箱：</label>
                    <input type="email" wire:model="member_email">
                    @error('member_email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>公司名稱：</label>
                    <input type="text" wire:model="member_company">
                </div>

                <div>
                    <label>洽詢項目：</label>
                    <select wire:model="question_category">
                        <option value="">請選擇洽詢項目</option>
                        <option value="技術問題">技術問題</option>
                        <option value="製作網站">製作網站</option>
                        <option value="其它問題">其它問題</option>
                    </select>
                </div>

                <div>
                    <label>備註：</label>
                    <textarea wire:model="member_note" cols="45" rows="5"></textarea>
                </div>

                <div>
                    <label>驗證碼：</label>
                    <div class="flex items-center">
                        <span id="captcha-img">{!! captcha_img() !!}</span>
                        <button type="button" wire:click="$refresh" class="ml-2">重新整理</button>
                    </div>
                    <input type="text" wire:model="code">
                    @error('code') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit">送出</button>
                </div>
            </form>
        </div>
    </div>

</div> --}}
