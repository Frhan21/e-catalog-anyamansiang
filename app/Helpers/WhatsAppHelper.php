<?php

namespace App\Helpers;

use App\Models\Product;

class WhatsAppHelper
{
    public static function contactUrl(?string $number): string
    {
        $digits = $number ? preg_replace('/[^0-9]/', '', $number) : '';

        if (! $digits) {
            return '#';
        }

        return 'https://wa.me/'.$digits;
    }

    public static function orderUrl(Product $product, array $contact): string
    {
        $number = $contact['whatsapp_number'] ?? null;

        if (! $number) {
            return '#';
        }

        $price = 'Rp '.number_format((float) $product->price, 0, ',', '.');
        $url = route('products.show', $product);

        $message = sprintf(
            'Halo Admin Koperasi Anyaman Mansiang, saya tertarik memesan produk %s (Kode: %s) dengan harga %s. Link: %s. Apakah stok masih tersedia?',
            $product->name,
            $product->sku ?? '-',
            $price,
            $url
        );

        return self::contactUrl($number).'?text='.rawurlencode($message);
    }

    public static function cartMessageUrl(string $number, array $items, array $buyer): string
    {
        $digits = preg_replace('/[^0-9]/', '', $number);

        if (! $digits || count($items) === 0) {
            return '#';
        }

        $lines = ['Halo Admin Koperasi Anyaman Mansiang, saya ingin memesan:'];

        $total = 0;
        foreach (array_values($items) as $index => $item) {
            $qty = max(1, (int) ($item['qty'] ?? 1));
            $price = (float) ($item['price'] ?? 0);
            $subtotal = $price * $qty;
            $total += $subtotal;

            $lines[] = sprintf(
                '%d. %s (%s) x%d = Rp %s',
                $index + 1,
                $item['name'] ?? '-',
                $item['sku'] ?? '-',
                $qty,
                number_format($subtotal, 0, ',', '.')
            );
        }

        $lines[] = 'Total: Rp '.number_format($total, 0, ',', '.');
        $lines[] = 'Nama: '.($buyer['name'] ?? '-');
        $lines[] = 'Telp: '.($buyer['phone'] ?? '-');
        $lines[] = 'Alamat: '.($buyer['address'] ?? '-');
        $lines[] = 'Catatan: '.(($buyer['note'] ?? '') !== '' ? $buyer['note'] : '-');

        return self::contactUrl($number).'?text='.rawurlencode(implode("\n", $lines));
    }
}
