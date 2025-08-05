{{-- <section class="sec_u1 bg-[url('{{ Storage::url($images) }}')] bg-center bg-no-repeat bg-cover h-[500px]" --}}
    <section class="sec_u1 bg-center bg-no-repeat bg-cover"
    style="background-image: url('{{ Storage::url($images) }}'); height:500px;" title="">
    <div class="content_box grid mx-w-[1280px] h-full max-auto grid-cols-2 items-center w-full max-w-full">
        <figure class="col-start-1">
            <figcaption class="p-8">
                <p class="text-5xl">{{ $title }}</p>
                <p class="text-2xl">{{ $contact }}</p>
            </figcaption>
        </figure>
    </div>
</section>