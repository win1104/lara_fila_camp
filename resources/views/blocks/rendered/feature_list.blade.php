{{-- <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        @foreach ($features as $key => $feature)
            @if ($key % 2 === 0)
                <div class="flex items-center lg:w-3/5 mx-auto border-b pb-10 mb-10 border-gray-200 sm:flex-row flex-col">
                    <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
                        <p class="text-gray-900 text-lg title-font font-medium mb-2">{{ $feature['title'] }}</p>
                        <p class="leading-relaxed text-base">{{ $feature['contact'] }}</p>

                    </div>
                    <div
                        class="sm:w-32 sm:order-none order-first sm:h-32 h-20 w-20 sm:mr-10 inline-flex items-center justify-center rounded-full flex-shrink-0">
                        <img class="rounded w-full object-cover object-center mb-6" src="{{ Storage::url($feature['image']) }}"
                            alt="content">
                    </div>
                </div>
            @else
                <div class="flex items-center lg:w-3/5 mx-auto border-b pb-10 mb-10 border-gray-200 sm:flex-row flex-col">
                    <div
                        class="sm:w-32 sm:h-32 h-20 w-20 sm:ml-10 inline-flex items-center justify-center rounded-full flex-shrink-0">
                        <img class="rounded w-full object-cover object-center mb-6" src="{{ Storage::url($feature['image']) }}"
                            alt="content">
                    </div>
                    <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
                        <p class="text-gray-900 text-lg title-font font-medium mb-2">{{ $feature['title'] }}</p>
                        <p class="leading-relaxed text-base">{{ $feature['contact'] }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section> --}}


<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        @foreach ($features as $key => $feature)
            <div class="flex flex-col sm:flex-row items-center lg:w-3/5 mx-auto border-b pb-10 mb-10 border-gray-200">

                {{-- 圖片區塊（小螢幕都在上） --}}
                <div class="sm:w-32 sm:h-32 h-20 w-20 flex-shrink-0 rounded-full inline-flex items-center justify-center mb-6 sm:mb-0
              {{ $key % 2 === 0 ? 'sm:order-1 sm:mr-6' : 'sm:order-2 sm:ml-6' }}">
                    <img class="rounded w-full object-cover object-center" src="{{ Storage::url($feature['image']) }}"
                        alt="content">
                </div>

                {{-- 文字區塊 --}}
                <div class="flex-grow text-center sm:text-left
              {{ $key % 2 === 0 ? 'sm:order-2' : 'sm:order-1' }}">
                    <p class="text-gray-900 text-lg title-font font-medium mb-2">
                        {{ $feature['title'] }}
                    </p>
                    <p class="leading-relaxed text-base">
                        {{ $feature['contact'] }}
                    </p>
                </div>

            </div>
        @endforeach
    </div>
</section>



