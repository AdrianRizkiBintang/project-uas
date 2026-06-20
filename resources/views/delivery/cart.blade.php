<x-app-layout>
    <x-slot name="header">
        <h2>Keranjang Delivery</h2>
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
                    <a href="{{ route('home') }}" class="btn btn-blue btn-sm mt-16">Kembali ke Beranda</a>
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
                        </div>
                        <form method="POST" action="{{ route('cart.update', $menuId) }}" class="cart-update-form">
                            @csrf @method('PATCH')
                            <input type="hidden" name="order_type" value="delivery">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="cart-qty">
                            <button type="submit" class="btn btn-outline-blue btn-sm">Update</button>
                        </form>
                        <div class="cart-item-subtotal" style="color:#1976d2">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </div>
                        <form method="POST" action="{{ route('cart.remove', $menuId) }}?type=delivery">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">&times;</button>
                        </form>
                    </div>
                @endforeach
                <div class="cart-total-row">
                    <span>Subtotal</span>
                    <span style="color:#1976d2;font-weight:700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Checkout --}}
            <div class="card mb-20">
                <div class="card-header">Detail Pengiriman &amp; Pembayaran</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('delivery.checkout') }}">
                        @csrf
                        <input type="hidden" name="outlet_id" value="{{ $outlet?->id ?? session('delivery_cart_outlet_id') }}">

                        {{-- Promo Code --}}
                        <div class="form-group">
                            <label class="form-label">Kode Promo (opsional)</label>
                            <div class="input-group">
                                <input type="text" name="promo_code" value="{{ old('promo_code') }}"
                                       class="form-input" placeholder="Masukkan kode promo"
                                       list="promo-list">
                                <datalist id="promo-list">
                                    @foreach($promos as $promo)
                                        <option value="{{ $promo->code }}">
                                            {{ $promo->discount_type === 'percentage' ? $promo->discount_value.'%' : 'Rp '.number_format($promo->discount_value,0,',','.') }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>
                            @if($promos->isNotEmpty())
                            <div class="text-sm text-muted mt-4">
                                Promo aktif: {{ $promos->pluck('code')->join(', ') }}
                            </div>
                            @endif
                        </div>

                        {{-- Delivery Address --}}
                        <div class="form-group">
                            <label class="form-label">Alamat Pengiriman</label>
                            @php $addresses = auth()->user()->addresses; @endphp
                            @if($addresses->isEmpty())
                                <div class="alert alert-warning">
                                    Belum ada alamat.
                                    <a href="{{ route('addresses.index') }}">Tambah Alamat</a>
                                </div>
                            @else
                                <select name="delivery_address_id" required class="form-select">
                                    <option value="">-- Pilih Alamat --</option>
                                    @foreach($addresses as $addr)
                                        <option value="{{ $addr->id }}" @selected($addr->is_default)>
                                            [{{ $addr->label }}] {{ Str::limit($addr->address, 60) }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <x-input-error :messages="$errors->get('delivery_address_id')" />
                        </div>

                        {{-- Payment --}}
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

                        {{-- Notes --}}
                        <div class="form-group">
                            <label class="form-label" for="notes">Catatan (opsional)</label>
                            <textarea id="notes" name="notes" class="form-textarea"
                                      placeholder="Misal: tidak pedas...">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Driver Notes --}}
<div class="form-group">
    <label class="form-label" for="driver_notes">Pesan untuk Driver (opsional)</label>
    <textarea id="driver_notes" name="driver_notes" class="form-textarea"
              placeholder="Misal: telepon saat sampai atau masuk lewat gerbang belakang">{{ old('driver_notes') }}</textarea>
</div>

                        <button type="submit" class="btn btn-blue btn-full btn-lg">Konfirmasi Pesanan</button>
                    </form>
                </div>
            </div>

        @endif

    </div>
</x-app-layout>