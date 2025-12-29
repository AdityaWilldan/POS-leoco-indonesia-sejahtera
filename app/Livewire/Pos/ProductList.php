<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;
use Livewire\Attributes\On;

class ProductList extends Component
{
    use WithPagination;

    public $categories;
    public $category_id;
    public $search = '';
    public $searchResults = [];
    public $showSearchResults = false;
    public $perPage = 12;

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->category_id = '';
        $this->searchResults = [];
        $this->showSearchResults = false;
    }

    
    #[On('searchProductsUpdated')]
    public function handleSearchProductsUpdated($results)
    {
        if (empty($results)) {
            $this->showSearchResults = false;
            $this->searchResults = [];
        } else {
            $this->showSearchResults = true;
            $this->searchResults = $results;
        }
    }

    public function render()
    {
        
        if ($this->showSearchResults && !empty($this->searchResults)) {
            $searchResultProducts = Product::whereIn('id', array_column($this->searchResults, 'id'))->get();
        } else {
            
            $searchResultProducts = Product::when($this->category_id, function ($query) {
                    return $query->where('category_id', $this->category_id);
                })
                ->when($this->search, function ($query) {
                    return $query->where('product_name', 'like', '%' . $this->search . '%')
                                 ->orWhere('product_code', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage);
        }

        return view('livewire.pos.product-list', [
            'products' => $this->showSearchResults ? $searchResultProducts : $searchResultProducts
        ]);
    }

    public function selectProduct($product)
    {
        if (is_array($product)) {
            
            $productModel = Product::find($product['id']);
            $this->dispatch('productSelected', $productModel);
        } else {
           
            $this->dispatch('productSelected', $product);
        }
        
       
        $this->dispatch('clearSearchResults');
    }

    public function updatedCategoryId()
    {
        $this->resetPage();
      
        $this->dispatch('clearSearchResults');
    }

    public function updatedSearch()
    {
        $this->resetPage();
        
        if (!empty($this->search)) {
            $this->dispatch('clearSearchResults');
        }
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }
}