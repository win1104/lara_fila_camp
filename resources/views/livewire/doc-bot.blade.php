{{-- <div>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="font-semibold text-xl text-gray-800 leading-tight">Mobile printer - MP3 200 Documentation Assistant</h3>
        <div class="mb-4">
            <p class="text-gray-600">Enter you question, and I will try to find an answer in the current mobile printer - MP3 200 documentation.</p>
        </div>
        <form wire:submit.prevent="ask">
            <div>
                <label for="question">Question</label>
                <input type="text"
                       name="question"
                       wire:model="question"
                       placeholder="How to run a single test?"
                >
            </div>
            <button type="submit">
                <span wire:loading.class="invisible">Ask</span>
            </button>
        </form>
        @if($answer)
            <h3 class="mt-8 mb-1 text-base font-semibold leading-6 text-gray-900">My answer</h3>
            <div class="mb-2 prose">
                {!! $answer !!}
            </div>
        @endif
    </div>
</div>
</div> --}}


 {{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MP3 200 使用手冊助理') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8"> --}}
        <form wire:submit.prevent="ask">
            <div>
                <textarea type="text"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        {{-- name="question" --}}
                        wire:model="question"
                        placeholder="How to run a single test?"
                ></textarea>
            </div>
            <button type="submit">
                <span wire:loading.class="invisible">Ask</span>
            </button>
        </form>
        {{-- <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($chats as $chat)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $chat->title }}</span>
                                <small class="ml-2 text-sm text-gray-600">by Chat GPT</small>
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{!! Str::markdown($chat->message) !!}</p>
                    </div>
                </div>
            @endforeach
        </div> --}}
{{--
            <form wire:submit.prevent="ask">
                <div class="mb-4">
                    <input
                        type="text"
                        name="question"
                        wire:model="question"
                        placeholder="請輸入您的問題..."
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        rows="3"
                    ></input>
                </div>

                {{-- <x-primary-button class="mt-4">
                    <span wire:loading.class="invisible">發送問題</span>
                    <div wire:loading class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></div>
                    </div>
                </x-primary-button> --}
                <x-primary-button class="mt-4">
                <span wire:loading.class="invisible">Ask</span>
                {{-- <x-spinner class="absolute invisible" wire:loading.class.remove="invisible" /> --}
            </x-primary-button>
            </form>

            @if($answer)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">回答：</h3>
                    <div class="prose max-w-none">
                        {!! $answer !!}
                    </div>
                </div>
            @endif
            --}}
    {{-- </div>
</x-app-layout> --}}
