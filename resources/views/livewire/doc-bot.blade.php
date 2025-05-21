<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div>
    <div>
        <h3>Mobile printer - MP3 200 Documentation Assistant</h3>
        <div>
            <p>Enter you question, and I will try to find an answer in the current mobile printer - MP3 200 documentation.</p>
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
                {{-- <x-spinner class="absolute invisible" wire:loading.class.remove="invisible" /> --}}
            </button>
            {{-- <div class="relative">
                <button wire:click="Ask" class="bg-blue px-4 py-2 rounded text-white relative">
                    <span wire:loading.class="invisible">Ask</span>
                    <div wire:loading class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></div>
                    </div>
                </button>
            </div> --}}
        </form>
        @if($answer)
            <h3 class="mt-8 mb-1 text-base font-semibold leading-6 text-gray-900">My answer</h3>
            <div class="mb-2 prose">
                {{-- <x-markdown>{!! $answer !!}</x-markdown> --}}
                {!! $answer !!}
            </div>
        @endif
    </div>
</div>
</div>
