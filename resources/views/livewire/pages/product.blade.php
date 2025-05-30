<div>
    @if($product)
        {{-- 單一產品詳情頁面 --}}
        <div class="max-w-4xl mx-auto p-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($products->image)
                    <img src="{{ asset('storage/' . $products->image) }}" alt="{{ $products->title }}" class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-500">
                        無圖片
                    </div>
                @endif
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4">{{ $products->title }}</h1>
                    <p class="text-gray-600 mb-6">{{ $products->content }}</p>
                    <p class="text-2xl font-bold text-blue-600 mb-6">NT$ {{ number_format($products->tag, 0) }}</p>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg">
                        加入購物車
                    </button>
                </div>
            </div>
        </div>
    @else
        {{-- 產品列表頁面 --}}
        <input type="text" wire:model.live="search" placeholder="搜尋產品..." class="p-2 border rounded shadow-sm mb-4 w-full md:w-1/3">

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @if($products)
                @foreach($products as $product)
                    <div class="border rounded-lg shadow-lg overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                無圖片
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $product->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $product->content }}</p>
                            <p class="text-lg font-bold text-blue-600">NT$ {{ number_format($product->tag, 0) }}</p>
                            <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'product' => $product->slug]) }}" class="mt-4 block w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                                查看詳情
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500">目前沒有找到產品。</p>
            @endif
        </div>

        {{-- 分頁連結 --}}
        {{-- @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif --}}
    @endif
</div>

{{-- 您可能需要引入 Tailwind CSS 來使上述樣式生效 --}}
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
