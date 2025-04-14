<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.homepage')] class extends Component {
    public $transactions = [];

    public function mount()
    {
        $this->transactions = [
            [
                'title' => 'Starbucks Coffee',
                'amount' => '-$156.00',
                'date' => '2 Dec 2020',
                'time' => '3:09 PM',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/732/732217.png',
            ],
            [
                'title' => '12/2021 Subscription',
                'amount' => '-$60.00',
                'date' => '1 Dec 2020',
                'time' => '10:00 PM',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/1384/1384060.png',
            ],
            [
                'title' => 'Netflix Subscription',
                'amount' => '-$87.00',
                'date' => '1 Nov 2020',
                'time' => '10:02 AM',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/2504/2504929.png',
            ],
        ];
    }
};
?>

<div class="min-h-screen bg-gradient-to-b from-purple-600">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <button class="rounded-full bg-white/20 p-2">
            <i data-lucide="chevron-left" class="h-5 w-5 text-white"></i>
        </button>
        <h1 class="text-lg font-bold">Payment History</h1>
        <button class="rounded-full bg-white/20 p-2">
            <i data-lucide="menu" class="h-5 w-5 text-white"></i>
        </button>
    </div>

    <!-- Spendings -->
    <div class="mb-6">
        <h2 class="mb-3 text-sm font-semibold">Spendings</h2>
        <div class="flex gap-3 overflow-x-auto">
            <div class="w-32 rounded-xl bg-white px-4 py-3 text-center text-black shadow-md">
                <img src="https://cdn-icons-png.flaticon.com/512/732/732217.png" class="mx-auto mb-2 h-6 w-6">
                <p class="text-sm font-semibold">Starbucks</p>
            </div>
            <div class="w-32 rounded-xl bg-pink-100 px-4 py-3 text-center text-pink-600 shadow-md">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" class="mx-auto mb-2 h-6 w-6">
                <p class="text-sm font-semibold">Dribbble</p>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="mb-6 rounded-xl bg-white/10 p-4">
        <p class="text-sm">You’ve spent <span class="font-bold">$1,547</span> on expenses over the past 2 months</p>
        <!-- <a href="#" class="mt-2 inline-block text-xs underline">View statistics →</a> -->
    </div>

    <!-- Expenses -->
    <div class="rounded-t-3xl bg-white p-5 text-black">
        <h2 class="text-md mb-4 font-semibold">Expenses</h2>
        <div class="space-y-4">
            @foreach ($transactions as $trx)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ $trx['icon'] }}" class="h-10 w-10 rounded-full" />
                        <div>
                            <p class="text-sm font-semibold">{{ $trx['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $trx['date'] }} • {{ $trx['time'] }}</p>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-red-600">{{ $trx['amount'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
