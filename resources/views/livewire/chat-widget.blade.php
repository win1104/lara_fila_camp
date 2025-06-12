<div class="fixed bottom-4 right-4 z-50 flex items-end gap-4 mx-8">
    {{-- @if ($open) --}}
        <div class="bg-white shadow-lg rounded-lg w-full max-w-96 h-[534px] flex flex-col">
            <div class="bg-indigo-600 text-white px-4 py-2 flex justify-between items-center">
                <span>{{ __('手冊助理') }}</span>
                <button wire:click="toggle" class="text-white">✖</button>
            </div>
            <div class="flex-1">

                <div id="chatMessages" class="mx-auto p-2 overflow-y-auto max-h-96">
                    {{-- chatbot end --}}

                    {{-- Chat bubble atart --}}
                    {{-- history from db start--}}
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
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center">
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
                    {{-- history from db start--}}

                    {{-- @foreach ($tempChats as $temp)
                        @if ($temp['type'] === 'user')
                            <div class="chat chat-end">
                                <div class="chat-header">
                                    {{ auth()->user()->name }}
                                    <time class="text-xs opacity-50">{{ $temp['timestamp'] }}</time>
                                </div>
                                <div class="chat-bubble break-words bg-blue-100 text-black">
                                    {{ $temp['content'] }}
                                </div>
                            </div>
                        @elseif ($temp['type'] === 'assistant-loading')
                            <div class="chat chat-start">
                                <div class="chat-header">
                                    bright_future
                                    <time class="text-xs opacity-50">{{ $temp['timestamp'] }}</time>
                                </div>
                                <div class="chat-bubble bg-gray-100 text-black italic">
                                    正在思考中...
                                </div>
                            </div>
                        @elseif ($temp['type'] === 'assistant')
                            <div class="chat chat-start">
                                <div class="chat-header">
                                    bright_future
                                    <time class="text-xs opacity-50">{{ $temp['timestamp'] }}</time>
                                </div>
                                <div class="chat-bubble break-words bg-gray-200 text-black">
                                    {!! Str::markdown($temp['content']) !!}
                                </div>
                            </div>
                        @endif
                    @endforeach --}}

                    {{-- Chat bubble end --}}

                </div>
            </div>
            {{-- <form wire:submit.prevent="ask" wire:key="form-{{ $formKey }}"> --}}
            <form wire:submit.prevent="ask">
                <div class="flex gap-4 mx-2 my-3 items-center">
                    <textarea type="text"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        wire:model="question" placeholder="How to run a single test?">
                                                </textarea>
                    <button type="submit"
                        class="py-3 inline-flex items-center px-4 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'">
                        <span wire:loading.class="invisible">Ask</span>
                    </button>
                </div>
            </form>



        </div>
    {{-- @endif --}}

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
        if (!container) return;
        requestAnimationFrame(() => {
            container.scrollTop = container.scrollHeight;
        });
    }

</script>