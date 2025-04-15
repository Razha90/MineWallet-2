<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Bank;
use App\Models\TopUp;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $banks = [];
    public function mount()
    {
        $this->banks = Bank::all()->toArray();
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
                $isExist = TopUp::where('amount', $amountFinal)
                    ->where('status', 'pending')
                    ->exists();
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
            <h1 class="text-xl font-bold">Top Up</h1>
            <i data-lucide="edit-2" class="h-5 w-5 text-gray-400"></i>
        </div>
        <p class="text-sm text-gray-500">Masukkan nominal (Min Rp 10.000)</p>

        <!-- Input Manual -->
        <div class="mt-3">
            <div class="relative">
                <span class="absolute left-3 top-3 text-sm text-gray-500">Rp</span>
                <input type="number" x-model="nom"
                    class="w-full border-b-2 border-purple-500 py-2 pl-10 text-lg focus:border-purple-600 focus:outline-none"
                    placeholder="0">
            </div>
            <div class="mt-1 text-sm text-gray-500">
                Saldo Aktif:
                <span class="font-semibold text-purple-600">Rp
                    {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</span>
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

        <div class="mt-5 select-none">
            <h3>Pilih Metode Pembayaran</h3>
            <div>
                <template x-if="objectBanks.length != 0">
                    <template x-for="(banks, index) in objectBanks" :key="index">
                        <div class="mt-2">
                            <template x-if="banks.type == 'Wallet'">
                                <div class="ml-4 flex flex-row items-center gap-x-2">
                                    <svg class="w-[25px] text-blue-500" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M16.5008 14.1502H16.5098M19 4.00098H6.2C5.0799 4.00098 4.51984 4.00098 4.09202 4.21896C3.71569 4.41071 3.40973 4.71667 3.21799 5.093C3 5.52082 3 6.08087 3 7.20098V16.801C3 17.9211 3 18.4811 3.21799 18.909C3.40973 19.2853 3.71569 19.5912 4.09202 19.783C4.51984 20.001 5.07989 20.001 6.2 20.001H17.8C18.9201 20.001 19.4802 20.001 19.908 19.783C20.2843 19.5912 20.5903 19.2853 20.782 18.909C21 18.4811 21 17.9211 21 16.801V11.201C21 10.0809 21 9.52082 20.782 9.093C20.5903 8.71667 20.2843 8.41071 19.908 8.21896C19.4802 8.00098 18.9201 8.00098 17.8 8.00098H7M16.9508 14.1502C16.9508 14.3987 16.7493 14.6002 16.5008 14.6002C16.2523 14.6002 16.0508 14.3987 16.0508 14.1502C16.0508 13.9017 16.2523 13.7002 16.5008 13.7002C16.7493 13.7002 16.9508 13.9017 16.9508 14.1502Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    <p x-text="banks.type" class="text-blue-500"></p>
                                </div>
                            </template>
                            <template x-if="banks.type == 'Bank'">
                                <div class="ml-4 mt-4 flex flex-row items-center gap-x-2">
                                    <svg class="w-[30px] text-blue-500" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M20.6092 8.34165L12.0001 3.64575L3.39093 8.34165L3.75007 9.75007H5.25007V15.7501H4.50007V17.2501H19.5001V15.7501H18.7501V9.75007H20.2501L20.6092 8.34165ZM6.75007 15.7501V9.75007H9.00007V15.7501H6.75007ZM10.5001 15.7501V9.75007H13.5001V15.7501H10.5001ZM15.0001 15.7501V9.75007H17.2501V15.7501H15.0001ZM12.0001 5.35438L17.3088 8.25007H6.69131L12.0001 5.35438ZM3 19.5001H21V18.0001H3V19.5001Z"
                                                fill="currentColor"></path>
                                        </g>
                                    </svg>
                                    <p x-text="banks.type" class="text-blue-500"></p>
                                </div>
                            </template>
                            <div class="mt-2 flex flex-wrap gap-x-4">
                                <template x-for="(bank, item) in banks.data" :key="item">
                                    <div class="cursor-pointer rounded-full border px-3 py-2 transition-all hover:bg-blue-200/50"
                                        :class="{
                                            'border-blue-500 font-bold bg-blue-300/20': bankId == bank
                                                .id,
                                            'border-gray-300 bg-white': bankId != bank.id
                                        }"
                                        @click="if (bankId == bank.id) {bankId = ''} else {bankId = bank.id}">
                                        <div class="flex h-[20px] w-[60px] items-center">
                                            <img class="bg-cover" :src="bank.image" alt="bank.name" />
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
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
            banks: @entangle('banks').live,
            objectBanks: [],
            stopInit: false,
            bankId: "",
            loading: false,
            async sendTopup() {
                this.loading = true;
                if (this.nom < 10000) {
                    this.$dispatch('failed', [{
                        message: 'Minimal Top Up Rp 10.000'
                    }])
                    this.loading = false;
                    return;
                }
                if (this.bankId.length > 0) {
                    this.$dispatch('failed', [{
                        message: 'Pilih Metode Pembayaran'
                    }])
                    this.loading = false;
                    return;
                }
                await this.$wire.sendTopup(this.nom, this.bankId);
                this.loading = false;
                return;
            },
            pisahBanks(data) {
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
