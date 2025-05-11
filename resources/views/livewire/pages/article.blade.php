<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <article class="prose p-6">
                <h1>
                    {{ $article?->title }}
                </h1>

                <img class="rounded-lg" src="/storage/{{ $article?->image->path }}" alt="{{ $article?->image->alt_text }}"/>
                <small>{{ $article?->image->caption }}</small>
                <div class="">
                    {!! $article?->content !!}
                </div>
            </article>
        </div>
    </div>
</div>