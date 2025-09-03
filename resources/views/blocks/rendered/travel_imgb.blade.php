{{-- @php
use Illuminate\Support\Facades\Storage;
@endphp --}}

<div>
<section class="text-gray-600 body-font">
    <div class="container mx-auto px-5 py-24">
        <div
            class="sm:flex justify-evenly md:text-left mb-16 md:mb-0 items-center px-20 sm:gap-20">
            <div style="flex: 1;">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                {!! $title !!}
            </h1>
            </div>
            <div style="flex: 1;">
            <p class="mb-8 leading-relaxed">{{ $contact }}</p>
            </div>
        </div>
        {{-- <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 flex gap-4"> --}}
        <div class="md:grid grid-cols-4 gap-4 mx-auto">
                <img src="{{ Storage::url($images) }}" class="object-cover object-center rounded w-full" alt="hero">
                <img src="{{ Storage::url($images2) }}" class="object-cover object-center rounded w-full" alt="hero">
                <img src="{{ Storage::url($images3) }}" class="object-cover object-center rounded w-full" alt="hero">
                <img src="{{ Storage::url($images4) }}" class="object-cover object-center rounded w-full" alt="hero">
        </div>
    </div>
</section>
</div>
