<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <article class="prose p-6">
                @if($post)
                    <h1>
                        {{ $post->title }}
                    </h1>
                    <div class="">
                        {!! $post->content !!}
                    </div>
                @else
                    <div class="text-red-500">
                        找不到文章內容
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
            </article>
        </div>
    </div>
</div>
