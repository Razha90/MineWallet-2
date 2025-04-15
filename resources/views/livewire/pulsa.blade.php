<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Bank;
use App\Models\TopUp;
use App\Models\ProductMerchant;
use App\Models\Transaction;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $pulsa = [];
    public function mount()
    {
        $this->pulsa = ProductMerchant::where('type', 'pulsa')->get()->toArray();
    }

    public function sendTopup($nom, $id)
    {
        try {
            if ($nom > auth()->user()->saldo) {
                $this->dispatch('failed', [
                    'message' => 'Saldo Kamu Kurang, untuk melakukan Transaksi :).',
                ]);
                return;
            }

            if (empty($id)) {
                $this->dispatch('failed', [
                    'message' => 'Pilih Metode Pembayaran Provider Layanan',
                ]);
                return;
            }

            $product = Transaction::create([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
                'type' => 'pulsa',
                'sub_type' => $this->pulsa[$id]['sub_type'],
                'prize' => $nom,
                'quantity' => 1,
                'total' => $nom,
            ]);

            return redirect()->route('payment.detail-transaction', ['id' => $product->id]);
        } catch (\Throwable $th) {
            Log::error('Error Top Up: ' . $th->getMessage());
            $this->dispatch('failed', [
                'message' => 'Terjadi kesalahan saat melakukan top up',
            ]);
            return;
        }
    }
};

?>

<div class="flex h-full w-full flex-col items-center justify-center text-white" x-init="init"
    x-data="initTopUp">
    <div class="mt-[2%] h-full w-full max-w-md rounded-xl border border-gray-300 bg-white p-6 text-gray-800 shadow-lg">
        <!-- Header -->
        <div class="mb-4 flex items-center justify-between">
            <h1 class="text-xl font-bold">Isi Pulsa</h1>
            <i data-lucide="edit-2" class="h-5 w-5 text-gray-400"></i>
        </div>

        <!-- Input Manual -->
        <div class="mt-3">
            <div class="relative">
                <span class="absolute left-3 top-3 text-sm text-gray-500">Rp</span>
                <input type="number" x-model="nom" disabled
                    class="w-full border-b-2 border-purple-500 py-2 pl-10 text-lg focus:border-purple-600 focus:outline-none"
                    placeholder="0">
            </div>
            <div class="mt-1 text-sm text-gray-500">
                Saldo Aktif:
                <span class="font-semibold text-purple-600">Rp
                    {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-5 select-none">
            <h3>Pilih Layanan Pulsa</h3>
            <div class="flex flex-row flex-wrap gap-3">
                <template x-if="pulsas.length != 0">
                    <template x-for="(pulsa, index) in objectType" :key="index">
                        <div class="cursor-pointer rounded-full border px-3 py-2 transition-all hover:bg-blue-200/50"
                            :class="{
                                'border-blue-500 font-bold bg-blue-300/20': pulsa == type,
                                'border-gray-300 bg-white': pulsa != type
                            }"
                            @click="type=pulsa">
                            <p x-text="capitalizeEachWord(pulsa)"></p>
                        </div>
                    </template>
                </template>
            </div>
        </div>

        <!-- Instant Nominal -->
        <div class="mt-5 select-none">
            <template x-if="type.length > 0">
                <p class="mb-2 text-sm font-medium" x-text="capitalizeEachWord(type)"></p>
            </template>
            <template x-if="type.length == 0">
                <p class="mb-2 text-sm font-medium">Pilih Layanan Provider</p>
            </template>
            <div class="grid grid-cols-3 gap-2">
                <template x-for="(pulsa, index) in pulsas" :key="index">
                    <template x-if="pulsa.sub_type == type">
                        <button type="button" @click="nom = pulsa.price; chosePulsa = pulsa.id"
                            class="flex cursor-pointer flex-col items-center justify-center border-2 transition-all"
                            :class="{
                                'bg-purple-100 border-purple-400 text-purple-700 rounded-full font-semibold': nom ==
                                    pulsa.name,
                                'border-gray-300 hover:bg-purple-50 rounded-full border px-3 py-2 text-center text-sm transition': nom !=
                                    pulsa.name
                            }">
                            <span class="text-2xl" x-text="pulsa.name"></span>
                            <p class="text-gray-400 text-sm">Rp. <span
                                    x-text="formatRupiah(pulsa.price)"></span></p>
                        </button>
                    </template>
                </template>
            </div>
        </div>

        <button type="button" @click="sendTopup"
            class="mt-5 w-full cursor-pointer rounded-full border-2 border-purple-600 bg-purple-600 py-3 text-sm font-semibold text-white transition hover:bg-white hover:font-bold hover:text-purple-600 disabled:cursor-not-allowed disabled:border-blue-500 disabled:bg-white disabled:text-blue-500 disabled:opacity-50">
            Check Out
        </button>
    </div>
    <div class="h-[100px]">

    </div>
</div>
<script>
    function initTopUp() {
        return {
            pulsas: @entangle('pulsa').live,
            stopInit: false,
            type: "",
            objectType: [],
            chosePulsa: "",
            saldo: "{{ auth()->user()->saldo }}",
            capitalizeEachWord(text) {
                return text.split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            },
            getUniqueSubTypes(pulsas) {
                const subTypes = pulsas.map(item => item.sub_type);
                const uniqueSubTypes = [...new Set(subTypes)];
                return uniqueSubTypes;
            },
            removeDots(text) {
                return text.replace(/\./g, '');
            },
            async sendTopup() {
                if (Number(this.nom) > Number(this.saldo)) {
                    this.$dispatch('failed', [{
                        message: 'Saldo Kamu Kurang, untuk melakukan Transaksi.'
                    }])
                    return;
                }
                if (this.type.length == 0) {
                    this.$dispatch('failed', [{
                        message: 'Pilih Metode Pembayaran Provider Layanan'
                    }])
                    return;
                }
                await this.$wire.sendTopup(this.nom, this.chosePulsa);
                return;
            },
            pisahBanks(data) {
                return;
                const wallet = data.filter(item => item.type === 'wallet');
                const bank = data.filter(item => item.type === 'bank');
                return [{
                        type: 'Wallet',
                        data: wallet
                    },
                    {
                        type: 'Bank',
                        data: bank
                    }
                ];
            },
            init() {
                if (this.stopInit) return;
                this.stopInit = true;
                this.objectType = this.getUniqueSubTypes(this.pulsas);
                this.$watch('type', (value) => {

                });
            },
            amounts: [10000, 20000, 25000, 50000, 100000, 500000, 1000000, 2000000],
            nom: 0,
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        }
    }
</script>
