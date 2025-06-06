<div class="p-6">
    @if ($this->articles->count() > 0)

        <div class="max-w-[1640px] px-5 py-10 lg:py-14 mx-auto">
            <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                <h2 class="text-2xl font-boad md:text-4xl md:leading-tight dark:text-white">
                    Latest Articles
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->articles as $article)
                    <livewire:components.article-card :article="$article" :key="$article->id" />
                @endforeach
            </div>




            <x-mary-progress value="12" max="100" class="progress-warning h-3" />

            If you look to others for fulfillment, you will never truly be fulfilled.
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})

        </div>

    @endif



</div>
