@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Total Diterima</p>
                <p class="text-4xl font-bold text-green-600">Rp {{ number_format($totalReceived, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Menunggu Verifikasi</p>
                <p class="text-4xl font-bold text-yellow-600">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($paymentDetails->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-lg text-gray-600 mb-4">Belum ada pembayaran</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Kode Transaksi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nominal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentDetails as $payment)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono font-semibold">{{ $payment->payment->transaction_code }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">Rp {{ number_format($payment->amount_for_canteen, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800
                                        @endif
                                    ">
                                        @if($payment->status === 'pending')
                                            ⏳ Menunggu
                                        @else
                                            ✓ Selesai
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $paymentDetails->links() }}
            </div>
        @endif

        <a href="{{ route('canteen.dashboard') }}" class="mt-6 inline-block text-blue-600 hover:text-blue-700 font-semibold">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
