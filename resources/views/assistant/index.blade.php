    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MP3 200 使用手冊助理') }}
        </h2>
    </x-slot> --}}
{{-- chatbot start --}}
<div class="fixed bottom-4 right-4 z-50 flex items-end gap-4">
    @if ($open)
                <div class="bg-white shadow-lg rounded-lg w-80 h-96 flex flex-col">
                    <div class="bg-indigo-600 text-white px-4 py-2 flex justify-between items-center">
                        <span>{{ __('MP3 200 使用手冊助理') }}</span>
                        <button wire:click="toggle" class="text-white">✖</button>
                    </div>
                    <div class="flex-1">

                        <div id="chatMessages" class="max-w-7xl mx-auto p-2 overflow-y-auto h-[300px] max-h-60">
        {{-- chatbot end --}}

        {{-- Chat bubble atart --}}
                            @foreach ($chats as $chat)
                                <div class="chat chat-end">
                                    @if ($chat->user->avatar)
                                        <div class="chat-image avatar">
                                            <div class="w-10 rounded-full">
                                                <img alt="User's avatar" src="{{ asset('storage/' . $chat->user->avatar) }}" />
                                            </div>
                                        </div>
                                    @else
                                        <div class="chat-image">
                                            <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center">
                                                {{ strtoupper(Str::substr($chat->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="chat-header">
                                        {{ $chat->user->name }}
                                        <time class="text-xs opacity-50">{{ $chat->created_at->format('H:i') }}</time>
                                    </div>
                                    <div class="chat-bubble break-words">{{ $chat->title }}</div>
                                    <div class="chat-footer opacity-50">Delivered</div>
                                </div>
                                <div class="chat chat-start">
                                    <div class="chat-image avatar">
                                        <div class="w-10 rounded-full">
                                            {{-- <img
                                                alt="Tailwind CSS chat bubble component"
                                                src="https://img.daisyui.com/images/profile/demo/kenobee@192.webp"
                                            /> --}}
                                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                                        </div>
                                    </div>
                                    <div class="chat-header">
                                        bright_future
                                        <time class="text-xs opacity-50">{{ $chat->updated_at->format('H:i') }}</time>
                                    </div>
                                    <div class="chat-bubble break-words">{!! Str::markdown($chat->message) !!}</div>
                                    <div class="chat-footer opacity-50">Delivered</div>
                                </div>
                            @endforeach
        {{-- Chat bubble end --}}



        </div>
        </div>
                            <form wire:submit.prevent="ask" wire:key="form-{{ $formKey }}">
                                <div class="flex gap-4 mx-2 my-3 items-center">
                                    <textarea type="text"
                                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                            {{-- name="question" --}}
                                            wire:model="question"
                                            placeholder="How to run a single test?">
                                    </textarea>
                                        <button type="submit" class="py-3 inline-flex items-center px-4 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'">
                                            <span wire:loading.class="invisible">Ask</span>
                                        </button>
                                </div>
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



                </div>
    @endif

    <button wire:click="toggle"
            class="bg-indigo-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg">
        💬
    </button>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('yoyoyoyo');
            scrollToBottom();

            if (window.Livewire) {
                Livewire.on('scrollToBottom', () => {
                    setTimeout(() => {
                        scrollToBottom();
                    }, 100);
                });
            }
        });

        function scrollToBottom() {
            console.log('ohohohoh');
            const container = document.getElementById('chatMessages');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        scrollToBottom();

</script>