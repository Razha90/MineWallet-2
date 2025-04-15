<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Bank;
use App\Models\TopUp;
use App\Models\ProductMerchant;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $pulsa = [];
    public function mount()
    {
        $this->pulsa = ProductMerchant::where('type', 'pulsa')->get()->toArray();
    }

    public function sendTopup($nom, $bankId)
    {
        try {
            if ($nom <= 9999) {
                $this->dispatch('failed', [
                    'message' => 'Minimal Top Up Rp 10.000',
                ]);
                return;
            }
            if (empty($bankId)) {
                $this->dispatch('failed', [
                    'message' => 'Pilih Metode Pembayaran',
                ]);
                return;
            }
            $bank = Bank::find($bankId);
            if (!$bank) {
                $this->dispatch('failed', [
                    'message' => 'Bank tidak ditemukan',
                ]);
                return;
            }

            do {
                $kodeUnik = random_int(1, 500);
                $amountFinal = $kodeUnik + 1000;
                $isExist = TopUp::where('amount', $amountFinal)->where('status', 'pending')->exists();
            } while ($isExist);

            $topup = TopUp::create([
                'user_id' => auth()->user()->id,
                'bank_id' => $bankId,
                'amount' => $nom,
                'admin' => $amountFinal,
            ]);

            return redirect()->route('payment.detail-payment', ['id' => $topup->id]);
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
                    {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-5 select-none">
            <h3>Pilih Layanan Pulsa</h3>
            <div class="flex flex-wrap flex-row gap-3">
                <template x-if="pulsas.length != 0">
                    <template x-for="(pulsa, index) in pulsas" :key="index">
                        <div class="cursor-pointer rounded-full border px-3 py-2 transition-all hover:bg-blue-200/50"
                            :class="{
                                'border-blue-500 font-bold bg-blue-300/20': bankId == bank
                                    .id,
                                'border-gray-300 bg-white': bankId != bank.id
                            }"
                            @click="type=pulsa.sub_type">
                            <p x-text="capitalizeEachWord(pulsa.sub_type)"></p>

                        </div>
                    </template>
                </template>
            </div>
        </div>

        <!-- Instant Nominal -->
        <div class="mt-5 select-none">
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



        <button type="button" @click="sendTopup" :disabled="loading || bankId.length == 0 || parseInt(nom) < 10000"
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
            capitalizeEachWord(text) {
                return text.split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            },
            async sendTopup() {
                this.loading = true;
                if (this.nom < 10000) {
                    this.$dispatch('failed', {
                        message: 'Minimal Top Up Rp 10.000'
                    })
                    this.loading = false;
                    return;
                }
                if (this.bankId.length > 0) {
                    this.$dispatch('failed', {
                        message: 'Pilih Metode Pembayaran'
                    })
                    this.loading = false;
                    return;
                }
                await this.$wire.sendTopup(this.nom, this.bankId);
                this.loading = false;
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
                this.objectBanks = this.pisahBanks(this.banks);
                this.$watch('banks', value => {
                    this.objectBanks = this.pisahBanks(value);
                });
                console.log(this.objectBanks);
            },
            amounts: [10000, 20000, 25000, 50000, 100000, 500000, 1000000, 2000000],
            nom: 0,
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        }
    }
</script>
