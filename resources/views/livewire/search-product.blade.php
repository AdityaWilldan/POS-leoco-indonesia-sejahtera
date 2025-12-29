<div x-data x-init="
    Livewire.on('focusBarcodeScanner', () => {
        setTimeout(() => document.getElementById('barcodeInput').focus(), 100);
    });
" class="search-container">

   
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'barcode' ? 'active' : '' }}" 
                    wire:click="switchTab('barcode')"
                    type="button">
                <i class="bi bi-upc-scan me-1"></i> Barcode Scanner
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'search' ? 'active' : '' }}" 
                    wire:click="switchTab('search')"
                    type="button">
                <i class="bi bi-search me-1"></i> Pencarian Manual
            </button>
        </li>
    </ul>

   
    <div class="tab-content">
        
       
        <div class="tab-pane fade {{ $activeTab === 'barcode' ? 'show active' : '' }}" 
             id="barcode-tab">
            <div class="card mb-0 border-0 shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger text-white">
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                            </div>
                            <input
                                id="barcodeInput"
                                type="text"
                                class="form-control"
                                placeholder="Scan barcode atau ketik kode produk..."
                                wire:model.live.debounce.100ms="barcodeQuery"
                                wire:keydown.escape="resetBarcodeQuery"
                                autofocus="{{ $activeTab === 'barcode' }}"
                                autocomplete="off"
                            >
                            <button class="btn btn-outline-danger" 
                                    wire:click="resetBarcodeQuery"
                                    type="button">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> 
                        Scan barcode untuk langsung menambahkan produk ke cart
                    </small>
                </div>
            </div>
            
            
            <div wire:loading wire:target="barcodeQuery" 
                 class="card mt-2 border-0">
                <div class="card-body shadow-sm text-center py-2">
                    <div class="spinner-border spinner-border-sm text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <small class="ms-2">Memproses barcode...</small>
                </div>
            </div>
        </div>

       
        <div class="tab-pane fade {{ $activeTab === 'search' ? 'show active' : '' }}" 
             id="search-tab">
            <div class="card mb-0 border-0 shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-primary text-white">
                                    <i class="bi bi-search"></i>
                                </div>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Cari produk berdasarkan nama atau kode..."
                                wire:model.live.debounce.500ms="searchQuery"
                                wire:keydown.escape="resetSearchQuery"
                                autofocus="{{ $activeTab === 'search' }}"
                                autocomplete="off"
                            >
                            <button class="btn btn-outline-primary" 
                                    wire:click="resetSearchQuery"
                                    type="button">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> 
                        Ketik nama produk atau kode untuk melihat hasil pencarian
                    </small>
                </div>
            </div>

            
            <div wire:loading wire:target="searchQuery" 
                 class="card mt-2 border-0">
                <div class="card-body shadow-sm text-center py-2">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <small class="ms-2">Mencari produk...</small>
                </div>
            </div>
        </div>
    </div>

    <style>
        .search-container {
            position: relative;
        }
        .nav-tabs .nav-link {
            color: #6c757d;
            border: 1px solid transparent;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }
        .nav-tabs .nav-link.active {
            color: #088528;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 500;
        }
        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
        }
        .tab-pane {
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</div>