<div>

    <div class="max-w-[1600px] mx-auto px-8 py-28 lg:px-32">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">取得聯繫</h2>

            <form wire:submit.prevent="submit" id="contact-form" class="space-y-6">
                <div>
                    <label for="member_name" class="block text-sm font-medium text-gray-700">
                        <span class="text-red-500">*</span> 您的姓名
                    </label>
                    <input type="text" id="member_name" wire:model.defer="member_name"
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
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div>
                    <label for="captcha" class="block text-sm font-medium text-gray-700">
                        <span class="text-red-500">*</span> 驗證碼
                    </label>
                    <div class="flex items-center space-x-4 mt-1">
                        {{-- <img src="{{ route('captcha') }}" alt="captcha" class="h-12 cursor-pointer" --}}
                            {{-- onclick="this.src='{{ route('captcha') }}?'+Math.random();"> --}}
                        <input type="text" id="captcha" wire:model="captcha"
                            class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">(驗證碼不分大小寫)</p>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                        確定送出
                    </button>
                </div>
            </form>
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