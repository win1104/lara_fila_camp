<div class="fixed bottom-4 right-4 z-50 flex items-end gap-4 mx-8">
    @if ($open)
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
    @endif

    <button wire:click="toggle" class="bg-indigo-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="h-10 w-10 ">
            <path d="M149.3,79.9c0.9,0,1.9,0,2.9,0c3.2,0,6.3,0,9.5,0c2.3,0,4.5,0,6.8,0c7.4,0,14.9,0,22.3,0c2.6,0,5.1,0,7.7,0
                c10.7,0,21.3,0,32,0c2.8,0,5.5,0,8.3,0c1,0,1,0,2.1,0c11.1,0,22.2,0,33.4-0.1c11.4,0,22.9-0.1,34.3-0.1c6.4,0,12.8,0,19.2,0
                c6,0,12.1,0,18.1,0c2.2,0,4.4,0,6.6,0c23.5-0.1,42.5,5,59.9,21.7c19.9,20.7,21,45.6,20.9,72.8c0,2.5,0,5.1,0,7.6
                c0,5.3,0,10.5,0,15.8c0,6.1,0,12.2,0,18.2c0,5.9,0,11.8,0,17.6c0,2.5,0,5,0,7.5c0,3.5,0,6.9,0,10.4c0,1,0,2.1,0,3.1
                c0,0.9,0,1.9,0,2.9c0,1.2,0,1.2,0,2.5c-0.4,3.7-1.4,6.5-4,9.2c-3.7,1.9-7.1,1.5-11,0.4c-0.9-0.4-1.9-0.7-2.8-1.1
                c-5.5-2-10.8-2.9-16.6-3.4c-3.6-0.9-4.6-1.6-6.8-4.7c-0.6-3.4-0.5-6.7-0.5-10.1c0-1.5,0-1.5,0-3.1c0-3.4,0-6.8,0-10.2
                c0-2.4,0-4.7,0-7.1c0-6.2,0-12.5,0-18.7c0-10,0-19.9-0.1-29.9c0-3.5,0-6.9,0-10.4c0-2.1,0-4.3,0-6.4c0-1,0-1.9,0-2.9
                c-0.1-11.5-1.5-22.2-9.5-30.9c-11.6-10.8-27-9.5-41.8-9.5c-2,0-4.1,0-6.1,0c-5.5,0-11,0-16.5,0c-5.8,0-11.5,0-17.3,0
                c-9.7,0-19.4,0-29.1,0c-11.2,0-22.4,0-33.6,0c-9.6,0-19.2,0-28.9,0c-5.7,0-11.5,0-17.2,0c-5.4,0-10.8,0-16.2,0c-2,0-4,0-5.9,0
                c-21-0.3-21-0.3-38.9,9.5c-10.9,11.8-9.5,27.7-9.5,42.7c0,2,0,4,0,6c0,5.4,0,10.9,0,16.3c0,5.7,0,11.4,0,17.1c0,9.6,0,19.2,0,28.8
                c0,11.1,0,22.1,0,33.2c0,9.5,0,19,0,28.6c0,5.7,0,11.4,0,17c0,5.3,0,10.7,0,16c0,2,0,3.9,0,5.9c-0.4,21.5-0.4,21.5,9.5,39.9
                c9.6,8.9,21.4,9.6,33.9,9.5c1.2,0,2.3,0,3.6,0c2.5,0,5.1,0,7.6,0c4,0,8,0,12,0c11.4,0,22.8,0.1,34.1,0c6.3,0,12.6,0,18.9,0
                c3.3,0,6.7,0,10,0c3.7,0,7.4,0,11.1,0c1.1,0,2.2,0,3.3,0c7.4,0.1,7.4,0.1,11.3,3c1.8,2.5,3.2,4.9,4.6,7.7c2.9,5.7,6.7,9.8,11.2,14.3
                c2.4,3,2.9,4.8,3.1,8.6c-2.2,5.6-2.2,5.6-5,7c-1.9,0.1-3.9,0.1-5.8,0.2c-1.2,0-2.5,0-3.8,0c-1.4,0-2.8,0-4.1,0c-1.5,0-2.9,0-4.4,0
                c-4.8,0-9.6,0-14.3,0.1c-1.6,0-3.3,0-4.9,0c-6.9,0-13.7,0-20.6,0.1c-9.8,0-19.6,0-29.4,0.1c-6.9,0-13.8,0.1-20.7,0.1
                c-4.1,0-8.2,0-12.4,0c-28,0.2-49.5-2.4-70.7-22.6c-12.3-12.9-19-29.6-19-47.2c0-0.9,0-1.9,0-2.9c0-3.2,0-6.3,0-9.5
                c0-2.3,0-4.5,0-6.8c0-7.4,0-14.9,0-22.3c0-2.6,0-5.1,0-7.7c0-10.7,0-21.3,0-32c0-2.8,0-5.5,0-8.3c0-0.7,0-1.4,0-2.1
                c0-11.1,0-22.2-0.1-33.4c0-11.4-0.1-22.9-0.1-34.3c0-6.4,0-12.8,0-19.2c0-6,0-12.1,0-18.1c0-2.2,0-4.4,0-6.6
                c-0.1-11.9,0.2-22.3,4.5-33.6c0.3-0.7,0.5-1.4,0.8-2.2c7.4-17.9,21.1-30.4,38.2-38.8C131.9,81.4,139.8,79.9,149.3,79.9z"/>
            <path d="M400.4,303.6c2.6,0.4,2.6,0.4,4,1.9c2.2,3.6,3.6,7.4,5.1,11.3c0.7,1.8,1.4,3.5,2,5.3c1.1,2.8,2.1,5.5,3.2,8.3
                c6.7,17.6,13.4,30.9,31.4,39.2c3.6,1.6,7.2,3,10.9,4.5c3.6,1.4,7.1,2.9,10.7,4.3c2.5,1,4.9,2,7.4,3c1.1,0.5,2.3,0.9,3.4,1.4
                c1,0.4,2,0.8,3.1,1.2c2.5,1.1,2.5,1.1,4.5,3.1c0.1,2.6,0.1,2.6,0,5c-8.9,4.7-18.2,8.3-27.7,11.9c-17,6.6-30.5,13.8-38.2,31.1
                c-2.6,5.9-5,11.9-7.4,18c-0.8,2-1.6,4-2.4,6.1c-0.8,1.9-1.6,3.9-2.3,5.8c-0.4,0.9-0.7,1.8-1.1,2.7c-0.3,0.8-0.6,1.6-0.9,2.4
                c-1.1,2.3-1.9,3.6-4,5.1c-2.5,0.1-2.5,0.1-5-1c-1.6-2.5-1.6-2.5-2.9-5.9c-0.7-1.8-0.7-1.8-1.5-3.7c-0.2-0.6-0.5-1.3-0.8-2
                c-0.8-2-1.6-4-2.4-6c-1-2.6-2.1-5.2-3.1-7.9c-7.8-19.6-15.5-32.6-35.4-41.6c-2.9-1.2-5.9-2.3-8.8-3.4c-0.8-0.3-1.5-0.6-2.3-0.9
                c-3.2-1.2-6.3-2.4-9.5-3.6c-2.4-0.9-4.7-1.8-7-2.7c-1.1-0.4-1.1-0.4-2.2-0.8c-2-0.8-2-0.8-5.1-2.7c-1-3.2-1-3.2-1-6
                c3.5-3,7.4-4.5,11.7-6.2c1.1-0.4,1.1-0.4,2.3-0.9c2.4-0.9,4.8-1.9,7.2-2.8c27.4-10.5,27.4-10.5,44.9-33.3c2.6-6.1,4.9-12.2,7.3-18.4
                c1.1-2.8,2.1-5.5,3.2-8.3c0.7-1.7,1.3-3.4,2-5.1c0.4-1.1,0.4-1.1,0.9-2.3c0.3-0.7,0.5-1.3,0.8-2C396.5,305,397.5,304.1,400.4,303.6z
                "/>
            <path d="M208.5,169.7c1.1,0,2.1,0,3.2,0c1.1,0,2.2,0,3.3,0c1.1,0,2.2,0,3.3,0c1.1,0,2.1,0,3.2,0c1.4,0,1.4,0,2.9,0
                c2.8,0.3,4.2,0.7,6.6,2.3c1.1,2.1,1.1,2.1,1.9,4.7c0.3,1,0.7,2,1,3c0.3,1.1,0.7,2.2,1,3.3c0.4,1.1,0.7,2.2,1.1,3.4
                c1.3,3.8,2.5,7.6,3.7,11.5c0.5,1.4,0.9,2.9,1.4,4.3c1.2,3.8,2.5,7.7,3.7,11.5c1,3.2,2.1,6.4,3.1,9.6c8.2,25.2,16.3,50.4,24.3,75.7
                c1.1,3.5,2.2,7,3.4,10.4c0.3,0.9,0.6,1.7,0.9,2.6c0.5,1.6,1.1,3.2,1.6,4.9c1.3,4.2,2.3,7.7,1.8,12.2c-0.7,1-1.3,2-2,3
                c-3.4,0.7-6.9,0.5-10.4,0.5c-1,0-1.9,0.1-2.9,0.1c-7,0-7,0-9.6-2.4c-0.4-1-0.7-2.1-1.1-3.1c-0.3-0.8-0.6-1.5-0.9-2.3
                c-1-2.8-1.9-5.5-2.8-8.3c-0.3-1-0.6-1.9-1-2.9c-2.3-7.1-2.3-7.1-2.3-9.4c-21.1,0.3-42.2,0.7-64,1c-2.6,8.2-5.3,16.5-8,25
                c-2.9,2.9-5.2,2.3-9.1,2.3c-0.9,0-1.8,0-2.8,0c-1.4,0-1.4,0-2.8,0c-1.3,0-1.3,0-2.7,0c-0.8,0-1.6,0-2.5,0c-2.1-0.4-2.1-0.4-4-1.4
                c-2.2-3.9-0.6-8.3,0.5-12.4c0.8-2.8,1.7-5.6,2.6-8.3c0.5-1.6,0.5-1.6,1-3.2c1.1-3.5,2.3-7.1,3.4-10.6c0.8-2.5,1.6-5,2.4-7.5
                c6.7-20.9,13.4-41.8,20.2-62.7c0.2-0.8,0.5-1.5,0.7-2.3c4.4-13.5,4.4-13.5,6.3-19.5c0.3-1,0.3-1,0.7-2c0.4-1.3,0.9-2.6,1.3-3.9
                c1.3-4.1,2.6-8.1,3.9-12.2c0.3-1,0.6-2,1-3c0.6-1.8,1.1-3.6,1.7-5.4c1.8-5.7,1.8-5.7,4.2-7.2C203.5,169.8,205.7,169.7,208.5,169.7z
                M215,206c-3.4,8-6.1,16.2-8.8,24.5c-0.4,1.4-0.9,2.7-1.3,4.1c-0.9,2.8-1.8,5.7-2.8,8.6c-1.2,3.7-2.4,7.3-3.5,11
                c-0.9,2.8-1.8,5.6-2.7,8.5c-0.4,1.3-0.9,2.7-1.3,4c-0.6,1.9-1.2,3.8-1.8,5.6c-0.3,1.1-0.7,2.1-1,3.2c-0.8,2.4-0.8,2.4-0.7,4.5
                c15.8,0,31.7,0,48,0c-1.7-7.6-1.7-7.6-3.8-14.9c-0.4-1.1-0.7-2.1-1.1-3.2c-0.4-1.1-0.7-2.3-1.1-3.4c-0.6-1.8-0.6-1.8-1.2-3.6
                c-1-3.1-2.1-6.3-3.1-9.4c-1.5-4.4-2.9-8.8-4.3-13.2c-0.8-2.3-1.5-4.7-2.3-7c-2.1-6.4-4.1-12.8-6-19.3C215.7,206,215.3,206,215,206z"
                />
            <path d="M322.5,170.7c0.9,0,1.8,0,2.7,0c1.4,0,1.4,0,2.8,0c0.9,0,1.9,0,2.8,0c1.3,0,1.3,0,2.7,0c0.8,0,1.6,0,2.5,0
                c2,0.3,2,0.3,4,2.3c0.3,2.7,0.3,2.7,0.3,6.2c0,0.6,0,1.3,0,1.9c0,2.2,0,4.3,0,6.5c0,1.5,0,3.1,0,4.6c0,4.2,0,8.4,0,12.6
                c0,4.4,0,8.8,0,13.2c0,7.4,0,14.7,0,22.1c0,8.5,0,17.1,0,25.6c0,7.3,0,14.6,0,21.9c0,4.4,0,8.7,0,13.1c0,4.1,0,8.2,0,12.3
                c0,1.5,0,3,0,4.5c0,2.1,0,4.1,0,6.2c0,1.2,0,2.3,0,3.5C340,330,340,330,338,332c-2,0.3-2,0.3-4.5,0.3c-0.9,0-1.8,0-2.7,0
                c-0.9,0-1.9,0-2.8,0c-0.9,0-1.9,0-2.8,0c-1.3,0-1.3,0-2.7,0c-0.8,0-1.6,0-2.5,0c-2-0.3-2-0.3-4-2.3c-0.3-2.7-0.3-2.7-0.3-6.2
                c0-1,0-1,0-1.9c0-2.2,0-4.3,0-6.5c0-1.5,0-3.1,0-4.6c0-4.2,0-8.4,0-12.6c0-4.4,0-8.8,0-13.2c0-7.4,0-14.7,0-22.1
                c0-8.5,0-17.1,0-25.6c0-7.3,0-14.6,0-21.9c0-4.4,0-8.7,0-13.1c0-4.1,0-8.2,0-12.3c0-1.5,0-3,0-4.5c0-2.1,0-4.1,0-6.2
                c0-1.2,0-2.3,0-3.5C316.2,171,318.3,170.7,322.5,170.7z"/>
        </svg>
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