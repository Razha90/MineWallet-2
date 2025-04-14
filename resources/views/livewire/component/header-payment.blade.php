<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<flux:header class="shadow-xl">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between">
        <div class="flex cursor-pointer flex-row items-center"
            @click="() => {
                NProgress.start();
         const ref = document.referrer;
         const currentHost = window.location.hostname;

         if (ref && new URL(ref).hostname === currentHost) {
             history.back();
         } else {
             window.location.href = '/';
         }
         NProgress.done();
     }">
            <svg class="w-[40px] text-blue-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M14.2893 5.70708C13.8988 5.31655 13.2657 5.31655 12.8751 5.70708L7.98768 10.5993C7.20729 11.3805 7.2076 12.6463 7.98837 13.427L12.8787 18.3174C13.2693 18.7079 13.9024 18.7079 14.293 18.3174C14.6835 17.9269 14.6835 17.2937 14.293 16.9032L10.1073 12.7175C9.71678 12.327 9.71678 11.6939 10.1073 11.3033L14.2893 7.12129C14.6799 6.73077 14.6799 6.0976 14.2893 5.70708Z"
                        fill="currentColor"></path>
                </g>
            </svg>
            <p class="text-xl text-blue-500">Kembali</p>
        </div>
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
</flux:header>
