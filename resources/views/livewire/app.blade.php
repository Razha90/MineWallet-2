<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Notifications\UserNotification;
use App\Models\ProductMerchant;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
new #[Layout('components.layouts.homepage')] class extends Component {
    public function buyPulsa($idProduct)
    {
        try {
            $product = ProductMerchant::find($idProduct)->first();
            if (!$product) {
                $this->dispatch('failed', ['message' => 'Produk tidak ditemukan.']);
                return;
            }
            Transaction::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'type' => $product->type,
                'sub_type' => $product->sub_type,
                'service_name' => $product->name,
                'prize' => $product->price,
                'quantity' => 1,
                'total' => $product->price,
                'status' => 'pending',
            ]);
            $this->dispatch('success', ['message' => 'Pembelian pulsa berhasil.']);
            return;
        } catch (\Throwable $th) {
            Log::error('Error in buyPulsa: ' . $th->getMessage());
            $this->dispatch('failed', ['message' => 'Terjadi kesalahan saat melakukan pembelian.']);
            return;
        }
    }
}; ?>

<div x-data="initApp">


    <!-- <nav class="bg-white p-4 shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                    alt="MineWallet Logo" class="h-18 w-18 rounded-full">
            </div>

            <div class="flex items-center gap-4">
                <div x-data="{ avatar: '{{ auth()->user()->avatar }}', open: false, logout() { $refs.logoutForm.submit() } }" class="relative flex items-end text-right" @click.away="open=false">
                    <form x-ref="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>
                    <div class="relative flex w-full flex-row items-center gap-x-2 rounded-2xl p-2">

                        <div class="flex w-[80%] flex-row items-center justify-between">
                            <div class="cursor-pointer rounded-md hover:bg-blue-500/20" @click="open = !open">
                                <svg class="w-[35px] transition-all"
                                    :class="{
                                        'text-blue-500 rotate-0': !open,
                                        'text-gray-500 rotate-180': open,
                                    }"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M5.70711 9.71069C5.31658 10.1012 5.31658 10.7344 5.70711 11.1249L10.5993 16.0123C11.3805 16.7927 12.6463 16.7924 13.4271 16.0117L18.3174 11.1213C18.708 10.7308 18.708 10.0976 18.3174 9.70708C17.9269 9.31655 17.2937 9.31655 16.9032 9.70708L12.7176 13.8927C12.3271 14.2833 11.6939 14.2832 11.3034 13.8927L7.12132 9.71069C6.7308 9.32016 6.09763 9.32016 5.70711 9.71069Z"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>
                            </div>
                            <p class="ml-2 truncate text-base font-semibold text-blue-500">
                                {{ auth()->user()->name }}
                            </p>

                        </div>
                        <template x-if="avatar.length == 0">
                            <div
                                class="flex h-[37px] w-[37px] items-center justify-center overflow-hidden rounded-full bg-blue-500/50 p-1">
                                <svg class="w-[25px]" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12.12 12.78C12.05 12.77 11.96 12.77 11.88 12.78C10.12 12.72 8.71997 11.28 8.71997 9.50998C8.71997 7.69998 10.18 6.22998 12 6.22998C13.81 6.22998 15.28 7.69998 15.28 9.50998C15.27 11.28 13.88 12.72 12.12 12.78Z"
                                            stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M18.74 19.3801C16.96 21.0101 14.6 22.0001 12 22.0001C9.40001 22.0001 7.04001 21.0101 5.26001 19.3801C5.36001 18.4401 5.96001 17.5201 7.03001 16.8001C9.77001 14.9801 14.25 14.9801 16.97 16.8001C18.04 17.5201 18.64 18.4401 18.74 19.3801Z"
                                            stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                            stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                        </template>
                        <template x-if="avatar.length > 0">
                            <div>
                                <img :src="avatar" alt="Avatar"
                                    class="h-[35px] w-[35px] rounded-full border-2 border-blue-500/20 shadow-md">
                            </div>
                        </template>
                    </div>
                    <div x-show="open"
                        class="animate-fade absolute -bottom-[100px] w-full select-none rounded-md bg-white px-2 py-2 shadow-xl">
                        <div @click="NProgress.start(); window.location = '{{ route('profile') }}'; NProgress.done();"
                            class="cursor-pointer rounded-xl p-2 text-center text-blue-500 transition-all hover:bg-blue-500/20">
                            Profil Saya
                        </div>
                        <div @click="logout"
                            class="cursor-pointer rounded-xl p-2 text-center text-red-500 transition-all hover:bg-red-500/20">
                            Keluar
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav> -->

    <!-- Balance Card -->
    <section class="h-60 rounded-b-3xl bg-purple-600 p-6 text-white shadow-md">
        <div class="mx-auto max-w-6xl">
            <!-- Nama User -->
            <div class="flex justify-between">
                <p class="text-2xl"><STRONG>Selamat datang 👋🏻</STRONG></p>
            </div>
            <br>
            <p class="text-xl">Saldo</p>
            <h1 class="mt-1 text-3xl font-bold"><span>Rp.</span><span x-text="formatRupiah(rupiah)"></span></h1>
            <div class="mt-4 grid grid-cols-3 gap-3">
                <div @click="NProgress.start(); window.location = '/topup'; NProgress.done();"
                    class="flex flex-col items-center justify-center gap-1 rounded-xl bg-white py-2 font-semibold text-purple-700 hover:bg-purple-200">
                    <i class="bi bi-wallet h-5 w-5"></i>
                    Top Up
                </div>

                <div
                    class="flex flex-col items-center justify-center gap-1 rounded-xl bg-white py-2 font-semibold text-purple-700 hover:bg-purple-200">
                    <i class="bi bi-upc-scan h-5 w-5"></i>
                    Scan
                </div>
                <div @click="NProgress.start(); window.location = '/transfer'; NProgress.done();"
                    class="flex flex-col items-center justify-center gap-1 rounded-xl bg-white py-2 font-semibold text-purple-700 hover:bg-purple-200">
                    <i class="bi bi-send h-5 w-5"></i>
                    Transfer
                </div>
            </div>

        </div>
    </section>

    <section class="mt-6 px-4">
        <div class="flex justify-center">
            <div class="grid grid-cols-2 gap-6 text-center text-sm text-gray-700">
                <!-- Jual Pulsa -->
                <div @click="NProgress.start(); window.location = '/pulsa'; NProgress.done();"
                    class="block rounded-xl p-3 text-center transition hover:bg-purple-100">
                    <i class="bi bi-phone-fill mb-2 text-3xl text-purple-600"></i>
                    <p>Jual Pulsa</p>
                </div>


                <!-- PLN -->
                <div @click="NProgress.start(); window.location = '/pln'; NProgress.done();"
                    class="block rounded-xl p-3 text-center transition hover:bg-purple-100">
                    <i class="bi bi-lightning-charge-fill mb-2 text-3xl text-yellow-500"></i>
                    <p class="text-sm font-medium text-gray-800">PLN</p>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-8 px-4">
        <div class="mx-auto max-w-6xl">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-lg font-bold">What’s New</h2>
                <a href="#" class="text-sm text-purple-600">See All</a>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <img src="{{ asset('images/maxresdefault.jpg') }}" class="h-full object-cover">
                    <div class="p-3 text-sm">
                        Exchange balances between countries with different currencies
                    </div>
                </div>
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <img src="{{ asset('images/Promo-Pulsa-Telkomsel-Laris-Sejagat-Raya.png') }}"
                        class="h-full object-cover">
                    <div class="p-3 text-sm">
                        Change your digital version of the wallet experience
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="h-[150px]">

    </div>
</div>
<script>
    function initApp() {
        return {
            rupiah: "{{ auth()->user()->saldo }}",
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        }
    }
</script>
