<?php

namespace App\Livewire\Cart;

use App\Enums\AvailabilityStatus;
use App\Helpers\WhatsAppHelper;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public array $items = [];

    public string $name = '';

    public string $phone = '';

    public string $address = '';

    public string $note = '';

    public function mount(): void
    {
        $this->items = session('cart_items', []);
    }

    #[On('add-to-cart')]
    public function addFromProductId(int $productId): void
    {
        $product = Product::find($productId);

        if ($product) {
            $this->add($product);
        }
    }

    public function add(Product $product): void
    {
        if (! $product->is_active) {
            return;
        }

        if ($product->availability_status === AvailabilityStatus::OutOfStock) {
            return;
        }

        $items = session('cart_items', []);
        $max = $product->availability_status === AvailabilityStatus::PreOrder ? 9999 : 99;

        foreach ($items as $key => $item) {
            if ($item['id'] === $product->id) {
                $items[$key]['qty'] = min($max, $item['qty'] + 1);
                session(['cart_items' => $items]);
                $this->items = $items;
                $this->dispatch('cart-count', count: $this->totalQuantity());
                $this->dispatch('open-cart');

                return;
            }
        }

        $items[] = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'slug' => $product->slug,
            'price' => (float) $product->price,
            'qty' => 1,
        ];

        session(['cart_items' => $items]);
        $this->items = $items;
        $this->dispatch('cart-count', count: $this->totalQuantity());
        $this->dispatch('open-cart');
    }

    public function updateQty(int $id, int $qty): void
    {
        $items = session('cart_items', []);

        if ($qty < 1) {
            return;
        }

        $product = Product::find($id);
        $max = ($product && $product->availability_status === AvailabilityStatus::PreOrder) ? 9999 : 99;

        foreach ($items as $key => $item) {
            if ($item['id'] === $id) {
                $items[$key]['qty'] = min($max, $qty);
                session(['cart_items' => $items]);
                $this->items = $items;
                $this->dispatch('cart-count', count: $this->totalQuantity());

                return;
            }
        }
    }

    public function remove(int $id): void
    {
        $items = collect(session('cart_items', []))
            ->reject(fn ($item) => $item['id'] === $id)
            ->values()
            ->all();

        if (count($items) === 0) {
            session()->forget('cart_items');
        } else {
            session(['cart_items' => $items]);
        }
        $this->items = $items;
        $this->dispatch('cart-count', count: $this->totalQuantity());
    }

    public function clear(): void
    {
        session()->forget('cart_items');
        $this->items = [];
        $this->dispatch('cart-count', count: 0);
    }

    public function checkout(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|regex:/^[0-9+\-\s]{9,17}$/',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:500',
        ], [
            'required' => __('The :attribute field is required.'),
            'regex' => __('The :attribute field format is invalid.'),
            'max' => __('The :attribute field must not be greater than :max characters.'),
        ], [
            'name' => __('name'),
            'phone' => __('phone'),
            'address' => __('address'),
            'note' => __('note'),
        ]);

        $contact = setting('contact_info.whatsapp_number');

        $url = WhatsAppHelper::cartMessageUrl($contact, $this->items, [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'note' => $this->note,
        ]);

        session()->forget('cart_items');
        $this->items = [];
        $this->name = '';
        $this->phone = '';
        $this->address = '';
        $this->note = '';
        $this->dispatch('cart-count', count: 0);
        $this->dispatch('close-cart');
        $this->dispatch('open-whatsapp', url: $url);
    }

    public function totalQuantity(): int
    {
        return collect($this->items)->sum('qty');
    }

    public function subtotal(): int
    {
        return collect($this->items)->sum(fn ($item) => (int) $item['price'] * $item['qty']);
    }

    public function render()
    {
        return view('livewire.cart.cart');
    }
}
