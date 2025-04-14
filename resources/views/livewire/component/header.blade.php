<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Log;

new class extends Component {
    public $notifications;
    public function mount()
    {
        $this->notifications = auth()->user()->notifications->toArray();
    }

    public function readMessage($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->notifications = auth()->user()->notifications->toArray();
        }
    }

    public function deleteMessage($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
            $this->notifications = auth()->user()->notifications->toArray();
        }
    }
}; ?>

<flux:header class="shadow-xl">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between" x-data="initHeader"
        x-init="initHead">
        <div>
            <a href="/">
                <img src="{{ asset('images/Bold_Modern_Brand_Name_Initial_Signature_Logo_-_revisi-removebg-preview.png') }}"
                    alt="MineWallet Logo" class="h-18 w-18 rounded-full">
            </a>
        </div>
        <div class="flex flex-row items-center justify-end">
            <div class="relative cursor-pointer" @click="notif_show = true">
                <svg class="w-[35px] text-gray-400" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.31317 12.463C6.20006 9.29213 8.60976 6.6252 11.701 6.5C14.7923 6.6252 17.202 9.29213 17.0889 12.463C17.0889 13.78 18.4841 15.063 18.525 16.383C18.525 16.4017 18.525 16.4203 18.525 16.439C18.5552 17.2847 17.9124 17.9959 17.0879 18.029H13.9757C13.9786 18.677 13.7404 19.3018 13.3098 19.776C12.8957 20.2372 12.3123 20.4996 11.701 20.4996C11.0897 20.4996 10.5064 20.2372 10.0923 19.776C9.66161 19.3018 9.42346 18.677 9.42635 18.029H6.31317C5.48869 17.9959 4.84583 17.2847 4.87602 16.439C4.87602 16.4203 4.87602 16.4017 4.87602 16.383C4.91795 15.067 6.31317 13.781 6.31317 12.463Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                        <path
                            d="M9.42633 17.279C9.01212 17.279 8.67633 17.6148 8.67633 18.029C8.67633 18.4432 9.01212 18.779 9.42633 18.779V17.279ZM13.9757 18.779C14.3899 18.779 14.7257 18.4432 14.7257 18.029C14.7257 17.6148 14.3899 17.279 13.9757 17.279V18.779ZM12.676 5.25C13.0902 5.25 13.426 4.91421 13.426 4.5C13.426 4.08579 13.0902 3.75 12.676 3.75V5.25ZM10.726 3.75C10.3118 3.75 9.97601 4.08579 9.97601 4.5C9.97601 4.91421 10.3118 5.25 10.726 5.25V3.75ZM9.42633 18.779H13.9757V17.279H9.42633V18.779ZM12.676 3.75H10.726V5.25H12.676V3.75Z"
                            fill="currentColor"></path>
                    </g>
                </svg>
                <div x-show="notifications.filter(n => n.read_at === null).length > 0"
                    class="absolute right-0 top-0 h-[12px] w-[12px] animate-pulse rounded-full bg-red-500">
                </div>

            </div>
            <div x-data="{ avatar: '{{ auth()->user()->avatar }}', open: false, logout() { $refs.logoutForm.submit() } }" class="relative z-30 flex items-end text-right" @click.away="open=false">
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
                    class="animate-fade absolute -bottom-[130px] w-full select-none rounded-md bg-white px-2 py-2 shadow-xl">
                    <div @click="NProgress.start(); window.location = '{{ route('profile') }}'; NProgress.done();"
                        class="cursor-pointer rounded-xl p-2 text-center text-blue-500 transition-all hover:bg-blue-500/20">
                        Profil Saya
                    </div>
                    @auth
                        @if (auth()->user()->role == 'admin')
                            <div @click="NProgress.start(); window.location = '{{ route('admin.topup') }}'; NProgress.done();"
                                class="cursor-pointer rounded-xl p-2 text-center text-blue-500 transition-all hover:bg-blue-500/20">
                                Dashboard Admin
                            </div>
                        @endif
                    @endauth
                    <div @click="logout"
                        class="cursor-pointer rounded-xl p-2 text-center text-red-500 transition-all hover:bg-red-500/20">
                        Keluar
                    </div>
                </div>
            </div>
        </div>

        <div x-show="notif_show"
            class="bg-secondary_black/20 animate-fade fixed left-0 right-0 top-0 z-30 flex h-screen max-h-screen w-full items-center justify-center overflow-y-auto overflow-x-hidden backdrop-blur-sm md:inset-0">
            <div class="relative max-h-full w-full max-w-md p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow-2xl" @click.away="notif_show = false">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t px-4 pb-2 pt-4">
                        <h3 class="text-xl font-semibold text-blue-500">Notifikasi
                        </h3>
                        <button type="button" @click="notif_show = false"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                            data-modal-toggle="crud-modal">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div
                        class="flex h-[400px] max-h-[400px] flex-col items-center gap-y-2 overflow-y-scroll px-4 pb-4">
                        <template x-for="(item, index) in notifications">
                            <div class="relative w-full rounded-xl border-2 p-3"
                                :class="{
                                    'bg-amber-200/20 border-amber-400 text-blue-400': item.read_at == null,
                                    'bg-gray-200/50 border-gray-400 text-gray-400': item.read_at != null,
                                }">
                                <div x-html="item.data.data"
                                    @click="readMessage(item.read_at, item.id, item.data.url)">

                                </div>
                                <div class="absolute right-0 top-0" @click="deleteMessage(item.id)">
                                    <svg class="w-[15px] cursor-pointer text-red-500" viewBox="0 -0.5 21 21"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>delete [#1487]</title>
                                            <desc>Created with Sketch.</desc>
                                            <defs> </defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <g id="Dribbble-Light-Preview"
                                                    transform="translate(-179.000000, -360.000000)"
                                                    fill="currentColor">
                                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                                        <path
                                                            d="M130.35,216 L132.45,216 L132.45,208 L130.35,208 L130.35,216 Z M134.55,216 L136.65,216 L136.65,208 L134.55,208 L134.55,216 Z M128.25,218 L138.75,218 L138.75,206 L128.25,206 L128.25,218 Z M130.35,204 L136.65,204 L136.65,202 L130.35,202 L130.35,204 Z M138.75,204 L138.75,200 L128.25,200 L128.25,204 L123,204 L123,206 L126.15,206 L126.15,220 L140.85,220 L140.85,206 L144,206 L144,204 L138.75,204 Z"
                                                            id="delete-[#1487]"> </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </template>
                        <template x-if="notifications.length == 0">
                            <div class="flex w-full items-center justify-center rounded-xl border-2 p-3 text-gray-400">
                                Tidak ada notifikasi
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</flux:header>
<script>
    function initHeader() {
        return {
            notifications: @entangle('notifications').live,
            initHead() {
                console.log(this.notifications);
            },
            notif_show: false,
            async readMessage(condition, id, url) {
                if (condition == null) {
                    await this.$wire.readMessage(id);
                    window.location.href = url;
                } else {
                    window.location.href = url;
                }
            },
            async deleteMessage(id) {
                await this.$wire.deleteMessage(id);
            },
        }
    }
</script>
