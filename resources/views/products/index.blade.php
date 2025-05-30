<x-app-layout>
    @section('content')
        <h1 class="text-3xl font-bold text-center my-8">我們的產品</h1>
        {{-- 嵌入 Livewire 元件 --}}
        @livewire('pages.product')
    @endsection
</x-app-layout>
