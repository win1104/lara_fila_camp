<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-20">

      <p class="text-2xl font-medium title-font mb-4 text-gray-900">{{ $headline }}</p>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $abstract }}</p>
    </div>
    <div class="flex flex-wrap -m-4">
    @foreach ($galleries as $gallery)
        <div class="p-4 lg:w-1/4 md:w-1/2">
            <div class="h-full flex flex-col items-center text-center">
            <img alt="team" class="flex-shrink-0 rounded-lg w-1/2 h-1/2 object-cover object-center mb-4" src="{{ Storage::url($gallery['image']) }}">
            <div class="w-full">
                <p class="title-font font-medium text-lg text-gray-900">{{ $gallery['title'] }}</p>
                <p class="text-gray-500 mb-3">{{ $gallery['subtitle'] }}</p>
                <p class="mb-4">{{ $gallery['contact'] }}</p>
            </div>
            </div>
        </div>
    @endforeach
    </div>
  </div>
</section>
