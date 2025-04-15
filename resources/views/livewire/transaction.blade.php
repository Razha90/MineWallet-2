<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Topup;
use Illuminate\Support\Facades\Auth;
use App\Models\Transfer;
use App\Models\Transaction;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $topups;
    public $transfer;
    public $transaction;

    public function mount()
    {
        $this->getTopUp();
        $this->getTransfer();
        $this->getTransaction();
    }

    public function getTopUp()
    {
        $this->topups = Topup::with(['user', 'bank'])
            ->where('status', '!=', 'waiting')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'failed')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
    public function getTransfer()
    {
        $this->transfer = Transaction::with(['user', 'product'])
            ->where('status', '!=', 'waiting')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function getTransaction()
    {
        $this->transaction = Transaction::with(['user', 'product'])
            ->where('status', '!=', 'waiting')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'failed')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
};
?>


<div class="w-full bg-gradient-to-b from-purple-600" x-data="initKren" x-init="init">
    <div class="mx-auto min-h-screen max-w-xl">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <button class="rounded-full bg-white/20 p-2">
                <i data-lucide="chevron-left" class="h-5 w-5 text-white"></i>
            </button>
            <h1 class="text-lg font-bold">Riwayat Transaksi</h1>
            <button class="rounded-full bg-white/20 p-2">
                <i data-lucide="menu" class="h-5 w-5 text-white"></i>
            </button>
        </div>

        <!-- Spendings -->
        <div class="mb-6">
            <h2 class="mb-3 text-sm font-semibold">Spendings</h2>
            <div class="flex gap-3 overflow-x-auto">
                <div class="bg-purple flex w-32 cursor-pointer items-center justify-center rounded-xl px-4 py-3 text-center text-black shadow-md"
                    :class="{ 'bg-blue-200': page == 1, 'bg-white': page != 1 }" @click="page=1">
                    <p class="font-bold text-blue-500">TOP UP</p>
                </div>
                <div class="bg-purple flex w-32 cursor-pointer items-center justify-center rounded-xl px-4 py-3 text-center text-black shadow-md"
                    :class="{ 'bg-blue-200': page == 2, 'bg-white': page != 2 }" @click="page=2">
                    <p class="font-bold text-blue-500">Transfer</p>
                </div>
                <div class="bg-purple flex w-32 cursor-pointer items-center justify-center rounded-xl px-4 py-3 text-center text-black shadow-md"
                    :class="{ 'bg-blue-200': page == 3, 'bg-white': page != 3 }" @click="page=3">
                    <p class="font-bold text-blue-500">Pembelian</p>
                </div>
            </div>
        </div>

        <!-- Expenses -->

        <template x-if="page == 1">
            <div class="animate-fade rounded-3xl bg-white p-5 text-black">
                <h2 class="text-md mb-4 font-semibold">Top Up Sebelumnya</h2>
                <div class="flex max-h-[600px] flex-col gap-y-3 space-y-4 overflow-auto">
                    <template x-for="(item, index) in topups" :key="index">
                        <div class="flex cursor-pointer items-center justify-between rounded-xl p-3 hover:bg-gray-200"
                            @click="goTopUp(item.id)">
                            <div class="flex items-center gap-3">
                                <img :src="item.bank.image" class="h-10 w-20 rounded-full bg-white p-3" />
                                <div>
                                    <p class="text-sm font-semibold">Rp <span
                                            x-text="formatRupiah(Number(item.amount) + Number(item.admin))"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-sm font-semibold text-gray-500" x-text="item.status"></div>
                        </div>
                    </template>
                    <template x-if="!topups">
                        <p class="text-sm text-gray-500">No transactions found.</p>
                    </template>
                </div>
            </div>
        </template>

        <template x-if="page == 2">
            <div class="animate-fade rounded-3xl bg-white p-5 text-black">
                <h2 class="text-md mb-4 font-semibold">Top Up Sebelumnya</h2>
                <div class="flex max-h-[600px] flex-col gap-y-3 space-y-4 overflow-auto">
                    <template x-for="(item, index) in transfer" :key="index">
                        <div class="flex cursor-pointer items-center justify-between rounded-xl p-3 hover:bg-gray-200"
                            @click="goTransfer(item.id)">
                            <div class="flex items-center gap-3">
                                <template x-if="!item.bank">
                                    <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                                        alt="MineWallet Logo" class="w-12 rounded-full">
                                </template>
                                <template x-if="item.bank">
                                    <img :src="item.bank.image" class="h-15 w-20 rounded-full bg-white p-3" />
                                </template>
                                <template x-if="item.bank">
                                    <div>
                                        <p class="text-sm font-semibold">Rp <span
                                                x-text="formatRupiah(Number(item.amount) + Number(item.bank.admin))"></span>
                                        </p>
                                    </div>
                                </template>
                                <template x-if="!item.bank">
                                    <div>
                                        <p class="text-sm font-semibold">Rp <span
                                                x-text="formatRupiah(Number(item.amount))"></span>
                                        </p>
                                    </div>
                                </template>

                            </div>
                            <div class="text-sm font-semibold text-gray-500" x-text="item.status"></div>
                        </div>
                    </template>
                    <template x-if="!transfer">
                        <p class="text-sm text-gray-500">No transactions found.</p>
                    </template>
                </div>
            </div>
        </template>

        <template x-if="page == 3">
            <div class="animate-fade rounded-3xl bg-white p-5 text-black">
                <h2 class="text-md mb-4 font-semibold">Top Up Sebelumnya</h2>
                <div class="flex max-h-[600px] flex-col gap-y-3 space-y-4 overflow-auto">
                    <template x-for="(item, index) in transaction" :key="index">
                        <div class="flex cursor-pointer items-center justify-between rounded-xl p-3 hover:bg-gray-200"
                            @click="goToTransaction(item.id)">
                            <div class="flex items-center gap-3">
                                <p  class="text-gray-500" x-text="item.type"></p>
                                <div>
                                    <p class="text-sm font-semibold">Rp <span
                                            x-text="formatRupiah(Number(item.prize))"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-sm font-semibold text-gray-500" x-text="item.status"></div>
                        </div>
                    </template>
                    <template x-if="!transaction">
                        <p class="text-sm text-gray-500">No transactions found.</p>
                    </template>
                </div>
            </div>
        </template>
        
    </div>
</div>
<script>
    function initKren() {
        return {
            page: 1,
            topups: @entangle('topups').live,
            transfer: @entangle('transfer').live,
            transaction: @entangle('transaction').live,
            init() {
                console.log(this.transaction);
            },
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            goTopUp(id) {
                NProgress.start();
                window.location = '/topup/' + id;
                NProgress.done();
            },
            goToTransaction(id) {
                NProgress.start();
                window.location = '/transaction/' + id;
                NProgress.done();
            },
            goTransfer(id) {
                NProgress.start();
                window.location = '/transfer/' + id;
                NProgress.done();
            }
        }
    }
</script>
