<div class="pt-24">
    {{-- 判斷是單一文章頁面還是列表頁面 --}}
    @if ($post)
        {{-- 單一文章詳細頁 --}}
        <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
            <article class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-3xl font-bold mb-4">{{ $post->title }}</h2>
                @if($post->intro)
                    <div class="text-gray-600 mb-6">{!! $post->intro !!}</div>
                @endif
                <div class="prose max-w-none">
                    {!! tiptap_converter()->asHTML($post->content ?? '', toc: true, maxDepth: 4) !!}
                </div>
            </article>
        </div>
    @else
        {{-- 文章列表頁 --}}
        @switch($menuType)
            @case('lists')
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                    <h2 class="text-3xl font-bold mb-6">{{ '文章列表' }}</h2>
                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="container px-5 py-24 mx-auto flex flex-wrap gap-6 justify-center items-center lg:flex-nowrap">
                            <div class="-my-8 divide-y-2 divide-gray-100">
                                @foreach($posts as $post_item)
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                                            <span class="font-semibold title-font text-gray-700">{{ $post_item->categories->first()?->title ?? '未分類' }}</span>
                                            <span class="text-sm text-gray-500">{{ $post_item->date }}</span>
                                        </div>
                                        <div class="md:flex-grow">
                                            <p class="text-2xl font-medium text-gray-900 title-font mb-2">{{ $post_item->title }}</p>
                                            <p class="leading-relaxed">{!! Str::limit($post_item->content, 300) !!}</p>
                                            <a href="{{ url(app()->getLocale() . '/lists/news/' . $post_item->slug) }}" class="text-indigo-500 inline-flex items-center mt-4">Learn More
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
                @break

            @case('grid')
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class=" py-24 grid  gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($posts as $post_item)
                                <x-mary-card title="{{ $post_item->title }}" class="bg-white rounded-lg shadow-md h-[424px]">
                                    {!! Str::limit($post_item->content, 100) !!}
                                    <x-slot:figure>
                                        <img src="https://picsum.photos/500/200" />
                                    </x-slot:figure>
                                    <x-slot:menu>
                                        <x-mary-button icon="o-share" class="btn-circle btn-sm" />
                                        <x-mary-icon name="o-heart" class="cursor-pointer" />
                                    </x-slot:menu>
                                    <x-slot:actions separator>
                                        <x-mary-button label="詳細內容" class="btn-success" link="/tw/post/{{ $post_item->menu_slug }}/{{ $post_item->slug }}" />
                                    </x-slot:actions>
                                </x-mary-card>
                            @endforeach
                        </div>
                    </section>
                </div>
                @break

            @case('timeline')
                <div class="max-w-[1600px] mx-auto px-8 py-24 lg:px-32">
                    <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical">
                        @foreach($posts as $index => $post_item)
                            <li>
                                <hr />
                                <div class="timeline-middle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @if ($index % 2 === 0)
                                    <div class="timeline-start mb-10 md:text-end">
                                @else
                                    <div class="timeline-end md:mb-10">
                                @endif
                                        <time class="font-mono italic">{{ \Carbon\Carbon::parse($post_item->date)->year }}</time>
                                        <div class="text-lg font-black">{{ $post_item->title }}</div>
                                        {!! Str::limit($post_item->content, 300) !!}
                                    </div>
                                <hr />
                            </li>
                        @endforeach
                    </ul>
                </div>
                @break

            @case('tabs')
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                    <h2 class="text-center text-3xl font-bold mb-12">{{ $posts->first()?->menu?->title ?? '文章列表' }}</h2>
                    <div>
                        <div class="flex mb-12 justify-center gap-4">
                            @foreach($posts as $index => $post_item)
                                <button wire:click="$set('activeTab', 'tab-{{ $index }}')"
                                    class="px-4 py-2 border rounded-3xl {{ $activeTab === 'tab-' . $index ? 'bg-blue-600 text-white' : 'bg-white' }}">
                                    {{ $post_item->title }}
                                </button>
                            @endforeach
                        </div>

                        <div class="p-4">
                            @foreach($posts as $index => $post_item)
                                @if($activeTab === 'tab-' . $index)
                                    <div>
                                        {!! $post_item->content !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @break

            @case('collapses')
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                    <h2 class="text-center text-3xl font-bold mb-12">{{ $posts->first()?->menu?->title ?? '文章列表' }}</h2>
                    @foreach($posts as $post_item)
                    <x-mary-collapse separator class="bg-white rounded-lg shadow-md mb-4">
                        <x-slot:heading>
                            {{ $post_item->title }}
                        </x-slot:heading>
                        <x-slot:content>
                            {!! tiptap_converter()->asHTML($post_item?->content ?? '', toc: true, maxDepth: 4) !!}
                        </x-slot:content>
                    </x-mary-collapse>
                    @endforeach
                </div>
                @break

            @default
                {{-- 預設列表樣式 --}}
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                    @foreach($posts as $post_item)
                        <article class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h2 class="text-3xl font-bold mb-4">{{ $post_item->title }}</h2>
                            @if($post_item->intro)
                                <div class="text-gray-600 mb-6">{!! $post_item->intro !!}</div>
                            @endif
                            <div class="prose max-w-none">
                                {!! Str::limit(strip_tags($post_item->content), 300) !!}
                            </div>
                             <a href="{{ url(app()->getLocale() . '/lists/news/' . $post_item->slug) }}" class="text-indigo-500 inline-flex items-center mt-4">Learn More
                                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </article>
                    @endforeach
                </div>
        @endswitch
    @endif
</div>

