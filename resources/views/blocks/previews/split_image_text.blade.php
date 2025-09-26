<section class="" style="
        @if(!empty($bg_color)) background-color: {{ $bg_color }}; @endif
        @if(!empty($bg_image)) background-image: url('{{ Storage::url($bg_image) }}'); background-size: cover; background-position: center; @endif
    ">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap sm:flex-nowrap gap-8">

            <div class="">
                <img alt="content" class="object-cover object-center h-full w-full inline-block"
                    src="{{ Storage::url($image_l) }}">
            </div>

            <div class="">
                <div class="">
                    <img alt="content" class="object-cover object-center h-full w-full inline-block"
                        src="{{ Storage::url($image_r) }}">
                </div>
                <p class="">{!! $title !!}</p>
                <p class="">{!! $contact !!}</p>
            </div>
        </div>
    </div>
</section>
