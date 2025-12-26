<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;

class SearchProduct extends Component
{
    public $query;
    public $search_results;

    public function mount()
    {
        $this->query = '';
        $this->search_results = Collection::empty();
    }

    public function render()
    {
        return view('livewire.search-product');
    }

    /**
     * BARCODE ONLY SEARCH
     */
    public function updatedQuery()
    {
        
        if ($this->query === '') {
            $this->resetQuery();
            return;
        }

        
        if (!ctype_digit($this->query)) {
            $this->dispatch('barcodeError', 'Barcode harus berupa angka');
            $this->resetQuery();
            return;
        }

       
        $product = Product::where('product_code', $this->query)->first();

        if ($product) {
            
            $this->dispatch('productSelected', $product);

          
            $this->resetQuery();
        } else {
            
            $this->dispatch('barcodeError', 'Produk dengan barcode ini tidak ditemukan');
            $this->resetQuery();
        }
    }

    public function resetQuery()
    {
        $this->query = '';
        $this->search_results = Collection::empty();
    }
}
