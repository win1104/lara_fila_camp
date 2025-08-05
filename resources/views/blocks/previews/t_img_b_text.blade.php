<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-col">
        <div class="lg:w-4/6 mx-auto">
            <div class="rounded-lg h-64 overflow-hidden">
                <img alt="content" class="object-cover object-center h-full w-full"
                    src="{{ Storage::url($images) }}">
            </div>
            <div class="flex flex-col text-center w-full mb-20 py-8">
                <h2 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $title }}</h2>
                <p class="mx-auto leading-relaxed text-base">{{ $contact }}</p>
            </div>
        </div>
    </div>
</section>