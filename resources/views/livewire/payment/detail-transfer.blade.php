<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\TopUp;
use App\Models\Transfer;

new #[Layout('components.layouts.payment')] class extends Component {
    public $datas;

    public function mount($id)
    {
        try {
            $data = Transfer::with(['bank', 'sender'])
                ->where('id', $id)
                ->first();
            if ($data->exists()) {
                $this->datas = $data->toArray();
            } else {
                $this->dispatch('cooler');
            }
        } catch (\Throwable $th) {
            Log::error('Error in mount method: ' . $th->getMessage());
            $this->dispatch('cooler');
        }
    }

    public function processPayment()
    {
        try {
            return redirect()->route('payment.gateway')->with('type', 'TRANSFER')->with('id', $this->datas['id']);
        } catch (\Throwable $th) {
            Log::error('Error in processPayment method: ' . $th->getMessage());
            $this->dispatch('failed', [
                'message' => 'Gagal memproses pembayaran',
            ]);
        }
    }
}; ?>

<div class="mx-auto mt-[3%] max-w-5xl bg-white p-6 text-gray-800 shadow-xl" x-data="initPaymentTop">
    <div x-cloak x-data="{
        show: false,
        back() {
            NProgress.start();
            const ref = document.referrer;
            const currentHost = window.location.hostname;
    
            if (ref && new URL(ref).hostname === currentHost) {
                history.back();
            } else {
                window.location.href = '/';
            }
            NProgress.done();
        }
    }" x-on:cooler.window="(event) => {
        show = true;
    }" x-show="show"
        class="bg-secondary_black/20 animate-fade fixed left-0 right-0 top-0 z-30 flex h-screen max-h-screen w-full items-center justify-center overflow-y-auto overflow-x-hidden backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t px-4 pb-2 pt-4">
                    <h3 class="text-xl font-semibold text-blue-500">
                    </h3>
                    <button type="button" @click="back"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-base text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                        data-modal-toggle="crud-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="flex flex-col items-center gap-y-2 px-4 pb-4">
                    <div>
                        <svg class="w-[150px] text-red-500" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M10.5 15L13.5 12M13.5 15L10.5 12" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round"></path>
                                <path
                                    d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            </g>
                        </svg>
                    </div>
                    <p class="text-center text-lg text-red-500">Maaf Tidak Ditemukan Transaksi Top Up!</p>
                    <button @click="back"
                        class="mt-2 cursor-pointer rounded-md border-2 bg-red-500 px-6 py-2 text-xl text-white transition-all hover:border-red-500 hover:bg-white hover:text-red-500">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold">Detail Transaksi</h1>
    </div>
    <div class="mb-1 text-xl font-bold">Online Payment</div>
    <div class="text-base text-gray-600">Rp. </div>
    <div class="mb-4 text-xs text-gray-500">

        <span class="ml-2 text-green-600">Berhasil</span>
    </div> -->

    <!-- Detail Transaksi -->
    <div class="mb-4 rounded-xl bg-gray-100 p-4">
        <h2 class="mb-2 text-base font-semibold">Detail Transaksi</h2>
        <div class="mb-1 text-base">No. Transaksi: <span class="font-medium" x-text="datas.id"></span>
        </div>
    </div>
    <div class="mb-1 text-base">Nama Penguna : <span class="font-medium" x-text="datas.sender.name"></span></div>
    <div class="mb-1 text-base">Deskripsi: <span class="font-medium">Transfer</span></div>
    <div class="mb-1 text-base">Nominal Transaksi: Rp. <span class="font-medium"
            x-text="formatRupiah(datas.amount)"></span></div>
    <template x-if="datas.bank">
        <div class="mb-1 text-base">Administrasi Transaksi: Rp. <span class="font-medium"
                x-text="formatRupiah(datas.bank.admin)"></span></div>
    </template>
    <template x-if="!datas.bank">
        <div class="mb-1 text-base">Total Transaksi: Rp. <span class="text-2xl font-medium"
                x-text="formatRupiah(Number(datas.amount))"></span></div>
    </template>
    <template x-if="datas.bank">
        <div class="mb-1 text-base">Total Transaksi: Rp. <span class="text-2xl font-medium"
                x-text="formatRupiah(Number(datas.bank.admin)+Number(datas.amount))"></span></div>
    </template>


    <!-- Detail Pembayaran -->
    <div class="rounded-xl bg-gray-100 p-4">
        <h2 class="mb-2 text-base font-semibold">Detail Pembayaran</h2>
        <div class="flex flex-row justify-around">
            <div class="flex flex-row items-center justify-center">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                        alt="MineWallet Logo" class="h-18 w-18 rounded-full">
                    <p class="text-xl text-blue-500">MineWallet</p>
                </div>
            </div>
            <div class="flex items-center">
                <svg class="w-[50px] text-blue-500" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
            </div>
            <template x-if="datas.bank">
                <div class="flex flex-col items-center gap-2 text-base">
                    <img :src="datas.bank.image" class="w-[100px]" />
                    <span x-text="datas.bank.name" class="text-xl"></span>
                </div>
            </template>
            <template x-if="!datas.bank">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                        alt="MineWallet Logo" class="h-18 w-18 rounded-full">
                    <span x-text="datas.sender.name" class="text-xl text-blue-500"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Tombol Bagikan -->
    <div class="mt-6">
        <button @click="prosesPayment"
            class="w-full cursor-pointer rounded-lg bg-blue-600 py-2 font-semibold text-white transition hover:bg-blue-500">
            lanjutkan
        </button>
    </div>
</div>
<script>
    function initPaymentTop() {
        return {
            datas: @entangle('datas').live,
            init() {
                console.log(this.datas);
            },
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            prosesPayment() {
                this.$wire.processPayment();
            }
        }
    }
</script>
