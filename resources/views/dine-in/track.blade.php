<x-app-layout>
    <x-slot name="header">
        <h2>Status Pesanan #{{ $order->id }}</h2>
    </x-slot>

    <div class="container-md">

        @if(session('success'))
            <div class="alert alert-success mt-16">{{ session('success') }}</div>
        @endif

        {{-- Status Card --}}
        <div class="card mb-20">
            <div class="card-body">

                @php
                    $statusInfo = [
                        'pending'    => ['label' => 'Menunggu Konfirmasi'],
                        'confirmed'  => ['label' => 'Pesanan Dikonfirmasi'],
                        'processing' => ['label' => 'Sedang Dimasak'],
                        'completed'  => ['label' => 'Pesanan Selesai'],
                        'cancelled'  => ['label' => 'Dibatalkan'],
                    ];
                    $si = $statusInfo[$order->status] ?? ['label' => ucfirst($order->status)];
                @endphp

                <div class="status-heading">
                    <div class="status-label">{{ $si['label'] }}</div>
                    <div class="status-sub">Outlet: {{ $order->outlet->name }}</div>
                </div>

                {{-- Progress Steps --}}
                @php
                    $steps = ['pending' => 'Menunggu', 'confirmed' => 'Konfirmasi', 'processing' => 'Dimasak', 'completed' => 'Selesai'];
                    $order_keys = array_keys($steps);
                    $current_idx = array_search($order->status, $order_keys) ?? 0;
                @endphp
                <div class="steps-bar">
                    @foreach($steps as $key => $label)
                        @php
                            $idx = array_search($key, $order_keys);
                            $cls = $idx < $current_idx ? 'done' : ($idx === $current_idx ? 'active' : '');
                        @endphp
                        <div class="step-item {{ $cls }}">
                            <div class="step-dot">{{ $idx + 1 }}</div>
                            <div class="step-label">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Items --}}
                <div class="items-list mb-16">
                    @foreach($order->items as $item)
                    <div class="item-row">
                        <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->price_at_time * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <div class="item-row total-row">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-16 text-sm text-muted">
                    <div><strong>Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</div>
                    <div><strong>Status Bayar:</strong> {{ ucfirst($order->payment_status) }}</div>
                    @if($order->notes)
                    <div class="w-full"><strong>Catatan:</strong> {{ $order->notes }}</div>
                    @endif
                </div>

            </div>
        </div>

        {{-- QRIS Display --}}
        @if($order->payment_method === 'qris' && $order->payment_status === 'unpaid')
        <div class="card mb-20" style="text-align:center;">
            <div class="card-header" style="background:#1976d2;color:#fff;font-weight:700;">
                💳 Pembayaran QRIS
            </div>
            <div class="card-body">
                <p style="margin-bottom:8px;font-weight:600;font-size:15px;">Scan QR Code berikut untuk membayar</p>
                <p style="font-size:26px;font-weight:700;color:#1976d2;margin-bottom:12px;">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </p>

                <div style="display:inline-block;padding:16px;border:2px solid #e0e0e0;border-radius:12px;background:#fff;margin:8px 0;">
                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=QRIS-ORDER-{{ $order->id }}-TOTAL-{{ $order->total_amount }}"
                        alt="QR Code Pembayaran"
                        width="220"
                        height="220"
                        style="display:block;"
                    >
                </div>

                <div style="background:#fff8e1;border:1px solid #ffe082;border-radius:8px;padding:12px;margin-top:12px;font-size:14px;text-align:left;">
                    <strong>Cara Bayar:</strong><br>
                    1. Buka aplikasi e-wallet / mobile banking Anda<br>
                    2. Pilih fitur <em>Scan QR</em><br>
                    3. Arahkan kamera ke QR Code di atas<br>
                    4. Konfirmasi jumlah pembayaran<br>
                    5. Selesai — status akan diperbarui otomatis
                </div>

                <div style="margin-top:12px;color:#888;font-size:13px;">
                    Order ID: <strong>#{{ $order->id }}</strong>
                </div>
            </div>
        </div>
        @endif

        {{-- Review --}}
        @if($order->status === 'completed' && !$order->review)
        <div class="card mb-20">
            <div class="card-header">Beri Ulasan</div>
            <div class="card-body">
                <form method="POST" action="{{ route('reviews.store', $order) }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Rating Makanan</label>
                        <div class="star-rating">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                            <label for="star{{ $i }}">&#9733;</label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('rating')" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="comments">Komentar (opsional)</label>
                        <textarea id="comments" name="comments" class="form-textarea"
                                  placeholder="Bagaimana pengalaman makan Anda?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Kirim Ulasan</button>
                </form>
            </div>
        </div>
        @elseif($order->review)
        <div class="card mb-20">
            <div class="card-header">Ulasan Anda</div>
            <div class="card-body">
                <div style="color:#f9a825;font-size:24px;">
                    @for($i = 1; $i <= $order->review->rating; $i++)&#9733;@endfor
                    @for($i = $order->review->rating + 1; $i <= 5; $i++)<span style="color:#ddd;">&#9733;</span>@endfor
                </div>
                @if($order->review->comments)
                    <p class="text-muted mt-8">{{ $order->review->comments }}</p>
                @endif
            </div>
        </div>
        @endif

        <div class="text-center mb-20">
            <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>

    </div>
</x-app-layout>