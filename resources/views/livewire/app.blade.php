<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Notifications\UserNotification;
new #[Layout('components.layouts.homepage')] class extends Component {
    public function sendNotification()
    {
        $user = auth()->user();
        $user->notify(new UserNotification(''));
    }
}; ?>

<div>
    <nav class="bg-white p-4 shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <div class="text-xl font-bold text-purple-700">MineWallet</div>
            <div class="flex items-center gap-4">
                <img src="https://i.pravatar.cc/40" class="h-10 w-10 rounded-full" alt="Profile">
                <i data-lucide="bell" class="h-6 w-6 text-gray-600"></i>
            </div>
        </div>
    </nav>

    <!-- Balance Card -->
    <section class="h-60 rounded-b-3xl bg-purple-600 p-6 text-white shadow-md">
        <div class="mx-auto max-w-6xl">
            <!-- Nama User -->
            <div class="flex justify-between">
                <p class="text-2xl"><STRONG>Selamat datang 👋🏻</STRONG></p>
                <p class="text-2xl">{{ auth()->user()->name }}</p>
            </div>
            <br>
            <p class="text-xl">Saldo</p>
            <h1 class="mt-1 text-3xl font-bold">Rp 3.700.000</h1>
            <div class="mt-4 grid grid-cols-3 gap-3">
                <button class="rounded-xl bg-white py-2 font-semibold text-purple-700">Top Up</button>
                <button class="rounded-xl bg-white py-2 font-semibold text-purple-700">Scan</button>
                <button class="rounded-xl bg-white py-2 font-semibold text-purple-700">Transfer</button>
            </div>
        </div>
    </section>

    <!-- Feature Grid -->
    <section class="mt-6 px-4">
        <div class="grid grid-cols-4 gap-4 text-center text-sm text-gray-700">
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" class="mx-auto mb-1 w-8">
                <p>Behance</p>
            </div>
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" class="mx-auto mb-1 w-8">
                <p>Google</p>
            </div>
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/2504/2504929.png" class="mx-auto mb-1 w-8">
                <p>Netflix</p>
            </div>
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/2111/2111624.png" class="mx-auto mb-1 w-8">
                <p>Spotify</p>
            </div>
            <div>
                <i data-lucide="wifi" class="mx-auto mb-1 h-6 w-6 text-purple-500"></i>
                <p>Internet</p>
            </div>
            <div>
                <i data-lucide="film" class="mx-auto mb-1 h-6 w-6 text-purple-500"></i>
                <p>Cinema</p>
            </div>
            <div>
                <i data-lucide="hotel" class="mx-auto mb-1 h-6 w-6 text-purple-500"></i>
                <p>Hotel</p>
            </div>
            <div>
                <i data-lucide="plane" class="mx-auto mb-1 h-6 w-6 text-purple-500"></i>
                <p>Flight</p>
            </div>
        </div>
    </section>

    <!-- What's New -->
    <section class="mt-8 px-4">
        <div class="mx-auto max-w-6xl">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-lg font-bold">What’s New</h2>
                <a href="#" class="text-sm text-purple-600">See All</a>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <img src="{{ asset('images/Pasang-Iklan-Menarik-dengan-Fitur-Display-dari-MyAds-Yuk-1200x720.jpg') }}"
                        class="w-full object-cover">
                    <div class="p-3 text-sm">
                        Exchange balances between countries with different currencies
                    </div>
                </div>
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <img src="{{ asset('images/849223b3-tiket-pesawat.jpg') }}" class="w-full object-cover">
                    <div class="p-3 text-sm">
                        Change your digital version of the wallet experience
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
