<x-app-layout>
    <x-slot:title>Scan commande</x-slot:title>
    @auth
        @if (auth()->user()->isCourier() || auth()->user()->isAdmin())
            <livewire:delivery.courier-scan :order="$order" />
        @else
            <livewire:tracking.order-tracking :token="$token" />
        @endif
    @else
        <livewire:tracking.order-tracking :token="$token" />
    @endauth
</x-app-layout>
