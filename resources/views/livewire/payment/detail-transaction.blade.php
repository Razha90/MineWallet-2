<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.payment')] class extends Component {
    public $user;
    public $transaction;

    public function mount()
    {
        $this->user = auth()->user();

        // Dummy data transaksi
        $this->transaction = (object) [
            'transaction_number' => 'TRX123456789',
            'reference_number' => 'REF20250414',
            'customer_name' => $this->user->name ?? 'John Doe',
            'description' => 'Top Up Saldo',
            'amount' => 150000,
            'created_at' => now(),
        ];
    }
}; ?>

<div class="mx-auto max-w-5xl bg-white p-6 text-gray-800">
    <!-- Header -->
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-lg font-semibold">Riwayat</h1>
    </div>

    <!-- Status Pembayaran -->
    <div class="mb-1 text-xl font-bold">Online Payment</div>
    <div class="text-sm text-gray-600">Rp. {{ number_format($transaction->amount, 0, ',', '.') }}</div>
    <div class="mb-4 text-xs text-gray-500">
        {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y • H:i:s') }}
        <span class="ml-2 text-green-600">Berhasil</span>
    </div>

    <!-- Detail Transaksi -->
    <div class="mb-4 rounded-xl bg-gray-100 p-4">
        <h2 class="mb-2 text-sm font-semibold">Detail Transaksi</h2>
        <div class="mb-1 text-sm">No. Transaksi: <span class="font-medium">{{ $transaction->transaction_number }}</span>
        </div>
        <div class="mb-1 text-sm">No. Referensi: <span class="font-medium">{{ $transaction->reference_number }}</span>
        </div>
        <div class="mb-1 text-sm">Customer: <span class="font-medium">{{ $transaction->customer_name }}</span></div>
        <div class="mb-1 text-sm">Deskripsi: <span class="font-medium">{{ $transaction->description }}</span></div>
        <div class="mb-1 text-sm">Nominal Transaksi: <span class="font-medium">Rp.
                {{ number_format($transaction->amount, 0, ',', '.') }}</span></div>
    </div>

    <!-- Detail Pembayaran -->
    <div class="rounded-xl bg-gray-100 p-4">
        <h2 class="mb-2 text-sm font-semibold">Detail Pembayaran</h2>
        <div class="flex items-center gap-2 text-sm">
            <i class="bi bi-wallet2 text-purple-600"></i>
            <span>AstraPay Balance</span>
            <span class="ml-auto font-semibold">Rp. {{ number_format($transaction->amount, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Tombol Bagikan -->
    <div class="mt-6">
        <button class="w-full rounded-lg bg-blue-600 py-2 font-semibold text-white transition hover:bg-blue-500">
            lanjutkan
        </button>
    </div>
</div>
