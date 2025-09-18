<div class="pt-24">
    {{-- 判斷是單一文章頁面還是列表頁面 --}}
    @if ($post)
        {{-- 單一文章詳細頁 --}}
        {{-- <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32"> --}}
        <div class="py-8">
            <article class="bg-white">
            {{-- <article class="bg-white rounded-lg shadow-md p-6"> --}}
                {{-- <h2 class="text-3xl font-bold mb-4">{{ $post->title }}</h2> --}}
                @if($post->intro)
                    {{-- <div class="text-gray-600 mb-6">{!! $post->intro !!}</div> --}}
                    <div class="text-gray-600 mb-6">{!! tiptap_converter()->asHTML($post->intro ?? '', toc: true, maxDepth: 4) !!}</div>
                @endif
                <div class="prose max-w-none">
                    <div class="prose dark:prose-invert max-w-none">
        {!! tiptap_converter()->asHTML($post->content ?? '', toc: true, maxDepth: 4) !!}
    </div>
                </div>
            </article>
        </div>
    @else
        {{-- 文章列表頁 --}}
        @switch($menuType)
            @case('lists')
            @if ( $menu == 'news' )
                <div class="relative">
                    <img src="{{ asset('bg_news.png') }}" class="absolute inset-0 object-cover w-full h-full" alt="" />
                    <div class="relative">
                        {{-- <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20"> --}}
                        <div class="max-w-[1600px] mx-auto px-8 py-16 lg:px-32 lg:pt-52 lg:pb-12">

                        {{-- <div class="max-w-[1600px] mx-auto px-8 pt-8 lg:px-32 lg:pt-0"> --}}
                            <div class="sm:text-left">
                                <div class="flex justify-between items-center flex-wrap md:flex-nowrap gap-0 lg:gap-7">
                                    <div class="max-w-[507px]">
                                        <h2 class="mb-8 font-sans text-2xl font-black leading-none text-white sm:text-5xl">
                                            走過的痕跡
                                        </h2>
                                        <p class="text-xl text-white font-medium md:text-3xl">
                                            隨歲月推進的經驗與技術，不斷在時間軸中留下記號，也正邁向未來
                                        </p>
                                    </div>
                                    {{-- <div>
                                        <img src="{{ asset('bg_product_c.png') }}" alt="">
                                    </div> --}}
                                </div>
                            </div>

                            <div class="mx-auto pt-20 lg:pt-40">
                                <div class="flex flex-wrap justify-center gap-2">
                                    {{-- <button wire:click="selectCategory(null)" class="px-4 py-2 rounded text-sm font-medium
                                        {{ $selectedCategory === null ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                        全部
                                    </button> --}}

                                    @foreach($categories as $category)
                                        <button wire:click="selectCategory('{{ $category->slug }}')"
                                            class="px-14 py-2 rounded-3xl text-2xl font-black text-white
                                                    {{ $selectedCategory === $category->slug ? 'bg-indigo-600 text-white' : 'bg-[#fbfbfb33] text-gray-700' }}">
                                            {{ $category->title }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @endif
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                    {{-- <h2 class="text-3xl font-bold mb-6">{{ '文章列表' }}</h2> --}}
                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="container px-5 pt-12 pb-24 mx-auto flex flex-wrap gap-6 items-center lg:flex-nowrap">
                            <div class="-my-8 divide-y-2 divide-gray-100">
                                @foreach($posts as $post_item)
                                    <div class="py-8 flex flex-wrap md:flex-nowrap">
                                        <div class="md:w-64 md:mb-0 mb-6">
                                            <div>
                                                @foreach( $post_item->post_category()->get() as $category )
                                                {{-- <span class="border-gray-400 text-center border rounded-md max-w-20 px-2 tracking-widest text-sm title-font font-medium text-gray-400 mb-1">{{ $post_item->post_category->first()?->title ?? '未分類' }}</span> --}}
                                                <span class="border-gray-400 text-center border rounded-md max-w-20 px-2 py-1 text-sm title-font font-semibold text-gray-400 mb-1">{{ $category->title }}</span>
                                                @endforeach
                                            </div>
                                                <span class="text-sm text-gray-500">{{ $post_item->date }}</span>
                                        </div>
                                        <div class="md:flex-grow">
                                            <p class="text-2xl font-medium text-gray-900 title-font mb-2">{{ $post_item->title }}</p>
                                            {{-- <p class="leading-relaxed">{!! Str::limit($post_item->content, 300) !!}</p> --}}
                                            <p class="leading-relaxed">{!! Str::limit(strip_tags(tiptap_converter()->asHTML($post_item?->content ?? '')), 300) !!}</p>
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
                    {{ $posts->links() }}
                </div>
                @break

            @case('tilelists')
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
                    {{ $posts->links() }}
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
                            <div class="prose dark:prose-invert max-w-none">
                {!! tiptap_converter()->asHTML($post_item?->content ?? '', toc: true, maxDepth: 4) !!}
            </div>
                        </x-slot:content>
                    </x-mary-collapse>
                    @endforeach


                    {{-- <iframe width="560" height="315"
    src="https://www.youtube.com/embed/o-i3mqT3WwA?si=X86cirS_K-R0ky1w&amp;autoplay=1&mute=1&controls=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> --}}

    {{-- <div class="video-banner">
    <iframe width="560" height="315"
    src="https://www.youtube.com/embed/o-i3mqT3WwA?autoplay=1&mute=1&loop=1&playlist=o-i3mqT3WwA&controls=0&modestbranding=1&rel=0"
    title="YouTube video player"
    frameborder="0"
    allow="autoplay; encrypted-media"
    allowfullscreen>
</iframe>
</div> --}}

{{-- <x-yt_banner video-id="o-i3mqT3WwA"  /> --}}
<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/761577999?badge=0&amp;autoplay=0&amp;background=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" referrerpolicy="strict-origin-when-cross-origin" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="A guitar in the bucket"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>


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

