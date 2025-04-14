<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Bank;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $user;
    public $amount = 0;
    public $banks;

    public function mount()
    {
        $this->getBanks();
    }

    public function lanjutkan()
    {
        $this->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        session(['transfer_amount' => $this->amount]);

        return redirect()->to('/konfirmasi-transfer');
    }

    public function getBanks()
    {
        $this->banks = Bank::all()->toArray();
    }

    public function searchUser($name) {
        $this->users = User::where('name', 'like', '%' . $name . '%')->get()->toArray();
    }
};
?>

<div class="w-full" x-data="initTransfer" x-init="console.log(banks)">
    <div class="mx-auto min-h-screen max-w-lg bg-purple-600 px-4 pb-10 pt-6">
        <!-- Header -->
        <div class="text-white-800 mb-4 text-center text-lg font-semibold">Kirim Uang</div>

        <!-- Kirim Cepat -->
        <div class="mb-4 rounded-xl bg-white p-4 text-black shadow">
            <label class="mb-2 block text-sm font-medium text-gray-600">Kirim Cepat</label>

            <template x-if="bank == same_user">
                <div class="relative">
                    <input x-model.debounce.500ms="same" placeholder="Cari pengguna"
                        class="w-full rounded-full border border-gray-800 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <template class="x">
                        <div>

                        </div>
                    </template>
                </div>
            </template>

            <template x-if="banks.some(value => value.id == bank)">
                <div>
                    <input type="text" placeholder="Cari kontak, akun bank, atau grup"
                        class="w-full rounded-full border border-gray-800 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </template>

            <!-- Kontak Cepat -->
            <div class="mt-4 flex flex-row flex-wrap gap-3">
                <div class="animate-fade flex flex-row gap-2 rounded-xl border p-2"
                    :class="{ 'border-blue-400 bg-blue-200': bank == '10' }" @click="bank = same_user">Sesama Pengguna
                </div>
                <template x-for="(item, index) in banks" :key="index">
                    <div @click="bank = item.id"
                        class="animate-fade flex flex-row items-center justify-center gap-2 rounded-xl border p-2"
                        :class="{ 'border-blue-400 bg-blue-200': item.id == bank }">
                        <img :src="item.image" alt="Logo Bank" class="w-[50px]">
                        <p x-text="item.name"></p>
                    </div>
                </template>
            </div>

            <!-- Form Nominal -->
            <div class="mt-4 rounded-xl bg-white p-4 text-gray-800 shadow">
                <label for="amount" class="mb-2 block text-sm font-semibold text-gray-700">Masukkan Nominal
                    Transfer</label>

                <!-- Input Manual -->
                <div class="relative mb-2">
                    <span class="absolute left-3 top-3 text-sm text-gray-500">Rp</span>
                    <input x-model="nom" type="number" id="amount" min="10000" step="1000"
                        class="w-full border-b-2 border-purple-500 py-2 pl-10 text-lg focus:border-purple-600 focus:outline-none"
                        placeholder="0">
                </div>

                <!-- Saldo Aktif -->
                <div class="mt-1 text-sm text-gray-500">
                    Saldo Aktif:
                    <span class="font-semibold text-purple-600">Rp
                        {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</span>
                </div>

                <!-- Instant Nominal -->
                <div class="mt-4">
                    <p class="mb-2 text-sm font-medium">Instant</p>
                    <div class="grid grid-cols-3 gap-2">
                        <template x-for="(amount, index) in amounts">
                            <button type="button" @click="nom = amount" class="cursor-pointer border-2 transition-all"
                                :class="{
                                    'bg-purple-100 border-purple-400 text-purple-700 rounded-full font-semibold': nom ==
                                        amount,
                                    'border-gray-300 hover:bg-purple-50 rounded-full border px-3 py-2 text-center text-sm transition': nom !=
                                        amount
                                }">
                                <span x-text="formatRupiah(amount)"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Tombol Lanjutkan -->
                <button wire:click="lanjutkan"
                    class="mt-6 w-full rounded-full bg-purple-600 py-2 text-sm font-semibold text-white transition hover:bg-purple-700">
                    Lanjutkan Transfer
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function initTransfer() {
        return {
            banks: @entangle('banks').live,
            bank: "",
            nom: 0,
            amounts: [10000, 20000, 25000, 50000, 100000, 500000, 1000000, 2000000],
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            same_user: '10',
            initStop: false,
            same: '',
            initSame() {
                if (this.initStop) {
                    return;
                }
                this.initStop = true;
                this.$watch('same', (value) => {
                    if (value.length > 0) {
                        this.$wire.searchUser(value);
                    }
                });
            },

        }
    }
</script>
