{{-- @php
use Illuminate\Support\Facades\Storage;
@endphp --}}

<div>
<section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
        <div
            class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                {{ $title }}
                {{-- <br class="hidden lg:inline-block"> --}}
            </h1>
            <p class="mb-8 leading-relaxed">{{ $contact }}</p>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            {{-- @if (!empty($images) && isset($images[0]['image'])) --}}
            {{-- {{ print_r($images, true) }} --}}
            {{-- @dd($images); --}}
                <img src="{{ Storage::url($images) }}" class="object-cover object-center rounded w-1/2" alt="hero">
                {{-- <img src="{{ Storage::url($images[0]['image']) }}" class="object-cover object-center rounded" alt="hero"> --}}
            {{-- @endif --}}
            {{-- <img class="object-cover object-center rounded" alt="hero" src="https://dummyimage.com/720x600"> --}}
        </div>
    </div>
</section>
</div>