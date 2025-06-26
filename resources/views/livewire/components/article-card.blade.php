{{-- <x-mary-card>
    <a class="group max-h-[450px] flex flex-col h-full border border-gray-200 hover:border-transparent hover:shadow-lg transition-all duration-300 rounded-xl p-5 dark:border-neutral-700 dark:hover:border-transparent dark:hover:shadow-black/40"
        wire:navigate
        href="{{ route('article.show', $article) }}">
        <div class="aspect-w-16 aspect-h-11">
            <img class="w-full object-cover rounded-xl" src="/storage/{{ $article?->image?->path }}"
                alt="{{  $article?->image?->alt_text }}"/>
        </div>
        <div class="my-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:group-hover:text-white">
                {{ $article->title }}
            </h3>
            @if ($article->content)
                <p class="mt-5 text-gray-600 dark:text-neutral-400">
                    {!! Str::limit( $article->content, 100 )!!}
                    {!! Str::limit(tiptap_converter()->asText($article?->content, 100)) !!}
                </p>
            @endif
        </div>
        <div class="mt-auto flex items-center gap-x-3">
            <img class="size-8 rounded-full" src="{{ $article?->user?->profile_photo_url }}" alt="Image Description">
            <div>
                <h5 class="text-sm text-gray-800 dark:text-neutral-200">By William {{ $article?->user?->name }}</h5>
            </div>
        </div>
    </a>
</x-mary-card> --}}

<a href="{{ route('article.show', ['locale' => app()->getLocale(), 'articles' => $article]) }}">
    <x-mary-card title="{!! $article->title !!}" class="shadow-lg p-6 h-full">

        <div class="min-h-[72px] flex-grow">
            {!! Str::limit($article->content, 100)!!}
        </div>

        <x-slot:figure class="">
            <img class="overflow-hidden h-64 object-cover w-full" src="/storage/{{ $article?->image?->path }}" />
            {{-- <img src="https://picsum.photos/500/400" /> --}}
        </x-slot:figure>
        <x-slot:menu>
            {{-- <x-mary-badge value="NEW" class="badge-primary" /> --}}
            <x-mary-button icon="o-share" class="btn-circle btn-sm" />
            <x-mary-icon name="o-heart" class="cursor-pointer" />
        </x-slot:menu>
        <x-slot:actions separator class="">
            <x-mary-badge value="Products" class="badge-soft"/>
        </x-slot:actions>
    </x-mary-card>
</a>

{{-- Card with badge --}}
{{-- <div class="card bg-base-100 w-96 shadow-sm">
    <figure>
        <img
        src="/storage/{{ $article?->image?->path }}"
        alt="{{ $article->title }}" />
    </figure>
    <div class="card-body">
        <h2 class="card-title">
            {{ $article->title }}
            <div class="badge badge-secondary">NEW</div>
        </h2>
        <p>{!! Str::limit( $article->content, 100 )!!}</p>
        <div class="card-actions justify-end">
        <div class="badge badge-outline">Fashion</div>
        <div class="badge badge-outline">Products</div>
        </div>
    </div>
</div> --}}
