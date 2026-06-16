<x-app-layout>
    <x-slot name="header">
        <h2>Riwayat Pesanan</h2>
    </x-slot>

    <div class="container-md">

        @if(session('success'))
            <div class="alert alert-success mt-16">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="card mb-20">
                <div class="card-body empty-state">
                    <div class="empty-state-msg">
                        Belum ada pesanan.
                    </div>

                    <a href="{{ route('home') }}"
                       class="btn btn-primary btn-sm mt-16">
                        Mulai Pesan Sekarang
                    </a>
                </div>
            </div>
        @else

            @foreach($orders as $order)

            <div class="order-card">

                <div class="order-card-top">

                    <div>

                        <div class="order-id d-flex align-center gap-8">

                            <span>#{{ $order->id }}</span>

                            <span class="badge {{ $order->type === 'dine_in' ? 'badge-primary' : 'badge-blue' }}">
                                {{ $order->type === 'dine_in' ? 'Dine In' : 'Delivery' }}
                            </span>

                            <span class="badge {{ match($order->status) {
                                'completed' => 'badge-success',
                                'cancelled' => 'badge-danger',
                                'processing', 'out_for_delivery' => 'badge-warning',
                                default => 'badge-secondary',
                            } }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>

                        </div>

                        <div class="order-meta mt-4">
                            {{ $order->outlet->name }}
                            &mdash;
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>

                        <div class="order-items">
                            {{ $order->items->map(fn($i) => $i->menu->name . ' x' . $i->quantity)->join(', ') }}
                        </div>

                    </div>

                    <div class="text-right">

                        <div class="order-total {{ $order->type === 'dine_in' ? 'text-primary' : 'text-blue' }}">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </div>

                        @if($order->discount_amount > 0)
                            <div class="order-discount">
                                Hemat Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                            </div>
                        @endif

                        <div class="d-flex gap-8 justify-content-end mt-8">

                            <a href="{{ $order->type === 'dine_in'
                                ? route('dine-in.track', $order)
                                : route('delivery.track', $order) }}"
                               class="btn btn-outline btn-sm">
                                Lihat Detail
                            </a>

                            <form method="POST"
                                  action="{{ route('orders.reorder', $order) }}">
                                @csrf

                                <button type="submit"
                                        class="btn btn-primary btn-sm">
                                    Pesan Lagi
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

                @if($order->review)

                    <div class="order-review-row">

                        <span style="color:#f9a825">
                            @for($i = 1; $i <= $order->review->rating; $i++)
                                &#9733;
                            @endfor

                            @for($i = $order->review->rating + 1; $i <= 5; $i++)
                                <span style="color:#ddd">&#9733;</span>
                            @endfor
                        </span>

                        @if($order->review->comments)
                            &mdash;
                            <em>
                                {{ Str::limit($order->review->comments, 80) }}
                            </em>
                        @endif

                    </div>

                @endif

            </div>

            @endforeach

            <div class="mt-4 mb-20">
                {{ $orders->links() }}
            </div>

        @endif

    </div>
</x-app-layout>