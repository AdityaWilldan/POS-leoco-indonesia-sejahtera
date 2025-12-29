<div>
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            
            <livewire:pos.filter :categories="$categories"/>
            
           >
            @if($showSearchResults && !empty($searchResults))
                <div class="alert alert-info mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-search me-2"></i>
                        <strong>Hasil Pencarian:</strong> Menampilkan {{ count($searchResults) }} produk
                    </div>
                    <button wire:click="$dispatch('clearSearchResults')" 
                            class="btn btn-sm btn-outline-info">
                        <i class="bi bi-x-circle me-1"></i> Tampilkan Semua Produk
                    </button>
                </div>
            @endif
            
            <div class="row position-relative">
               
                <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                
                
                @forelse($products as $product)
                    <div wire:click.prevent="selectProduct({{ $product }})" 
                         class="col-lg-4 col-md-6 col-xl-3 mb-3" 
                         style="cursor: pointer;">
                        <div class="card border-0 shadow h-100 product-card">
                            <div class="position-relative">
                                <img height="200" src="{{ $product->getFirstMediaUrl('images') }}" 
                                     class="card-img-top" alt="Product Image"
                                     onerror="this.src='{{ asset('images/default-product.png') }}'">
                                
                                
                                <div class="badge 
                                    @if($product->product_quantity > 10) bg-success
                                    @elseif($product->product_quantity > 0) bg-warning text-dark
                                    @else bg-danger @endif 
                                    mb-3 position-absolute" 
                                     style="left:10px;top: 10px;">
                                    Stok: {{ $product->product_quantity }}
                                </div>
                                
                                
                                @if($showSearchResults)
                                    <div class="badge bg-info position-absolute" 
                                         style="right:10px;top: 10px;">
                                        <i class="bi bi-search"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2 flex-grow-1">
                                    <h6 style="font-size: 13px;" class="card-title mb-1">
                                        {{ Str::limit($product->product_name, 50) }}
                                    </h6>
                                    
                                    <span class="badge bg-success text-white mb-2">
                                        {{ $product->product_code }}
                                    </span>
                                </div>
                                <div class="mt-auto">
                                    <p class="card-text font-weight-bold mb-1 text-primary">
                                        {{ format_currency($product->product_price) }}
                                    </p>
                                    @if($product->product_cost)
                                       
                                        <small class="text-white bg-secondary px-2 py-1 rounded">
                                            Cost: {{ format_currency($product->product_cost) }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 text-center">
                                <small class="text-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Klik untuk tambah ke cart
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert 
                            @if($showSearchResults) alert-warning
                            @else alert-info @endif 
                            mb-0 text-center">
                            <i class="bi 
                                @if($showSearchResults) bi-search
                                @else bi-info-circle @endif 
                                me-2"></i>
                            @if($showSearchResults)
                                Produk tidak ditemukan dalam pencarian
                            @else
                                Produk Tidak Ditemukan...
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>
            
           
            @if(!$showSearchResults && $products->hasPages())
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            @elseif(!$showSearchResults && $products->count() >= $perPage)
                <div class="text-center mt-3">
                    <button wire:click="loadMore" class="btn btn-primary">
                        <i class="bi bi-arrow-down-circle me-1"></i> Tampilkan Lebih Banyak
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style>
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            border-color: #0d6efd;
        }
        
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        
        .bg-success.text-white {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%) !important;
            border: 1px solid #0f5132;
        }
        
        
        .bg-secondary {
            background-color: #6c757d !important;
            font-size: 0.75rem;
        }
        
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
        
      
        .bg-success {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%) !important;
        }
        
        .bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%) !important;
            color: #000 !important;
        }
        
        .bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e35d6a 100%) !important;
        }
        
        .bg-info {
            background: linear-gradient(135deg, #0dcaf0 0%, #31d2f2 100%) !important;
        }
    </style>
</div>