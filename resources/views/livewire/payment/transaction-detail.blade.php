<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Carbon;
use App\Models\Transaction;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $topup;

    public function mount($id)
    {
        try {
            $this->topup = Transaction::with(['user', 'product'])->find($id);
            if (!$this->topup) {
                return redirect()->route('home');
            }
        } catch (\Throwable $th) {
            return redirect()->route('home');
        }
    }
};
?>

<div class="min-h-screen min-w-full bg-gradient-to-br from-blue-100 to-blue-200 p-6 text-gray-800"
    x-data="topupDetail">
    <div class="mx-auto min-h-[500px] w-full max-w-md rounded-xl bg-white p-6 shadow-lg">
        <!-- Icon Delivery -->
        <div class="mb-4 flex justify-center">
            <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                alt="Delivery" class="h-30 w-30">
        </div>

        <!-- Detail Header -->
        <div class="mb-6 text-center">
            <p class="text-sm uppercase text-gray-500">Pembelian Pulsa</p>
            <p class="text-xs text-gray-400">#{{ $topup->id }}</p>
            <h1 class="mt-2 text-xl font-bold text-blue-800">
                Thank you, {{ $topup->user->name ?? 'User' }}!
            </h1>
            <p class="text-sm text-gray-600">Terima Kasih Pembelian Dalam Masa Proses.</p>
        </div>

        <div class="text-center">
            <h1 class="mt-2 text-xl font-bold text-blue-800">
                Rp. <span x-text="formatRupiah({{ $topup->prize }})"></span>
            </h1>
        </div>

        <!-- Info Table -->
        <div class="space-y-2 text-sm">
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Waktu Pengisian</span>
                <span>{{ $topup->created_at->format('M d, Y H:i:s') }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Nama Pengguna</span>
                <span>{{ $topup->user->name }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Trasfer Melalui</span>
                <span class="flex flex-row items-center justify-center"> <img
                        src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                        alt="MineWallet Logo" class="h-8 w-8 rounded-full"><span>MineWallet</span> </span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Deksripsi Barang</span>
                <span class="text-gray-500">{{ $topup->product->description }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Status</span>
                <span class="{{ $topup->status === 'success' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ ucfirst($topup->status) }}
                </span>
            </div>
            <div class="flex justify-between pt-2 text-base font-bold">
                <span>Total</span>
                <span>Rp <span
                        x-text="formatRupiah(Number('{{ $topup->prize }}'))"></span>
                </span>
            </div>
        </div>

    </div>
</div>
<script>
    function topupDetail() {
        return {
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        }
    }
</script>
