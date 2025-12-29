<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Livewire\Attributes\On;

class SearchProduct extends Component
{
    public $barcodeQuery;
    public $searchQuery;
    public $searchResults;
    public $howMany;
    public $activeTab = 'barcode';

    public function mount()
    {
        $this->barcodeQuery = '';
        $this->searchQuery = '';
        $this->howMany = 5;
        $this->searchResults = Collection::empty();
    }

    public function render()
    {
        return view('livewire.search-product');
    }

   
    public function updatedBarcodeQuery()
    {
        if ($this->barcodeQuery === '') {
            $this->resetBarcodeQuery();
            return;
        }

        if (strlen($this->barcodeQuery) < 3) {
            return;
        }

        if (!ctype_digit($this->barcodeQuery)) {
            $this->dispatch('barcodeError', 'Barcode harus berupa angka');
            $this->resetBarcodeQuery();
            return;
        }

        $product = Product::where('product_code', $this->barcodeQuery)->first();

        if ($product) {
            $this->dispatch('productSelected', $product);
            $this->resetBarcodeQuery();
            $this->dispatch('focusBarcodeScanner');
        } else {
            $this->dispatch('barcodeError', 'Produk dengan barcode ini tidak ditemukan');
            $this->resetBarcodeQuery();
        }
    }


    public function updatedSearchQuery()
    {
        if ($this->searchQuery === '') {
            $this->searchResults = Collection::empty();
            
            $this->dispatch('searchProductsUpdated', []);
            return;
        }

        $this->searchResults = Product::where('product_name', 'like', '%' . $this->searchQuery . '%')
            ->orWhere('product_code', 'like', '%' . $this->searchQuery . '%')
            ->take($this->howMany)
            ->get();

      
        $this->dispatch('searchProductsUpdated', $this->searchResults->toArray());
    }

    public function loadMore()
    {
        $this->howMany += 5;
        $this->updatedSearchQuery();
    }

    public function resetBarcodeQuery()
    {
        $this->barcodeQuery = '';
    }

    public function resetSearchQuery()
    {
        $this->searchQuery = '';
        $this->howMany = 5;
        $this->searchResults = Collection::empty();
        
        $this->dispatch('searchProductsUpdated', []);
    }

    public function selectProduct($productId)
    {
        $product = Product::find($productId);
        $this->dispatch('productSelectedFromSearch', $product);
        $this->resetSearchQuery();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        
        if ($tab === 'barcode') {
            $this->resetSearchQuery();
            $this->dispatch('focusBarcodeScanner');
        } else {
            $this->resetBarcodeQuery();
        }
    }


    #[On('clearSearchResults')]
    public function clearSearchResults()
    {
        $this->resetSearchQuery();
    }
}