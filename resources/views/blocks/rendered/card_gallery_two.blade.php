<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -mx-4 -mb-10 text-center">
            @foreach ($galleries as $gallery)
                <div class="sm:w-1/2 mb-10 px-4">
                    <div class="rounded-lg h-64 overflow-hidden">
                        <img alt="content" class="object-cover object-center h-full w-full" src="{{ Storage::url($gallery['image']) }}">
                    </div>
                    <p class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">{{ $gallery['title'] }}</p>
                    <p class="leading-relaxed text-base">{{ $gallery['contact'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
