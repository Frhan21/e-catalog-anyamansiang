<?php

namespace App\Livewire\Catalog;

use App\Enums\AvailabilityStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public array $selectedCategories = [];

    #[Url(history: true)]
    public ?string $availability = '';

    #[Url(history: true)]
    public ?int $minPrice = null;

    #[Url(history: true)]
    public ?int $maxPrice = null;

    public function updating($name): void
    {
        if (in_array($name, ['search', 'selectedCategories', 'availability', 'minPrice', 'maxPrice'])) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'selectedCategories', 'availability', 'minPrice', 'maxPrice']);
        $this->resetPage();
    }

    public function render()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->select(['id', 'category_id', 'sku', 'name', 'slug', 'price', 'availability_status', 'primary_image', 'is_featured', 'is_active'])
            ->active()
            ->with('category:id,name,slug')
            ->when($this->search, function (Builder $query) {
                $term = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $this->search);
                $query->where(fn ($q) => $q
                    ->where('name', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%")
                    ->orWhere('material', 'like', "%{$term}%")
                );
            })
            ->when($this->selectedCategories, fn (Builder $query) => $query->whereIn('category_id', $this->selectedCategories))
            ->when($this->availability, fn (Builder $query) => $query->where('availability_status', $this->availability))
            ->when($this->minPrice !== null, fn (Builder $query) => $query->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice !== null, fn (Builder $query) => $query->where('price', '<=', $this->maxPrice))
            ->orderBy('is_featured', 'desc')
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.catalog.product-catalog', [
            'products' => $products,
            'categories' => $categories,
            'availabilityOptions' => collect(AvailabilityStatus::cases())->mapWithKeys(fn ($e) => [$e->value => match ($e) {
                AvailabilityStatus::ReadyStock => __('Ready Stock'),
                AvailabilityStatus::PreOrder => __('Pre Order'),
                AvailabilityStatus::OutOfStock => __('Stok Habis'),
            }]),
        ]);
    }
}
