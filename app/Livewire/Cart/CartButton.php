<?php

namespace App\Livewire\Cart;

use Livewire\Attributes\On;
use Livewire\Component;

class CartButton extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->count = collect(session('cart_items', []))->sum('qty');
    }

    #[On('cart-count')]
    public function onUpdateCount(int $count): void
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('livewire.cart.cart-button');
    }
}
