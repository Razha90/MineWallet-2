<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Carbon;
use App\Models\Transfer;
use App\Models\User;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $topup;
    public $banks;

    public function mount($id)
    {
        try {
            $topup = Transfer::with(['sender', 'bank'])->find($id);
            $this->topup = $topup;
            $this->banks = $topup->toArray();
            if (!$this->topup) {
                return redirect()->route('home');
            }
        } catch (\Throwable $th) {
            return redirect()->route('home');
        }
    }

    public function userFind($id)
    {
        try {
            return User::find($id)->toArray();
        } catch (\Throwable $th) {
            return null;
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
            <p class="text-sm uppercase text-gray-500">TRANSFER</p>
            <p class="text-xs text-gray-400">#{{ $topup->id }}</p>
            <h1 class="mt-2 text-xl font-bold text-blue-800">
                Thank you, {{ $topup->sender->name ?? 'User' }}!
            </h1>
            <p class="text-sm text-gray-600">Terima Kasih Telah Mempercayai MineWallet, proses transaksi kamu dalam Masa
                Proses.</p>
        </div>

        <div class="text-center">
            <h1 class="mt-2 text-xl font-bold text-blue-800">
                Rp. <span x-text="formatRupiah({{ $topup->amount }})"></span>
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
                <span>{{ $topup->sender->name }}</span>
            </div>

            <template x-if="banks.bank">
                <div class="flex justify-between border-b pb-1">
                    <span class="text-gray-500">Admin Fee</span>
                    <span>Rp <span x-text="formatRupiah(banks.bank.admin)"></span></span>
                </div>
            </template>
            <template x-if="!banks.bank">
                <div class="flex justify-between border-b pb-1">
                    <span class="text-gray-500">Admin Fee</span>
                    <span>Gratis</span>
                </div>
            </template>
            <div class="flex justify-between border-b pb-1">
                <span class="text-gray-500">Status</span>
                <span class="{{ $topup->status === 'success' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ ucfirst($topup->status) }}
                </span>
            </div>

            <template x-if="banks.bank">
                <div class="flex justify-between pt-2 text-base font-bold">
                    <span>Total</span>
                    <span>Rp <span
                            x-text="formatRupiah(Number(banks.amount)+ Number(banks.bank.admin))"></span>
                    </span>
                </div>
            </template>
            <template x-if="!banks.bank">
                <div class="flex justify-between pt-2 text-base font-bold">
                    <span>Total</span>
                    <span>Rp <span
                            x-text="formatRupiah(Number(banks.amount))"></span>
                    </span>
                </div>
            </template>
            <template x-if="banks.bank">
                <div class="flex w-full flex-row items-center justify-around">
                    <div class="flex flex-col items-center justify-center">
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                                alt="MineWallet Logo" class="w-12 rounded-full">
                            <p class="text-xl text-blue-500">MineWallet</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-10 text-blue-500" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="flex flex-col items-center">
                        <img :src="banks.bank.image" alt="MineWallet Logo" class="w-15 rounded-full">
                        <span class="text-xl text-blue-500" x-text="banks.bank.name"></span>
                    </div>
                </div>
            </template>
            <template x-if="!banks.bank">
                <div class="flex w-full flex-row items-center justify-around">
                    <div class="flex flex-col items-center justify-center">
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                                alt="MineWallet Logo" class="w-12 rounded-full">
                            <p class="text-xl text-blue-500">MineWallet</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-10 text-blue-500" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                            alt="MineWallet Logo" class="w-12 rounded-full">
                        <span class="text-xl text-blue-500" x-init="findUser(banks.receiver_id)" x-text="user.name"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
<script>
    function topupDetail() {
        return {
            banks: @entangle('banks').live,
            user: "",
            init() {
                console.log('bajinga', this.banks);
            },
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            async findUser(id) {
                const data = await this.$wire.userFind(id);
                this.user = data;
            },
        }
    }
</script>
