<div class="pt-24">


    @if($isDetail)
                {{-- 單一產品詳情頁面 --}}
                <section class="text-gray-600 body-font overflow-hidden">
                    {{-- <div class="container px-5 py-24 mx-auto"> --}}
                    <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                        {{-- top --}}
                        <div class="lg:w-4/5 mx-auto flex flex-wrap">


                            <div x-data="productCarousel()" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded rounded-lg overflow-hidden">


                                <!-- 主要輪播 -->
                                <div class="relative" @mouseenter="showArrows = true" @mouseleave="showArrows = false">
                                    <!-- 左箭頭 -->
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

                                    <!-- 右箭頭 -->
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

                                    <!-- 輪播內容 -->
                                    <div class="carousel w-full rounded-lg shadow-xl overflow-hidden" x-ref="carousel">
                                        @forelse ($product->images as $key => $image)
                                            <div id="item{{$key + 1}}" class="carousel-item w-full">
                                                <x-curator-glider
                                                    :media="$image"
                                                    class="cursor-pointer hover:opacity-75 transition duration-300 ease-in-out"
                                                    :srcset="[
                '1000w' => 1000,
                '750w' => 750,
                '500w' => 500,
            ]"
                                                    sizes="(max-width: 768px) 100vw, 33vw"
                                                    width="600"
                                                    height="600"
                                                    fit="crop"
                                                    quality="80"
                                                    alt="{{ $image->alt ?: $product->name . ' - ' . $image->name }}"
                                                    @click="$dispatch('open-lightbox', { index: {{$key}} })"
                                                />
                                            </div>
                                            {{-- 可以在這裡顯示圖片的 alt 或 title --}}
                                            @if ($image->alt)
                                                <p class="p-2 text-sm text-gray-500">{{ $image->alt }}hoho</p>
                                            @endif
                                        @empty
                                            <p class="col-span-full text-gray-500">此產品沒有圖片。</p>
                                        @endforelse
                                    </div>
                                </div>


                                <!-- 縮圖控制按鈕 -->
                                <div class="mx-auto flex flex-wrap gap-2 mb-4 mt-2">
                                    @forelse ($product->images as $key => $image)
                                        <button
                                            @click="goToSlide({{$key}})"
                                            class="relative rounded-lg overflow-hidden border-2 transition-all duration-200"
                                            :class="currentSlideIndex === {{$key}} ? 'border-blue-500 ring-2 ring-blue-200 transform scale-105' : 'border-gray-300 hover:border-gray-400'">
                                            <x-curator-glider
                                                :media="$image"
                                                class="hover:opacity-75 transition duration-300 ease-in-out"
                                                :srcset="[
                '1000w' => 1000,
                '750w' => 750,
                '500w' => 500,
            ]"
                                                sizes="(max-width: 768px) 100vw, 33vw"
                                                width="80"
                                                height="80"
                                                fit="crop"
                                                quality="80"
                                                alt="{{ $image->alt ?: $product->name . ' - ' . $image->name }}"
                                            />
                                        </button>
                                    @empty
                                        <p class="col-span-full text-gray-500">此產品沒有圖片。</p>
                                    @endforelse
                                </div>


                            </div>






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
                                <div class="prose dark:prose-invert max-w-none">
            <p class="leading-relaxed">{!! $product->content !!}</p>
        </div>
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
                        <div class="lg:w-4/5  mx-auto tabs tabs-lift">
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


                    {{-- Lightbox --}}
                    <div id="lightbox"
                        class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden"
                        x-data="lightboxCarousel()"
                        @open-lightbox.window="openLightbox($event.detail.index)"
                        @keydown.escape="closeLightbox()"
                        @keydown.arrow-left="previousSlide()"
                        @keydown.arrow-right="nextSlide()">
                        {{-- 關閉按鈕 --}}
                        <button @click.stop="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none z-50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        {{-- 左箭頭 --}}
                        <button @click.stop="previousSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 focus:outline-none z-50">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        {{-- 右箭頭 --}}
                        <button @click.stop="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 focus:outline-none z-50">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        {{-- 圖片容器 --}}
                        <div class="relative w-full h-full flex items-center justify-center" @click.stop>
                            <template x-for="(image, index) in images" :key="index">
                                <div x-show="currentIndex === index"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute inset-0 flex items-center justify-center">
                                    <img :src="image.url" :alt="image.alt" class="max-w-full max-h-[90vh] object-contain">
                                </div>
                            </template>
                        </div>

                        {{-- 縮圖導航 --}}
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 px-4 z-50">
                            <template x-for="(image, index) in images" :key="index">
                                <button @click.stop="goToSlide(index)"
                                        class="w-16 h-16 rounded-lg overflow-hidden border-2 transition-all duration-200"
                                        :class="currentIndex === index ? 'border-white scale-110' : 'border-transparent hover:border-white'">
                                    <img :src="image.url" :alt="image.alt" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>

                        {{-- 圖片計數器 --}}
                        <div class="absolute top-4 left-4 text-white text-lg z-50">
                            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                        </div>
                    </div>

                    <script>
                        function productCarousel() {
                            return {
                                currentSlideIndex: 0,
                                showArrows: false,
                                totalSlides: {{ count($product->images) }},

                                goToSlide(index) {
                                    this.currentSlideIndex = index;
                                    const targetElement = document.getElementById(`item${index + 1}`);
                                    if (targetElement) {
                                        targetElement.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'nearest',
                                            inline: 'start'
                                        });
                                    }
                                },

                                nextSlide() {
                                    const nextIndex = (this.currentSlideIndex + 1) % this.totalSlides;
                                    this.goToSlide(nextIndex);
                                },

                                previousSlide() {
                                    const prevIndex = this.currentSlideIndex > 0
                                        ? this.currentSlideIndex - 1
                                        : this.totalSlides - 1;
                                    this.goToSlide(prevIndex);
                                },

                                init() {
                                    const carousel = this.$refs.carousel;
                                    if (carousel) {
                                        const observer = new IntersectionObserver((entries) => {
                                            entries.forEach(entry => {
                                                if (entry.isIntersecting) {
                                                    const id = entry.target.id;
                                                    const index = parseInt(id.replace('item', '')) - 1;
                                                    if (!isNaN(index)) {
                                                        this.currentSlideIndex = index;
                                                    }
                                                }
                                            });
                                        }, {
                                            root: carousel,
                                            threshold: 0.5
                                        });

                                        // 觀察所有輪播項目
                                        for (let i = 1; i <= this.totalSlides; i++) {
                                            const element = document.getElementById(`item${i}`);
                                            if (element) observer.observe(element);
                                        }
                                    }
                                }
                            }
                        }

                        function lightboxCarousel() {
                            return {
                                images: [],
                                currentIndex: 0,
                                showArrows: true,

                                init() {
                                    // 從 product images 初始化圖片陣列
                                    this.images = @json($product->images->map(function ($image) {
        return [
            'url' => $image->url,
            'alt' => $image->alt
        ];
    }));
                                },

                                openLightbox(index) {
                                    this.currentIndex = index;
                                    const lightbox = document.getElementById('lightbox');
                                    lightbox.classList.remove('hidden');
                                    document.body.style.overflow = 'hidden'; // 防止背景滾動
                                },

                                closeLightbox() {
                                    const lightbox = document.getElementById('lightbox');
                                    lightbox.classList.add('hidden');
                                    document.body.style.overflow = ''; // 恢復背景滾動
                                },

                                nextSlide() {
                                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                },

                                previousSlide() {
                                    this.currentIndex = this.currentIndex > 0
                                        ? this.currentIndex - 1
                                        : this.images.length - 1;
                                },

                                goToSlide(index) {
                                    this.currentIndex = index;
                                }
                            }
                        }
                    </script>

                </section>
    @else
        {{-- 產品列表頁面 --}}
        @if($products)
            <section class="text-gray-600 body-font">
                <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">


                    <div class="max-w-[1600px] mx-auto px-8 py-8 lg:px-32">
                        <div class="mb-6 flex flex-wrap gap-2">
                            <button wire:click="selectCategory(null)" class="px-4 py-2 rounded text-sm font-medium
                                {{ $selectedCategory === null ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                全部
                            </button>

                            @foreach($categories as $category)
                                <button wire:click="selectCategory('{{ $category->slug }}')"
                                    class="px-4 py-2 rounded text-sm font-medium
                                            {{ $selectedCategory === $category->slug ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $category->title }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- <div class="flex flex-wrap -m-4"> --}}
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($products as $product)
                            {{-- <div class="p-4 "> --}}
                                {{-- <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden"> --}}
                                <div class=" bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden">
                                    @if($product->images)
                                        @forelse ($product->images as $key => $image)
                                            @if($key == 0)
                                                <div class="h-[192px]">
                                                {{-- <div class="aspect-[4/3] bg-gray-100"> --}}
                                                    <x-curator-glider
                                                        :media="$image"
                                                        {{-- class="hover:opacity-75 transition duration-300 ease-in-out object-cover h-full" --}}
                                                        class="w-full h-full object-cover"
                                                        :srcset="[
                                '1000w' => 1000,
                                '750w' => 750,
                                '500w' => 500,
                            ]"
                                                        sizes="(max-width: 768px) 100vw, 33vw"
                                                        {{-- width="100%" --}}
                                                        {{-- height="100%" --}}
                                                        fit="crop"
                                                        quality="80"
                                                        alt="{{ $image->alt ?: $product->name . ' - ' . $image->name }}"/>
                                                </div>
                                            @endif
                                        @empty
                                        <div>
                                            <p class="col-span-full text-gray-500">此產品沒有圖片。</p>
                                        </div>
                                        @endforelse
                                    @else
                                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://dummyimage.com/720x400" alt="blog">
                                    @endif
                                    <div class="p-6">
                                        <p class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ $product->product_category->pluck('title')->implode(', ') }}</p>
                                        <h2 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $product->title }}</h2>
                                        <div class="leading-relaxed mb-3 max-w-[380px] max-h-20 overflow-hidden">{!! Str::limit($product->content, 200) !!}</div>
                                        {{-- <div class="leading-relaxed mb-3 max-w-[380px] max-h-20 overflow-hidden">{{ Str::limit(strip_tags($product->content), 200) }}</div> --}}
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
                                    {{-- <div class="p-5 flex flex-col flex-grow">
                                        <p class="text-xs text-indigo-500 font-medium uppercase mb-2">分類名稱</p>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->title }}</h3>
                                        <div class="text-sm text-gray-600 mb-4 line-clamp-3">
                                            {!! Str::limit($product->content, 200) !!}
                                        </div>
                                        <div class="mt-auto flex items-center flex-wrap">
                                            <a href="{{ route('product.detail', ['locale' => app()->getLocale(), 'product' => $product->slug]) }}"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                                查看更多
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                            <span
                                                class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-200">
                                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>1.2K
                                            </span>
                                            <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <path
                                                        d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                                    </path>
                                                </svg>6
                                            </span>
                                        </div>
                                    </div> --}}
                                </div>
                            {{-- </div> --}}
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
