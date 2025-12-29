<?php

namespace App\Livewire\Pos;

use Livewire\Component;

class Filter extends Component
{
    public $categories;
    public $category_id;

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->category_id = '';
    }

    public function updatedCategoryId($value)
    {
        $this->dispatch('categoryChanged', $value);
        
       
        $this->dispatch('clearSearchResults');
    }

    public function render()
    {
        return view('livewire.pos.filter');
    }
}