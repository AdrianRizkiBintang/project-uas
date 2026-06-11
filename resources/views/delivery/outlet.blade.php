<x-app-layout>
    <x-slot name="header">
        <h2>Pilih Outlet</h2>
    </x-slot>

    <div class="container-md">

        @if($outlets->isNotEmpty())

            @foreach($outlets as $outlet)

                <div class="card mb-20">
                    <div class="card-body">

                        <div class="d-flex justify-between align-center">

                            <div>
                                <h3 class="mb-8">
                                    {{ $outlet->name }}
                                </h3>

                                @if(!empty($outlet->address))
                                    <p class="text-muted mb-0">
                                        {{ $outlet->address }}
                                    </p>
                                @endif
                            </div>

                            <div>
                                <a href="{{ route('delivery.menu', [
                                    'outlet_id' => $outlet->id,
                                    'address_id' => $addressId
                                ]) }}"
                                   class="btn btn-blue">
                                    Pilih Outlet
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            @endforeach

        @else

            <div class="card">
                <div class="card-body text-center text-muted">
                    Tidak ada outlet tersedia.
                </div>
            </div>

        @endif

    </div>
</x-app-layout>