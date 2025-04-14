<?php
 
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
 
new #[Layout('components.layouts.homepage')] class extends Component {
    public $user;
    public $amount = 0; // ← TAMBAHKAN INI
 
    public function mount()
    {
        $this->user = auth()->user();
    }
 
    public function lanjutkan()
    {
        $this->validate([
            'amount' => 'required|numeric|min:10000',
        ]);
 
        session(['transfer_amount' => $this->amount]);
 
        return redirect()->to('/konfirmasi-transfer');
    }
};
?>
 
<div>
    <div class="bg-purple-600 min-h-screen pt-6 pb-10 px-4">
        <!-- Header -->
        <div class="text-center text-lg font-semibold text-white-800 mb-4">Kirim Uang</div>
 
        <!-- Kirim Cepat -->
        <div class="bg-white rounded-xl shadow p-4 mb-4 text-black">
            <label class="text-sm text-gray-600 font-medium mb-2 block">Kirim Cepat</label>
 
            <input type="text" placeholder="Cari kontak, akun bank, atau grup"
                class="w-full border border-gray-800 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
 
            <!-- Kontak Cepat -->
            <div class="grid grid-cols-4 gap-4 mt-4 text-center text-xs text-gray-700">
                <div class="flex flex-col items-center">
                    <img src="https://i.pravatar.cc/100?img=1" class="rounded-full w-12 h-12">
                    <span class="mt-1 truncate">BCA Chris</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="https://i.pravatar.cc/100?img=2" class="rounded-full w-12 h-12">
                    <span class="mt-1 truncate">Risa Mandiri</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="https://i.pravatar.cc/100?img=3" class="rounded-full w-12 h-12">
                    <span class="mt-1 truncate">Jevon Jago</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-gray-300 rounded-full w-12 h-12 flex items-center justify-center text-white text-sm">
                        +</div>
                    <span class="mt-1 truncate">Tambah</span>
                </div>
            </div>
 
            <!-- Form Nominal -->
<div class="bg-white rounded-xl shadow p-4 mt-4 text-gray-800">
    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Nominal Transfer</label>
 
    <!-- Input Manual -->
    <div class="relative mb-2">
        <span class="absolute left-3 top-3 text-gray-500 text-sm">Rp</span>
        <input wire:model="amount" type="number" id="amount" min="10000" step="1000"
            class="pl-10 w-full border-b-2 border-purple-500 text-lg py-2 focus:outline-none focus:border-purple-600"
            placeholder="0">
    </div>
 
    @error('amount')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
 
    <!-- Saldo Aktif -->
    <div class="text-sm text-gray-500 mt-1">
        Saldo Aktif:
        <span class="text-purple-600 font-semibold">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
    </div>
 
    <!-- Instant Nominal -->
    <div class="mt-4">
        <p class="font-medium mb-2 text-sm">Instant</p>
        <div class="grid grid-cols-3 gap-2">
            @foreach ([20000, 50000, 100000, 200000, 500000] as $nom)
                <button type="button"
                    wire:click="$set('amount', {{ $nom }})"
                    class="border text-sm rounded-full px-3 py-2 transition text-center
                    {{ $amount == $nom ? 'bg-purple-100 border-purple-400 text-purple-700 font-semibold' : 'border-gray-300 hover:bg-purple-50' }}">
                    Rp {{ number_format($nom, 0, ',', '.') }}
                </button>
            @endforeach
        </div>
    </div>
 
    <!-- Tombol Lanjutkan -->
    <button wire:click="lanjutkan"
        class="w-full mt-6 bg-purple-600 text-white py-2 rounded-full text-sm font-semibold hover:bg-purple-700 transition">
        Lanjutkan Transfer
    </button>
</div>
 
 
        </div>
 
        <!-- Menu Transfer
        <div class="bg-white rounded-xl shadow p-4">
            <div class="grid grid-cols-3 gap-4 text-center text-xs">
                <div class="flex flex-col items-center hover:bg-purple-100 p-3 rounded-xl transition">
                    <i class="bi bi-person-fill text-2xl text-blue-500 mb-2"></i>
                    <span class="text-xs text-gray-700">Kirim ke Sesama</span>
                </div>
                <div class="flex flex-col items-center hover:bg-purple-100 p-3 rounded-xl transition">
                    <i class="bi bi-bank2 text-2xl text-orange-500 mb-2"></i>
                    <span class="text-xs text-gray-700">Kirim ke Bank</span>
                </div>
                <div class="flex flex-col items-center hover:bg-purple-100 p-3 rounded-xl transition">
                    <i class="bi bi-chat-dots-fill text-2xl text-green-500 mb-2"></i>
                    <span class="text-xs text-gray-700">Kirim ke Chat</span>
                </div>
            </div>
        </div> -->
 
 
 
    </div>
</div>