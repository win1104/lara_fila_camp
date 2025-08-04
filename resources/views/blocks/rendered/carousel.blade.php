@php
use Illuminate\Support\Facades\Storage;
@endphp

<div>
    <x-mary-carousel :slides="array_map(function($item){
        return [
            'image' => Storage::url($item['image'])
        ];
    }, $images)" />
    {{-- {{ print_r($images, true) }} --}}
</div>