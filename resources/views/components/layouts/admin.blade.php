<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-theme="light">

<head>
    @include('partials.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <link rel="icon" href="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}" type="image/x-icon">

</head>

<body class="min-h-screen bg-white">
    <flux:sidebar sticky stashable class="bg-white! h-full border-r-2 border-gray-300/50 shadow-2xl">
        <div class="text-right">
            <flux:sidebar.toggle
                class="text-gray-500! cursor-pointer border transition-all hover:border-gray-400/50 hover:shadow-md lg:hidden"
                icon="x-mark" />
        </div>
        <div class="text-xl font-bold text-purple-700">MineWallet</div>
        <div x-data="{ path: window.location.pathname }"
            class="flex cursor-pointer select-none flex-row items-center gap-x-2 rounded-md border-2 px-4 py-2 shadow-md transition-all"
            :class="{
                'border-blue-500/30 bg-blue-500/30 hover:bg-blue-500/15': path === '/admin',
                'border-gray-500/30 bg-white hover:bg-gray-500/20': path !== '/admin',
            }"
            @click="if (path !== '/admin') { NProgress.start(); window.location = '/admin'; NProgress.done(); }">

            <svg class="w-[25px]"
                :class="{
                    'text-blue-700': path === '/admin',
                    'text-gray-500': path !== '/admin',
                }"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M6 9.5V14.5M18 9.5V14.5M2.55556 6.55556C3.08333 6.27778 7.77778 6 12 6C16.2222 6 20.9167 6.27778 21.4444 6.55556C21.9722 6.83333 22.5 9.77778 22.5 12C22.5 14.2222 21.9722 17.1667 21.4444 17.4444C20.9167 17.7222 16.2222 18 12 18C7.77778 18 3.08333 17.7222 2.55556 17.4444C2.02778 17.1667 1.5 14.2222 1.5 12C1.5 9.77778 2.02778 6.83333 2.55556 6.55556ZM14.5 12C14.5 13.3807 13.3807 14.5 12 14.5C10.6193 14.5 9.5 13.3807 9.5 12C9.5 10.6193 10.6193 9.5 12 9.5C13.3807 9.5 14.5 10.6193 14.5 12Z"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor">
                    </path>
                </g>
            </svg>
            <p class="text-base"
                :class="{
                    'text-blue-700': path === '/admin',
                    'text-gray-500': path !== '/admin',
                }">
                Top Up
            </p>
        </div>
        <div x-data="{ path: window.location.pathname }"
            class="flex cursor-pointer select-none flex-row items-center gap-x-2 rounded-md border-2 px-4 py-2 shadow-md transition-all"
            :class="{
                'border-blue-500/30 bg-blue-500/30 hover:bg-blue-500/15': path === '/admin/transfer',
                'border-gray-500/30 bg-white hover:bg-gray-500/20': path !== '/admin/transfer',
            }"
            @click="if (path !== '/admin/transfer') { NProgress.start(); window.location = '/admin/transfer'; NProgress.done(); }">
            <svg class="w-[25px]"
                :class="{
                    'text-blue-700': path === '/admin/transfer',
                    'text-gray-500': path !== '/admin/transfer',
                }"
                viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M900.64 356.27c0.02-0.13 0.13-0.21 0.14-0.34-0.02 0.13-0.12 0.22-0.14 0.34z"
                        fill="currentColor"></path>
                    <path d="M731.58 182.45H109.87v475.43h621.71V182.45z m-73.14 402.28H183.01V255.59h475.43v329.14z"
                        fill="currentColor"></path>
                    <path
                        d="M768.12 438.98h72.5v329.14H365.85v-73.17H292.7v146.32h621.06V365.84H768.12zM852.67 225.66l34.48 42.98 32.71-129.45-53.18-13.43-6.86 27.07c-34.34-32.29-84.7-67.37-150.21-81.07l-11.21 53.71c77.23 16.14 129.8 69.69 154.27 100.19zM176.37 800.59l-34.48-42.96-32.71 129.43 53.18 13.43 6.86-27.09c34.34 32.29 84.71 67.41 150.23 81.09l11.21-53.71c-77.22-16.12-129.81-69.69-154.29-100.19zM322.74 365.95v54.85h70.55v23.91h-68.35v54.86h68.35v65.93h54.86v-65.93h68.38v-54.86h-68.38V420.8h70.57v-54.85h-39.24l50.44-50.43-38.79-38.79-70.41 70.39-70.39-70.39-38.79 38.79 50.43 50.43z"
                        fill="currentColor"></path>
                </g>
            </svg>
            <p class="text-base"
                :class="{
                    'text-blue-700': path === '/admin/transfer',
                    'text-gray-500': path !== '/admin/transfer',
                }">
                Transfer
            </p>
        </div>

        <div x-data="{ path: window.location.pathname }"
            class="flex cursor-pointer select-none flex-row items-center gap-x-2 rounded-md border-2 px-4 py-2 shadow-md transition-all"
            :class="{
                'border-blue-500/30 bg-blue-500/30 hover:bg-blue-500/15': path === '/admin/buy',
                'border-gray-500/30 bg-white hover:bg-gray-500/20': path !== '/admin/buy',
            }"
            @click="if (path !== '/admin/buy') { NProgress.start(); window.location = '/admin/buy'; NProgress.done(); }">
            <svg class="w-[25px]"
                :class="{
                    'text-blue-700': path === '/admin/buy',
                    'text-gray-500': path !== '/admin/buy',
                }"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor">
                    </path>
                </g>
            </svg>
            <p class="text-base"
                :class="{
                    'text-blue-700': path === '/admin/buy',
                    'text-gray-500': path !== '/admin/buy',
                }">
                Pembelian
            </p>
        </div>

        <flux:spacer />
        <div x-data="{ avatar: '{{ auth()->user()->avatar }}', open: false, logout() { $refs.logoutForm.submit() } }" class="relative flex h-[150px] items-end" @click.away="open=false">
            <form x-ref="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
            <div class="relative flex w-full flex-row items-center gap-y-1 rounded-2xl border border-blue-500 bg-white p-2"
                style="box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.1);">
                <template x-if="avatar.length == 0">
                    <div
                        class="flex h-[37px] w-[37px] items-center justify-center overflow-hidden rounded-full bg-blue-500/50 p-1">
                        <svg class="w-[25px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                <div class="flex w-[80%] flex-row items-center justify-between">
                    <p class="ml-2 truncate text-base font-semibold text-blue-500">
                        {{ auth()->user()->name }}
                    </p>
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
                </div>
            </div>
            <div x-show="open"
                class="animate-fade absolute top-0 w-full select-none rounded-md bg-white px-2 py-2 shadow-xl">
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
    </flux:sidebar>
    <flux:header class="items-center justify-between lg:hidden">
        <flux:sidebar.toggle
            class="text-gray-500! cursor-pointer border transition-all hover:border-gray-400/50 hover:shadow-md"
            icon="bars-2" inset="left" />
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
                        <svg class="w-[25px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
    </flux:header>
    {{ $slot }}
    <livewire:component.notifacation />
    @fluxScripts
</body>

</html>
