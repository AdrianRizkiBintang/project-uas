<x-app-layout>
    <x-slot name="header">
        <h2>Keranjang Dine In</h2>
    </x-slot>

    <div class="container-md">

        @if(session('success'))
            <div class="alert alert-success mt-16">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mt-16">
                @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
            </div>
        @endif

        @if(empty($cart))
            <div class="card mb-20">
                <div class="card-body empty-state">
                    <div class="empty-state-msg">Keranjang Anda kosong.</div>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm mt-16">Kembali ke Beranda</a>
                </div>
            </div>
        @else

            {{-- Cart Items --}}
            <div class="card mb-20">
                <div class="card-header">Item Pesanan</div>
                @php $subtotal = 0; @endphp
                @foreach($cart as $menuId => $item)
                    @php $subtotal += $item['price'] * $item['quantity']; @endphp
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item['name'] }}</div>
                            <div class="cart-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }} / item</div>
                            @if(!empty($item['notes']))
                                <div class="text-sm text-muted mt-4">Catatan: {{ $item['notes'] }}</div>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('cart.update', $menuId) }}" class="cart-update-form">
                            @csrf @method('PATCH')
                            <input type="hidden" name="order_type" value="dine_in">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="cart-qty">
                            <button type="submit" class="btn btn-outline-blue btn-sm">Update</button>
                        </form>
                        <div class="cart-item-subtotal">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </div>
                        <form method="POST" action="{{ route('cart.remove', $menuId) }}?type=dine_in">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">&times;</button>
                        </form>
                    </div>
                @endforeach
                <div class="cart-total-row">
                    <span>Total</span>
                    <span class="cart-total-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Promo Code --}}
            <div class="card mb-20">
                <div class="card-header">Kode Promo</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Punya kode promo? (opsional)</label>
                        <input type="text" id="promo_code_preview" value="{{ old('promo_code') }}"
                               class="form-input" placeholder="Masukkan kode promo" list="promo-list-dinein">
                        <datalist id="promo-list-dinein">
                            @foreach($promos as $promo)
                                <option value="{{ $promo->code }}">
                                    {{ $promo->discount_type === 'percentage' ? $promo->discount_value.'%' : 'Rp '.number_format($promo->discount_value,0,',','.') }}
                                </option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>

            {{-- Checkout --}}
            <div class="card mb-20">
                <div class="card-header">Detail Pembayaran</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dine-in.checkout') }}">
                        @csrf
                        <input type="hidden" name="outlet_id" value="{{ $outlet?->id ?? session('cart_outlet_id') }}">
                        <input type="hidden" name="promo_code" id="promo_code_hidden" value="">

                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="form-check">
                                <input type="radio" id="pay_cash" name="payment_method" value="cash" checked>
                                <label for="pay_cash">Cash</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="pay_qris" name="payment_method" value="qris">
                                <label for="pay_qris">QRIS</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="notes">Catatan ke Dapur (opsional)</label>
                            <textarea id="notes" name="notes" class="form-textarea"
                                      placeholder="Misal: tidak pedas, tanpa bawang...">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg">Konfirmasi Pesanan</button>
                    </form>
                </div>
            </div>

        @endif

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const promoInput = document.getElementById('promo_code_preview');
            const promoHidden = document.getElementById('promo_code_hidden');
            if (promoInput && promoHidden) {
                promoInput.addEventListener('input', function () {
                    promoHidden.value = this.value;
                });
            }
        });
    </script>

    </div>
</x-app-layout>
