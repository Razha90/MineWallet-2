<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }
};
?>

<div class="min-h-screen bg-white">
    <!-- Profile Header -->
    <div class="relative rounded-b-3xl bg-purple-600 p-6 text-white">
        <div class="flex justify-end">
            <i data-lucide="qr-code" class="h-5 w-5"></i>
        </div>
        <div class="mt-2 flex flex-col items-center">
            <img src="https://i.pravatar.cc/100" class="h-24 w-24 rounded-full border-4 border-white shadow-md"
                alt="User Image">
            <h2 class="mt-4 text-xl font-semibold">{{ $user->name }}</h2>
            <p class="text-sm uppercase tracking-wide text-white/80">{{ strtoupper($user->country ?? 'Indonesia') }}</p>
        </div>
        <button class="absolute bottom-6 right-6 rounded-full bg-white p-2 shadow-lg">
            <i data-lucide="pencil" class="h-4 w-4 text-purple-600"></i>
        </button>
    </div>

    <!-- Menu List -->
    <!-- Mobile -->
    <div class="block space-y-4 p-4 text-gray-700 md:hidden">
        <a href="#" class="flex items-center gap-3">
            <i data-lucide="layout-dashboard" class="h-5 w-5 text-purple-500"></i>
            <span class="text-sm font-medium">Dashboard</span>
        </a>
        <a href="#" class="flex items-center gap-3">
            <i data-lucide="users" class="h-5 w-5 text-purple-500"></i>
            <span class="text-sm font-medium">Traders</span>
        </a>
        <a href="#" class="flex items-center gap-3">
            <i data-lucide="wallet" class="h-5 w-5 text-purple-500"></i>
            <span class="text-sm font-medium">Payments</span>
        </a>
        <a href="#" class="flex items-center gap-3">
            <i data-lucide="bar-chart-2" class="h-5 w-5 text-purple-500"></i>
            <span class="text-sm font-medium">Revenue</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 text-red-500">
                <i data-lucide="log-out" class="h-5 w-5"></i>
                <span class="text-sm font-medium">Logout</span>
            </button>
        </form>
    </div>

    <!-- Desktop -->
    <div class="hidden space-y-5 p-6 text-gray-700 md:flex md:items-center md:justify-center">
        <div class="space-y-8 text-gray-700">
            <div class="flex items-center gap-4">
                <i class="bi bi-box-arrow-in-up-left h-20 w-20 text-purple-500"></i>
                <span class="text-lg font-medium">Dashboard</span>
            </div>
            <div class="flex items-center gap-4">
                <i class="bi bi-person-circle h-20 w-20 text-purple-500"></i>
                <span class="text-lg font-medium">Traders</span>
            </div>
            <div class="flex items-center gap-4">
                <i class="bi bi-wallet h-20 w-20 text-purple-500"></i>
                <span class="text-lg font-medium">Payments</span>
            </div>
            <div class="flex items-center gap-4">
                <i class="bi bi-bar-chart h-20 w-20 text-purple-500"></i>
                <span class="text-lg font-medium">Revenue</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-4 text-red-500">
                    <i class="bi bi-box-arrow-right h-20 w-20"></i>
                    <span class="text-lg font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
