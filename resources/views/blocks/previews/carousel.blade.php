<div>
    @foreach ($images as $image)
        <img src="{{ Storage::url($image['image']) }}" class="w-32" alt="">
    @endforeach
    {{-- {{ print_r($images, true) }} --}}
</div>

{{-- <div>
    <x-mary-carousel :slides="array_map(function ($item) {
        return [
            'image' => '/' . $item['image']
        ];
    }, $images)" />
</div> --}}