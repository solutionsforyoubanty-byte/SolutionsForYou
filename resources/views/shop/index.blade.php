@extends('layouts.app')
@section('title', isset($category) ? $category->name : 'Shop')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-4">
    <div class="flex gap-4">
        <!-- Filters Sidebar - Desktop -->
        <aside class="hidden md:block w-64 flex-shrink-0">
            <div class="bg-white rounded shadow sticky top-20">
                <div class="p-4 border-b">
                    <h3 class="font-bold text-sm">FILTERS</h3>
                </div>

                <div class="p-4 border-b">
                    <h4 class="font-medium text-xs text-gray-500 mb-3">CATEGORIES</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop.index', request()->except('category')) }}" 
                                class="text-sm {{ !isset($category) ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }}">
                                All Categories
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('shop.category', $cat->slug) }}" 
                                class="text-sm {{ isset($category) && $category->id == $cat->id ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-4 border-b">
                    <h4 class="font-medium text-xs text-gray-500 mb-3">PRICE</h4>
                    <form action="" method="GET">
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                        @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                        <div class="flex gap-2 items-center">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-20 border rounded px-2 py-1 text-sm">
                            <span>to</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-20 border rounded px-2 py-1 text-sm">
                            <button class="bg-primary text-white px-3 py-1 rounded text-sm">Go</button>
                        </div>
                    </form>
                </div>

                <div class="p-4 border-b">
                    <h4 class="font-medium text-xs text-gray-500 mb-3">CUSTOMER RATINGS</h4>
                    <ul class="space-y-2">
                        @foreach([4, 3, 2, 1] as $rating)
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['rating' => $rating]) }}" 
                                class="flex items-center gap-2 text-sm {{ request('rating') == $rating ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }}">
                                {{ $rating }} <i class="fas fa-star text-yellow-400 text-xs"></i> & above
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-4">
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="checkbox" onchange="window.location.href='{{ request()->fullUrlWithQuery(['in_stock' => request('in_stock') ? null : 1]) }}'" {{ request('in_stock') ? 'checked' : '' }}>
                        <span>In Stock Only</span>
                    </label>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <!-- Header -->
            <div class="bg-white rounded shadow p-3 md:p-4 mb-3 md:mb-4">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-base md:text-xl font-bold">{{ isset($category) ? $category->name : 'All Products' }}</h1>
                            <p class="text-xs md:text-sm text-gray-500">{{ $products->total() }} products</p>
                        </div>
                        <!-- Mobile Filter Button -->
                        <button onclick="toggleMobileFilter()" class="md:hidden bg-gray-100 px-3 py-2 rounded text-sm flex items-center gap-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide">
                        <span class="text-xs md:text-sm text-gray-500 flex-shrink-0">Sort:</span>
                        <select onchange="window.location.href=this.value" class="border rounded px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm flex-shrink-0">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'relevance']) }}" {{ request('sort') == 'relevance' || !request('sort') ? 'selected' : '' }}>Relevance</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'popularity']) }}" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('min_price') || request('max_price') || request('rating'))
            <div class="bg-white rounded shadow p-2 md:p-3 mb-3 md:mb-4 flex flex-wrap items-center gap-2">
                <span class="text-xs md:text-sm text-gray-500">Filters:</span>
                @if(request('search'))
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="bg-gray-100 text-xs md:text-sm px-2 md:px-3 py-1 rounded flex items-center gap-1">
                        "{{ Str::limit(request('search'), 15) }}" <i class="fas fa-times text-xs"></i>
                    </a>
                @endif
                @if(request('min_price') || request('max_price'))
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="bg-gray-100 text-xs md:text-sm px-2 md:px-3 py-1 rounded flex items-center gap-1">
                        ₹{{ request('min_price', 0) }}-{{ request('max_price', '∞') }} <i class="fas fa-times text-xs"></i>
                    </a>
                @endif
                @if(request('rating'))
                    <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}" class="bg-gray-100 text-xs md:text-sm px-2 md:px-3 py-1 rounded flex items-center gap-1">
                        {{ request('rating') }}★+ <i class="fas fa-times text-xs"></i>
                    </a>
                @endif
                <a href="{{ isset($category) ? route('shop.category', $category->slug) : route('shop.index') }}" class="text-primary text-xs md:text-sm ml-auto">Clear</a>
            </div>
            @endif

            <!-- Products -->
            @if($products->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-4 md:mt-6">
                {{ $products->withQueryString()->links() }}
            </div>
            @else
            <div class="bg-white rounded shadow p-8 md:p-12 text-center">
                <i class="fas fa-search text-4xl md:text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg md:text-xl font-medium text-gray-600">No products found</h3>
                <p class="text-sm text-gray-500 mt-2">Try adjusting your filters</p>
                <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-primary text-white px-4 md:px-6 py-2 rounded text-sm">View All</a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Filter Modal -->
<div id="mobileFilter" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="toggleMobileFilter()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl max-h-[80vh] overflow-y-auto transform transition-transform duration-300 translate-y-full" id="filterPanel">
        <div class="sticky top-0 bg-white border-b p-4 flex items-center justify-between">
            <h3 class="font-bold">Filters</h3>
            <button onclick="toggleMobileFilter()" class="text-gray-500"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <div class="p-4 border-b">
            <h4 class="font-medium text-sm mb-3">Categories</h4>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('shop.index') }}" class="px-3 py-1.5 rounded-full text-sm {{ !isset($category) ? 'bg-primary text-white' : 'bg-gray-100' }}">All</a>
                @foreach($categories as $cat)
                <a href="{{ route('shop.category', $cat->slug) }}" class="px-3 py-1.5 rounded-full text-sm {{ isset($category) && $category->id == $cat->id ? 'bg-primary text-white' : 'bg-gray-100' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="p-4 border-b">
            <h4 class="font-medium text-sm mb-3">Price Range</h4>
            <form action="" method="GET" class="flex gap-2 items-center">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="flex-1 border rounded px-3 py-2 text-sm">
                <span>-</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="flex-1 border rounded px-3 py-2 text-sm">
                <button class="bg-primary text-white px-4 py-2 rounded text-sm">Apply</button>
            </form>
        </div>

        <div class="p-4 border-b">
            <h4 class="font-medium text-sm mb-3">Rating</h4>
            <div class="flex flex-wrap gap-2">
                @foreach([4, 3, 2, 1] as $rating)
                <a href="{{ request()->fullUrlWithQuery(['rating' => $rating]) }}" class="px-3 py-1.5 rounded-full text-sm flex items-center gap-1 {{ request('rating') == $rating ? 'bg-primary text-white' : 'bg-gray-100' }}">
                    {{ $rating }}+ <i class="fas fa-star text-xs {{ request('rating') == $rating ? 'text-white' : 'text-yellow-400' }}"></i>
                </a>
                @endforeach
            </div>
        </div>

        <div class="p-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" onchange="window.location.href='{{ request()->fullUrlWithQuery(['in_stock' => request('in_stock') ? null : 1]) }}'" {{ request('in_stock') ? 'checked' : '' }} class="w-5 h-5">
                <span>In Stock Only</span>
            </label>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleMobileFilter() {
    const modal = document.getElementById('mobileFilter');
    const panel = document.getElementById('filterPanel');
    
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        setTimeout(() => panel.classList.remove('translate-y-full'), 10);
    } else {
        panel.classList.add('translate-y-full');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
}
</script>
@endpush
@endsection
