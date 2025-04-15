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
            <svg class="w-[70px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M12.12 12.78C12.05 12.77 11.96 12.77 11.88 12.78C10.12 12.72 8.71997 11.28 8.71997 9.50998C8.71997 7.69998 10.18 6.22998 12 6.22998C13.81 6.22998 15.28 7.69998 15.28 9.50998C15.27 11.28 13.88 12.72 12.12 12.78Z"
                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                    <path
                        d="M18.74 19.3801C16.96 21.0101 14.6 22.0001 12 22.0001C9.40001 22.0001 7.04001 21.0101 5.26001 19.3801C5.36001 18.4401 5.96001 17.5201 7.03001 16.8001C9.77001 14.9801 14.25 14.9801 16.97 16.8001C18.04 17.5201 18.64 18.4401 18.74 19.3801Z"
                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                    <path
                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </g>
            </svg>
            <h2 class="mt-4 text-xl font-semibold">{{ $user->name }}</h2>
            <p class="text-sm uppercase tracking-wide text-white/80">{{ strtoupper($user->country ?? 'Indonesia') }}</p>
        </div>
        <button class="absolute bottom-6 right-6 rounded-full bg-white p-2 shadow-lg">
            <i data-lucide="pencil" class="h-4 w-4 text-purple-600"></i>
        </button>
    </div>
 
<!-- Menu List -->
<div class="p-6 space-y-8 max-w-3xl mx-auto">
    <!-- Account Section -->
    <div>
        <h3 class="text-lg font-semibold text-gray-800">Account</h3>
        <p class="text-sm text-gray-500">Update your info to keep your account</p>
        <div class="mt-4 space-y-3 rounded-xl bg-gray-50 p-4 shadow-sm">
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="user-circle" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Account information</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Friends</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="bell" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Notifications</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
        </div>
    </div>
 
    <!-- Privacy Section -->
    <div class="mb-10">
        <h3 class="text-lg font-semibold text-gray-800">Privacy</h3>
        <p class="text-sm text-gray-500">Customize your privacy to make experience better</p>
        <div class="mt-4 space-y-3 rounded-xl bg-gray-50 p-4 shadow-sm">
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="lock" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Security</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="log-in" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Login details</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="credit-card" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Billing</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="shield" class="h-5 w-5 text-purple-600"></i>
                    <span class="text-sm font-medium text-gray-800">Privacy</span>
                </div>
                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            </a>
        </div>
    </div>
    <div class="h-15"></div>
</div>