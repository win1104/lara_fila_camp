<div>
    @if($isDetail)
        {{-- 單一產品詳情頁面 --}}
        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container px-5 py-24 mx-auto">
                {{-- top --}}
                <div class="lg:w-4/5 mx-auto flex flex-wrap">



<div x-data="{
    currentSlideIndex: 0,
    jumpTo: 1,
    showArrows: false,
    slides: [
        {
            id: 'item1',
            image: 'https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp',
            title: '圖片 1'
        },
        {
            id: 'item2',
            image: 'https://img.daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.webp',
            title: '圖片 2'
        },
        {
            id: 'item3',
            image: 'https://img.daisyui.com/images/stock/photo-1414694762283-acccc27bca85.webp',
            title: '圖片 3'
        },
        {
            id: 'item4',
            image: 'https://img.daisyui.com/images/stock/photo-1665553365602-b2fb8e5d1707.webp',
            title: '圖片 4'
        }
    ],
    goToSlide(index) {
        this.currentSlideIndex = index;
        this.jumpTo = index + 1;
        // 滾動到指定的圖片
        const targetElement = document.getElementById(this.slides[index].id);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'start'
            });
        }
    },
    nextSlide() {
        const nextIndex = (this.currentSlideIndex + 1) % this.slides.length;
        this.goToSlide(nextIndex);
    },
    previousSlide() {
        const prevIndex = this.currentSlideIndex > 0
            ? this.currentSlideIndex - 1
            : this.slides.length - 1;
        this.goToSlide(prevIndex);
    },
    init() {
        // 監聽滾動事件來更新當前索引
        const carousel = this.$refs.carousel;
        if (carousel) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const index = this.slides.findIndex(slide =>
                            slide.id === entry.target.id
                        );
                        if (index !== -1) {
                            this.currentSlideIndex = index;
                            this.jumpTo = index + 1;
                        }
                    }
                });
            }, {
                root: carousel,
                threshold: 0.5
            });

            // 觀察所有 carousel item
            this.slides.forEach(slide => {
                const element = document.getElementById(slide.id);
                if (element) observer.observe(element);
            });
        }
    }
}">
    <!-- 縮圖控制按鈕 -->
    <div class="grid grid-cols-4 gap-2 mb-4">
        <template x-for="(slide, index) in slides" :key="index">
            <button
                @click="goToSlide(index)"
                class="relative aspect-video rounded-lg overflow-hidden border-2 transition-all duration-200"
                :class="currentSlideIndex === index
                    ? 'border-blue-500 ring-2 ring-blue-200 transform scale-105'
                    : 'border-gray-300 hover:border-gray-400'">
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center transition-all duration-200"
                     :class="currentSlideIndex === index ? 'bg-blue-500 bg-opacity-30' : 'bg-black bg-opacity-20 hover:bg-opacity-10'">
                    <span class="text-white font-bold text-lg" x-text="index + 1"></span>
                </div>
                <!-- 選中指示器 -->
                <div x-show="currentSlideIndex === index"
                     class="absolute top-2 right-2 bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                    ✓
                </div>
            </button>
        </template>
    </div>

    <!-- 數字按鈕控制 -->
    <div class="flex gap-2 mb-4 justify-center">
        <template x-for="(slide, index) in slides" :key="index">
            <button
                @click="goToSlide(index)"
                class="w-12 h-12 rounded-full transition-all duration-200 font-bold text-lg border-2 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-300"
                :class="currentSlideIndex === index
                    ? 'bg-blue-500 text-white border-blue-500 shadow-lg transform scale-110'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                x-text="index + 1">
            </button>
        </template>
    </div>

    <!-- 方向控制按鈕 -->
    <div class="flex gap-3 mb-4 justify-center">
        <button
            @click="previousSlide()"
            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            上一張
        </button>

        <button
            @click="nextSlide()"
            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
            下一張
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- 快速跳轉輸入 -->
    <div class="flex items-center gap-2 mb-4 justify-center">
        <label class="text-sm font-medium text-gray-700">快速跳轉:</label>
        <input
            type="number"
            x-model="jumpTo"
            min="1"
            :max="slides.length"
            class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            @keyup.enter="goToSlide(Math.max(0, Math.min(parseInt(jumpTo) - 1, slides.length - 1)))">
        <button
            @click="goToSlide(Math.max(0, Math.min(parseInt(jumpTo) - 1, slides.length - 1)))"
            class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition-colors duration-200 text-sm font-medium">
            GO
        </button>
    </div>

    <!-- 當前狀態顯示 -->
    <div class="mb-4 text-center">
        <div class="text-sm text-gray-600 mb-2">
            當前圖片: <span x-text="currentSlideIndex + 1" class="font-bold text-blue-600"></span> / <span x-text="slides.length" class="font-bold"></span>
        </div>

        <!-- 進度條 -->
        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
            <div class="bg-blue-500 h-2 rounded-full transition-all duration-500 ease-out"
                 :style="`width: ${((currentSlideIndex + 1) / slides.length) * 100}%`"></div>
        </div>

        <!-- 圓點指示器 -->
        <div class="flex justify-center gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button
                    @click="goToSlide(index)"
                    class="w-3 h-3 rounded-full transition-all duration-200"
                    :class="currentSlideIndex === index
                        ? 'bg-blue-500 transform scale-125'
                        : 'bg-gray-300 hover:bg-gray-400'">
                </button>
            </template>
        </div>
    </div>

    <!-- DaisyUI Carousel with Hover Arrows -->
    <div class="relative"
         @mouseenter="showArrows = true"
         @mouseleave="showArrows = false">

        <!-- Left Arrow (懸停時顯示) -->
        <button
            @click="previousSlide()"
            x-show="showArrows"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-x-2"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform -translate-x-2"
            class="absolute left-3 top-1/2 transform -translate-y-1/2 z-10
                   bg-white bg-opacity-90 hover:bg-opacity-100 text-gray-800
                   rounded-full w-12 h-12 flex items-center justify-center
                   shadow-lg hover:shadow-xl transition-all duration-200
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                   hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Right Arrow (懸停時顯示) -->
        <button
            @click="nextSlide()"
            x-show="showArrows"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform translate-x-2"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-2"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 z-10
                   bg-white bg-opacity-90 hover:bg-opacity-100 text-gray-800
                   rounded-full w-12 h-12 flex items-center justify-center
                   shadow-lg hover:shadow-xl transition-all duration-200
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                   hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- DaisyUI Carousel -->
        <div class="carousel w-full rounded-lg shadow-xl overflow-hidden" x-ref="carousel">
            <div id="item1" class="carousel-item w-full">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp"
                    class="w-full h-96 object-cover" />
            </div>
            <div id="item2" class="carousel-item w-full">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.webp"
                    class="w-full h-96 object-cover" />
            </div>
            <div id="item3" class="carousel-item w-full">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1414694762283-acccc27bca85.webp"
                    class="w-full h-96 object-cover" />
            </div>
            <div id="item4" class="carousel-item w-full">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1665553365602-b2fb8e5d1707.webp"
                    class="w-full h-96 object-cover" />
            </div>
        </div>
    </div>
