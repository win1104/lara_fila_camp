<section class="" style="
        @if(!empty($bg_color)) background-color: {{ $bg_color }}; @endif
        @if(!empty($bg_image)) background-image: url('{{ Storage::url($bg_image) }}'); background-size: cover; background-position: center; @endif
    ">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap sm:flex-nowrap justify-center gap-8">

            <div class="">
                <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">{!! $title_l !!}</h2>
                <p class="leading-relaxed text-base">{!! $contact_l !!}</p>
                <div class="">
                    <img alt="content" class="object-cover object-center h-full w-full" src="{{ Storage::url($image_l) }}">
                </div>
            </div>

            <div class="">
                <div class="">
                    <img alt="content" class="object-cover object-center h-full w-full" src="{{ Storage::url($image_c) }}">
                </div>
                <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">{!! $title_c !!}</h2>
                <p class="leading-relaxed text-base">{!! $contact_c !!}</p>
            </div>

            <div class="">
                <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">{!! $title_r !!}</h2>
                <p class="leading-relaxed text-base">{!! $contact_r !!}</p>
                <div class="">
                    <img alt="content" class="object-cover object-center h-full w-full" src="{{ Storage::url($image_r) }}">
                </div>
            </div>


        </div>
    </div>
</section>
