<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="grid gap-4" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
            @foreach ($galleries as $gallery)
                <div class=" group">
                    <img src="{{ Storage::url($gallery['image']) }}" class="w-9/12 h-1/2 object-cover rounded-md" />
                    <div
                        class=" inset-0 bg-white bg-opacity-10 transition duration-300 flex items-center justify-center p-6 border-4 border-gray-200">
                        <div class="text-center">
                            <h3 class="tracking-widest text-sm title-font font-medium text-indigo-500 mb-1" style="color:#6366f1;">{{ $gallery['subtitle'] }}</h3>
                            <h2 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $gallery['title'] }}</h2>
                            <p class="leading-relaxed text-sm">{{ $gallery['contact'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>