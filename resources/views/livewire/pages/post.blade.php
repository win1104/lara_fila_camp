<div>
    @if($isList)
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">{{ $posts->first()->menu->title }}</h1>
            <div class="grid gap-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                        @if($post->intro)
                            <p class="text-gray-600 mb-4">{{ $post->intro }}</p>
                        @endif
                        <a href="{{ route('post.show', ['locale' => app()->getLocale(), 'type' => 'post', 'menu' => $post->menu_slug]) }}"
                           class="text-blue-600 hover:text-blue-800">
                            {{ __('Read More') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="container mx-auto px-4 py-8">
            <article class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                @if($post->intro)
                    <div class="text-gray-600 mb-6">{{ $post->intro }}</div>
                @endif
                <div class="prose max-w-none">
                    {!! $post->content !!}
                </div>
            </article>
        </div>
    @endif

    @if(config('app.debug'))
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <pre>
                Post: {{ print_r($post, true) }}
                Slug: {{ $slug }}
            </pre>
        </div>
    @endif
</div>