</div>













                    @forelse ($product->images as $image)
                        <div class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded border rounded-lg overflow-hidden shadow-md">
                            {{-- Curator 的 Media 模型有一個 getUrl() 方法可以取得圖片的 URL --}}
                            {{-- <img src="{{ $image->getUrl() }}" alt="{{ $image->alt }}"
                                class="w-full h-48 object-cover cursor-pointer hover:opacity-75 transition duration-300 ease-in-out"
                                onclick="openLightbox('{{ $image->getUrl() }}')"> --}}


                                {{-- 使用 <x-curator-glider> 元件 --}}
                                <x-curator-glider
                                    :media="$image"        {{-- 傳遞單個 Media 物件 --}}
                                    class="cursor-pointer hover:opacity-75 transition duration-300 ease-in-out"
                                    :srcset="[              {{-- 可選：響應式圖片設定 (srcset) --}}
                                        '1000w' => 1000,
                                        '750w' => 750,
                                        '500w' => 500,
                                    ]"
                                    sizes="(max-width: 768px) 100vw, 33vw" {{-- 可選：Sizes 屬性 --}}
                                    width="600"             {{-- 可選：圖片寬度 --}}
                                    height="600"            {{-- 可選：圖片高度 --}}
                                    fit="crop"             {{-- 可選：圖片適合方式 (cover, contain, fill, crop, stretch) --}}
                                    quality="80"            {{-- 可選：圖片品質 (0-100) --}}
                                    alt="{{ $image->alt ?: $product->name . ' - ' . $image->name }}" {{-- 圖片 alt 屬性 --}}
                                    onclick="openLightbox('{{ $image->url }}')" {{-- Lightbox 仍然可以使用原始 URL --}}
                                />
                            {{-- 可以在這裡顯示圖片的 alt 或 title --}}
                            @if ($image->alt)
                                <p class="p-2 text-sm text-gray-500">{{ $image->alt }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="col-span-full text-gray-500">此產品沒有圖片。</p>
                    @endforelse

                    {{-- @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-96 object-cover">
                        <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                    @else
                        <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="https://dummyimage.com/600x600">

                    @endif --}}
                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">BRAND NAME</h2>
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->title }}</h1>
                        <div class="flex mb-4">
                            <span class="flex items-center">
                                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                                <span class="text-gray-600 ml-3">4 Reviews</span>
                            </span>
                            <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
                                <a class="text-gray-500">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                    </svg>
                                </a>
                                <a class="text-gray-500">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                                    </svg>
                                </a>
                                <a class="text-gray-500">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <p class="leading-relaxed">{!! $product->content !!}</p>
                        <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-300 mb-5">
                            <div class="flex">
                                <span class="mr-3">Color</span>
                                <button class="border-2 border-gray-300 rounded-full w-6 h-6 focus:outline-none"></button>
                                <button class="border-2 border-gray-300 ml-1 bg-gray-700 rounded-full w-6 h-6 focus:outline-none"></button>
                                <button class="border-2 border-gray-300 ml-1 bg-indigo-500 rounded-full w-6 h-6 focus:outline-none"></button>
                            </div>
                            <div class="flex ml-6 items-center">
                                <span class="mr-3">Size</span>
                                <div class="relative">
                                    <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                        <option>SM</option>
                                        <option>M</option>
                                        <option>L</option>
                                        <option>XL</option>
                                    </select>
                                    <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <span class="title-font font-medium text-2xl text-gray-900">$58.00 {{ number_format($product->tag, 0) }}</span>
                            <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Button</button>
                            <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>



                {{-- tabs --}}
                <div class="tabs tabs-lift">
                    <input type="radio" name="my_tabs_3" class="tab" aria-label="Tab 1" />
                    <div class="tab-content bg-base-100 border-base-300 p-6">Tab content 1</div>

                    <input type="radio" name="my_tabs_3" class="tab" aria-label="Tab 2" checked="checked" />
                    <div class="tab-content bg-base-100 border-base-300 p-6">Tab content 2</div>

                    <input type="radio" name="my_tabs_3" class="tab" aria-label="Tab 3" />
                    <div class="tab-content bg-base-100 border-base-300 p-6">Tab content 3</div>
                </div>
            </div>



            <a href="{{ url()->previous() }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                &larr; 回到上一頁
            </a>

            {{-- 簡易 Lightbox 範例 (可替換為實際的 JS 套件) --}}
            <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden" onclick="closeLightbox()">
                <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[90%] rounded-lg shadow-xl">
            </div>
            <script>
                function openLightbox(imageUrl) {
                    document.getElementById('lightbox-img').src = imageUrl;
                    document.getElementById('lightbox').classList.remove('hidden');
                }

                function closeLightbox() {
                    document.getElementById('lightbox').classList.add('hidden');
                    document.getElementById('lightbox-img').src = '';
                }
            </script>

        </section>
    @else
        {{-- 產品列表頁面 --}}
        @if($products)
            <section class="text-gray-600 body-font">
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap -m-4">
                        @foreach($products as $product)
                            <div class="p-4 md:w-1/3">
                                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                    @if($product->image)
                                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                                    @else
                                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://dummyimage.com/720x400" alt="blog">
                                        {{-- <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                            無圖片
                                        </div> --}}
                                    @endif
                                    <div class="p-6">
                                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">CATEGORY</h2>
                                        <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $product->title }}</h1>
                                        <p class="leading-relaxed mb-3">{!! Str::limit($product->content, 200) !!}</p>
                                        <div class="flex items-center flex-wrap ">
                                            <a href="{{ route('product.detail', ['locale' => app()->getLocale(), 'product' => $product->slug]) }}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                                                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14"></path>
                                                <path d="M12 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                            <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-200">
                                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                                </svg>1.2K
                                            </span>
                                            <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                                </svg>6
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            {{-- @foreach($products as $product)
                <div class="border rounded-lg shadow-lg overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            無圖片
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $product->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $product->content }}</p>
                        <p class="text-lg font-bold text-blue-600">NT$ {{ number_format($product->tag, 0) }}</p>
                        <a href="{{ route('product.detail', ['locale' => app()->getLocale(), 'product' => $product->slug]) }}" class="mt-4 block w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                            查看詳情
                        </a>
                    </div>
                </div>
            @endforeach --}}
        @else
            <p class="col-span-full text-center text-gray-500">目前沒有找到產品。</p>
        @endif



    @endif
</div>

{{-- 您可能需要引入 Tailwind CSS 來使上述樣式生效 --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
