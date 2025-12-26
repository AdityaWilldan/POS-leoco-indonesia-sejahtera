<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;

class SearchProduct extends Component
{
    public $query;
    public $search_results;
    public $how_many;
    public $auto_proceed = true; // aktifkan auto proceed checkout

    public function mount()
    {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function render()
    {
        return view('livewire.search-product');
    }

    /**
     * Live search products
     */
    public function updatedQuery()
    {
        if (trim($this->query) === '') {
            $this->resetQuery();
            return;
        }

        $this->search_results = Product::where('product_name', 'like', '%' . $this->query . '%')
            ->orWhere('product_code', 'like', '%' . $this->query . '%')
            ->take($this->how_many)
            ->get();

        // trigger JS untuk auto select
        $this->dispatch('searchResultsUpdated');
    }

    /**
     * Pilih produk pertama otomatis
     */
    public function selectFirstResult()
    {
        if ($this->search_results->count() > 0) {
            $product = $this->search_results->first();

            // Kirim ke Checkout / Cart
            $this->dispatch('productSelected', $product);

            // Reset search agar siap scan berikutnya
            $this->resetQuery();

            // Trigger checkout modal
            // if ($this->auto_proceed) {
            //     $this->dispatch('showCheckoutModal');
            // }
        }
    }

    /**
     * Klik manual fallback
     */
    public function selectProduct($product)
    {
        $this->dispatch('productSelected', $product);
        $this->resetQuery();

        // if ($this->auto_proceed) {
        //     $this->dispatch('showCheckoutModal');
        // }
    }

    public function loadMore()
    {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery()
    {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }
}
