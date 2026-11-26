<?php

namespace App\Livewire\Community;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewsSection extends Component
{
    public ?int $product_id = null;
    public int $rating = 5;
    public string $comment = '';
    public string $feedback = '';

    public function submitReview(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        $this->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $deliveredOrder = Order::where('user_id', Auth::id())
            ->where('status', 'livree')
            ->whereHas('items', fn ($q) => $q->where('product_id', $this->product_id))
            ->first();

        if (! $deliveredOrder) {
            $this->feedback = 'Seuls les clients ayant reçu ce produit (commande livrée) peuvent laisser un avis.';
            return;
        }

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $this->product_id,
                'order_id' => $deliveredOrder->id,
            ],
            [
                'rating' => $this->rating,
                'comment' => trim($this->comment),
                'is_approved' => false,
            ]
        );

        $this->reset(['comment']);
        $this->feedback = 'Merci ! Votre avis a été enregistré et sera publié après modération.';
    }

    public function render()
    {
        return view('livewire.community.reviews-section', [
            'reviews' => Review::where('is_approved', true)->with(['user', 'product'])->latest()->get(),
            'products' => Product::where('is_active', true)->orderBy('title')->get(),
        ]);
    }
}
