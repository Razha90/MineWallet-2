<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Carbon;
use App\Models\Topup;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $topup;

    public function mount($id)
    {
        try {
            $this->topup = Topup::with(['user', 'bank'])->find($id);
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
            <p class="text-sm uppercase text-gray-500">TOP UP</p>
            <p class="text-xs text-gray-400">#{{ $topup->id }}</p>
            <h1 class="mt-2 text-xl font-bold text-blue-800">
                Thank you, {{ $topup->user->name ?? 'User' }}!
            </h1>
            <p class="text-sm text-gray-600">Terima Kasih Top Up Dalam Masa Proses.</p>
        </div>

        <div class="text-center">
            <h1 class="mt-2 text-xl font-bold text-blue-800">
                Rp. <span x-text="formatRupiah({{ $topup->amount }})"></span>
            </h1>
        </div>

        <!-- Info Table -->
        <div class="space-y-2 text-sm">
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Tanggal Top Up</span>
                <span>{{ $topup->created_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Nama Pengguna</span>
                <span>{{ $topup->user->name }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Trasfer Melalui</span>
                <span>{{ $topup->bank->name }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Admin Fee</span>
                <span>Rp {{ number_format($topup->admin, 0, ',', '.') }}</span>
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
                        x-text="formatRupiah(Number('{{ $topup->amount }}')+ Number('{{ $topup->admin }}'))"></span>
                </span>
            </div>
        </div>

        <!-- Upload bukti / Image preview -->
        @if ($topup->image)
            <!-- <div class="mt-4">
                    <img src="{{ asset('storage/' . $topup->image) }}" alt="Bukti Topup"
                        class="w-full rounded-lg object-cover shadow">
                </div> -->
        @endif

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
