@extends('layouts.main')
@section('title', 'Manajemen Pemesanan')
@section('content')

    <div class="container-fluid">
        <h1 class="mb-3">Manajemen Pemesanan</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Meja</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Total</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->table_number ?? '-' }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>
                            <span class="badge 
                                    @if($order->payment_status == 'pending') bg-warning 
                                    @elseif($order->payment_status == 'paid') bg-success 
                                    @else bg-danger @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <!-- Tombol Detail -->
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#orderModal{{ $order->id }}">
                                Detail
                            </button>

                            <!-- Tombol Konfirmasi -->
                            @if($order->payment_status == 'pending')
                                <form action="{{ route('orders.confirm', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                </form>
                            @endif

                            <!-- Modal -->
                            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">

                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Detail Pesanan #{{ $order->id }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Meja:</strong> {{ $order->table_number ?? '-' }}</p>
                                            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
                                            <p><strong>Status Pembayaran:</strong>
                                                <span class="badge 
                                                                            @if($order->payment_status == 'pending') bg-warning 
                                                                            @elseif($order->payment_status == 'paid') bg-success 
                                                                            @else bg-danger @endif">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </p>
                                            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

                                            <h6 class="mt-3">Item Pesanan:</h6>
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Menu</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Catatan</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->name_snapshot }}</td>
                                                            <td>Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ $item->note ?? '-' }}</td>
                                                            <td>Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>

@endsection