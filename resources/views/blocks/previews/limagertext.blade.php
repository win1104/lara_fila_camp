<div>
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center gap-8">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                <img src="{{ Storage::url($images) }}" class="object-cover object-center rounded" alt="hero">
            </div>
            <div
                class="lg:flex-grow md:w-1/2 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                <h2 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                    {{ $title }}
                </h2>
                <p class="mb-8 leading-relaxed">{{ $contact }}</p>
            </div>
        </div>
    </section>
</div>