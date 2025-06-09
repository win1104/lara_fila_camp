<div>
    @if($menuType == 'lists')
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-3xl font-bold mb-6">{{ $posts->first()->menu->title }}</h2>
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
    @elseif($menuType == 'tilelists')
        <div class="container mx-auto py-8">
            <div class="grid gap-6">
                <section class="text-gray-600 body-font overflow-hidden">
                    <div class="container py-24 mx-auto flex flex-wrap gap-6 justify-center items-center lg:flex-nowrap">
                        @foreach($posts as $post)
                            <x-mary-card title="{{ $post->title }}" class="bg-white rounded-lg shadow-md h-[424px]">
                                {{-- {!! $post->content !!} --}}
                                {!! Str::limit($post->content, 100) !!}
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
    @elseif($menuType == 'tabs')
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-center text-3xl font-bold mb-12">{{ $posts->first()->menu->title }}</h2>
            {{-- <div x-data="{ tabs: [] }">
            <x-mary-tabs wire:model="activeTab">
                @foreach($posts as $index => $tabb)
                    <x-mary-tab :name="'tab-' . $index" :label="$tabb->title" icon="o-users" class="text-purple-500">
                        <div class="text-yellow-600">{{ $tabb->content }}123</div>
                    </x-mary-tab>
                @endforeach
            </x-mary-tabs>
            </div> --}}


            <div>
                <div class="flex mb-12 justify-center gap-4">
                    @foreach($posts as $index => $post)
                        <button wire:click="$set('activeTab', 'tab-{{ $index }}')"
                            class="px-4 py-2 border rounded-3xl {{ $activeTab === 'tab-' . $index ? 'bg-blue-600 text-white' : 'bg-white' }}">
                            {{ $post->title }}
                        </button>
                    @endforeach
                </div>

                <div class="p-4">
                    @foreach($posts as $index => $post)
                        @if($activeTab === 'tab-' . $index)
                            <div>
                                {!! $post->content !!}
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    @elseif($menuType == 'collapses')
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-center text-3xl font-bold mb-12">{{ $posts->first()->menu->title }}</h2>
            {{-- <div class="border rounded shadow-sm">
                <button type="button" aria-label="Open item" title="Open item"
                    class="flex items-center justify-between w-full p-4 focus:outline-none">
                    <p class="text-lg font-medium">The quick, brown fox jumps over a lazy dog?</p>
                    <div class="flex items-center justify-center w-8 h-8 border rounded-full">
                        <!-- Add "transform rotate-180" classes on svg, if is open" -->
                        <svg viewBox="0 0 24 24" class="w-3 text-gray-600 transition-transform duration-200">
                            <polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-miterlimit="10" points="2,7 12,17 22,7" stroke-linejoin="round"></polyline>
                        </svg>
                    </div>
                </button> --}}
                <!-- Show content if is open
                    <div class="p-4 pt-0"><p class="text-gray-700">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque rem aperiam, eaque ipsa quae.</p></div>
                    -->
            {{-- </div> --}}


            @foreach($posts as $post)
            <x-mary-collapse separator class="bg-white rounded-lg shadow-md mb-4">
                <x-slot:heading>
                    {{ $post->title }}
                </x-slot:heading>
                <x-slot:content>
                    {{-- {!! $post->content !!} --}}
                    {!! tiptap_converter()->asHTML($post?->content ?? '', toc: true, maxDepth: 4) !!}
                </x-slot:content>
            </x-mary-collapse>
            @endforeach

            {{-- <div class="faq-item border rounded shadow-sm">
                <button type="button" class="faq-toggle flex items-center justify-between w-full p-4 focus:outline-none">
                    <p class="text-lg font-medium">The quick, brown fox jumps over a lazy dog?</p>
                    <div class="icon-box flex items-center justify-center w-8 h-8 border rounded-full">
                        <svg viewBox="0 0 24 24" class="faq-arrow w-3 text-gray-600 transition-transform duration-200">
                            <polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-miterlimit="10" points="2,7 12,17 22,7" stroke-linejoin="round"></polyline>
                        </svg>
                    </div>
                </button>

                <div class="faq-content p-4 pt-0 hidden">
                    <p class="text-gray-700">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque rem aperiam.
                    </p>
                </div>
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
                    {{-- {!! Str::limit($post->content, 100) !!} --}}
                    {{-- {!! $post->content !!} --}}
                    {{-- {!! tiptap_converter()->asHTML($post->content) !!} --}}
                    {!! tiptap_converter()->asHTML($post?->content ?? '', toc: true, maxDepth: 4) !!}
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

    {{-- @if(config('app.debug'))
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <pre>
                Post: {{ print_r($post, true) }}
                Slug: {{ $slug }}
            </pre>
        </div>
    @endif --}}
</div>