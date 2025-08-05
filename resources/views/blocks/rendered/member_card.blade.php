<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-2">
            @foreach ($cards as $card)
                <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
                    <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg">
                        <img alt="team"
                            class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                            src="{{ Storage::url($card['image']) }}">
                        <div class="flex-grow">
                            <p class="text-gray-900 title-font font-medium">{{ $card['title'] }}</p>
                            <p class="text-gray-500">{{ $card['contact'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>