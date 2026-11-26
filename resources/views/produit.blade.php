<x-app-layout>
    <x-slot:title>{{ $product->title }}</x-slot:title>

    <livewire:shop.product-detail :product="$product" />
</x-app-layout>
