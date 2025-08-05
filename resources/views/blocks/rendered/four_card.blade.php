<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">

        <div class="flex flex-wrap -m-4">
            @foreach ($cards as $card)
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-100 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ Storage::url($card['image']) }}"
                            alt="content">

                        <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $card['title'] }}</h2>
                        <p class="leading-relaxed text-base">{{ $card['contact'] }}</p>
                    </div>
                </div>
            @endforeach
            {{-- <div class="xl:w-1/4 md:w-1/2 p-4">
                <div class="bg-gray-100 p-6 rounded-lg">
                    <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ Storage::url($images2) }}"
                        alt="content">

                    <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $title2 }}</h2>
                    <p class="leading-relaxed text-base">{{ $contact2 }}</p>
                </div>
            </div>
            <div class="xl:w-1/4 md:w-1/2 p-4">
                <div class="bg-gray-100 p-6 rounded-lg">
                    <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ Storage::url($images3) }}"
                        alt="content">

                    <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $title3 }}</h2>
                    <p class="leading-relaxed text-base">{{ $contact3 }}</p>
                </div>
            </div>
            <div class="xl:w-1/4 md:w-1/2 p-4">
                <div class="bg-gray-100 p-6 rounded-lg">
                    <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ Storage::url($images4) }}"
                        alt="content">

                    <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $title4 }}</h2>
                    <p class="leading-relaxed text-base">{{ $contact4 }}</p>
                </div>
            </div> --}}
        </div>
    </div>
</section>