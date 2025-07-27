<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;

class CategoryTabs extends Component
{
    public $selectedCategory;

    /**
     * Create a new component instance.
     */
    public function __construct($selectedCategory = null)
    {
        $this->selectedCategory = $selectedCategory;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = Category::get();
        return view('components.category-tabs', [
            'categories' => $categories,
            'selectedCategory' => $this->selectedCategory,
        ]);
    }
}
