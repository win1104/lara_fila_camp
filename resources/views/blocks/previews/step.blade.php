<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
        @foreach ($steps as $key => $step)
            <div class="flex relative pt-10 pb-20 sm:items-center md:w-2/3 mx-auto">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                </div>
                <div
                    class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-indigo-500 text-white relative z-10 title-font font-medium text-sm">
                    {{ $key + 1 }}</div>
                <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div
                        class="flex-shrink-0 w-24 h-24 bg-indigo-100 text-indigo-500 rounded-full inline-flex items-center justify-center">
                        <img src="{{ Storage::url($step['image']) }}" class="w-12 h-12">
                    </div>
                    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                        <p class="font-medium title-font text-gray-900 mb-1 text-xl">{{ $step['title'] }}</p>
                        <p class="leading-relaxed">{{ $step['contact'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>