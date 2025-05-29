<div>
    @if($menuType == 'list')
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">{{ $posts->first()->menu->title }}</h1>
            <div class="grid gap-6">
                <section class="text-gray-600 body-font overflow-hidden">
                    <div class="container px-5 py-24 mx-auto flex flex-wrap gap-6 justify-center items-center lg:flex-nowrap">
                        <div class="-my-8 divide-y-2 divide-gray-100">
                            @foreach($posts as $post)
                                <div class="py-8 flex flex-wrap md:flex-nowrap">
                                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                                        <span class="font-semibold title-font text-gray-700">CATEGORY</span>
                                        <span class="text-sm text-gray-500">{{ $post->date }}</span>
                                    </div>
                                    <div class="md:flex-grow">
                                        <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{ $post->title }}</h2>
                                        <p class="leading-relaxed">{!! $post->content !!}</p>
                                        <a class="text-indigo-500 inline-flex items-center mt-4">Learn More
                                            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @elseif($menuType == 'tilelist')
        <div class="container mx-auto px-4 py-8">
            <div class="grid gap-6">
                <section class="text-gray-600 body-font overflow-hidden">
                    <div class="container px-5 py-24 mx-auto flex flex-wrap gap-6 justify-center items-center lg:flex-nowrap">
                        @foreach($posts as $post)
                            <x-mary-card title="{{ $post->title }}">
                                {!! $post->content !!}
                                <x-slot:figure>
                                    <img src="https://picsum.photos/500/200" />
                                </x-slot:figure>
                                <x-slot:menu>
                                    <x-mary-button icon="o-share" class="btn-circle btn-sm" />
                                    <x-mary-icon name="o-heart" class="cursor-pointer" />
                                </x-slot:menu>
                                <x-slot:actions separator>
                                    <x-mary-button label="詳細內容" class="btn-success" link="/tw/post/{{ $post->menu_slug }}/{{ $post->slug }}" />
                                    {{-- <x-mary-button label="詳細內容" class="btn-success" link="{{ route('post.show', ['type' => 'post', 'menu' => $post->slug]) }}" /> --}}
                                </x-slot:actions>
                            </x-mary-card>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    @elseif($menuType == 'tab')
        <div class="container mx-auto px-4 py-8">
            <div x-data="{ tabs: [] }">
            <x-mary-tabs wire:model="activeTab">
                @foreach($posts as $index => $tabb)
                    <x-mary-tab :name="'tab-' . $index" :label="$tabb->title" icon="o-users">
                        <div>{{ $tabb->content }}</div>
                    </x-mary-tab>
                    {{-- <x-mary-tab name="tricks-tab" label="Tricks" icon="o-sparkles">
                        <div>Tricks</div>
                    </x-mary-tab>
                    <x-mary-tab name="musics-tab" label="Musics" icon="o-musical-note">
                        <div>Musics</div>
                    </x-mary-tab> --}}
                @endforeach
            </x-mary-tabs>
            </div>

            {{-- <div class="grid gap-6">
                <section class="text-gray-600 body-font overflow-hidden">
                    <div class="container px-5 py-24 mx-auto flex flex-wrap gap-6 justify-center items-center lg:flex-nowrap">
                        @foreach($posts as $post)
                            <x-mary-card title="{{ $post->title }}">
                                {!! $post->content !!}
                                <x-slot:figure>
                                    <img src="https://picsum.photos/500/200" />
                                </x-slot:figure>
                                <x-slot:menu>
                                    <x-mary-button icon="o-share" class="btn-circle btn-sm" />
                                    <x-mary-icon name="o-heart" class="cursor-pointer" />
                                </x-slot:menu>
                                <x-slot:actions separator>
                                    <x-mary-button label="詳細內容" class="btn-success" link="/tw/post/{{ $post->slug }}" />
                                </x-slot:actions>
                            </x-mary-card>
                        @endforeach
                    </div>
                </section>
            </div> --}}
        </div>
    @else
        <div class="container mx-auto px-4 py-8">
            <article class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                @if($post->intro)
                    <div class="text-gray-600 mb-6">{{ $post->intro }}</div>
                @endif
                <div class="prose max-w-none">
                    {!! $post->content !!}
                </div>
            </article>
        </div>

        {{-- <div class="container mx-auto px-4 py-8">
            <x-mary-form wire:submit="save">
                <x-mary-input label="Name" wire:model="name" />
                <x-mary-input label="Amount" wire:model="amount" prefix="USD" money hint="It submits an unmasked value" />

                <x-slot:actions>
                    <x-mary-button label="Cancel" />
                    <x-mary-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-mary-form>
        </div> --}}
    @endif

    @if(config('app.debug'))
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <pre>
                Post: {{ print_r($post, true) }}
                Slug: {{ $slug }}
            </pre>
        </div>
    @endif
</div>
