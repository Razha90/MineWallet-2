<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Transaction;
use App\Models\TopUp;
use Illuminate\Support\Facades\Log;
use App\Notifications\TopUpNotification;

new #[Layout('components.layouts.payment')] class extends Component {
    public $type;
    public $id;

    public function mount()
    {
        $this->type = session('type');
        $this->id = session('id');
    }

    public function prosesPembayaran($pin)
    {
        try {
            $user = auth()->user();
            if ($pin == $user->pin) {
            } else {
                $this->dispatch('failed', ['message' => 'Pin Salah, Silahkan Coba Lagi']);
                return ['con' => false];
            }
            if ($this->type == 'TOPUP') {
                $topup = TopUp::where('id', $this->id)->first();
                if ($topup) {
                    $topup->update([
                        'status' => 'pending',
                    ]);
                    $topup->save();
                    $this->dispatch('success', ['message' => 'Berhasil Melakukan Pembayaran']);
                    auth()->user()->notify(new TopUpNotification('<h1>Silakan Lakukan Pembayaran</h1>  <p>Lakukan Pembayaran untuk merakasa kepuasaan menggunakan MineWallet</p>', $topup->id));
                    redirect()->route('detail.topup', ['id' => $topup->id]);
                    return ['con' => true];
                } else {
                    $this->dispatch('failed', ['message' => 'Top Up tidak ditemukan']);
                    $this->dispatch('cooler');
                    return ['con' => false];
                }
            }
        } catch (\Throwable $th) {
            Log::error('Error in prosesPembayaran method: ' . $th->getMessage());
            $this->dispatch('failed', ['message' => 'Terdapat Masalah Pada Server, Coba Beberapa Saat Lagi.']);
            return ['con' => false];
        }
    }

    public function nextTransaction()
    {
        try {
            $latestTransaction = Transaction::orderBy('created_at', 'desc')->first();
            $latestTopUp = TopUp::orderBy('created_at', 'desc')->first();

            if ($latestTransaction && $latestTopUp) {
                if ($latestTransaction > $latestTopUp) {
                    return redirect()->route('payment.detail-payment', ['id' => $latestTopUp->id]);
                } else {
                    return redirect()->route('payment.detail-transaction', ['id' => $latestTransaction->id]);
                }
            } elseif ($latestTransaction) {
                return redirect()->route('payment.detail-transaction', ['id' => $latestTransaction->id]);
            } elseif ($latestTopUp) {
                return redirect()->route('payment.detail-payment', ['id' => $latestTopUp->id]);
            } else {
                $this->js("
                NProgress.start();
                const ref = document.referrer;
                const currentHost = window.location.hostname;

                if (ref && new URL(ref).hostname === currentHost) {
                    history.back();
                } else {
                    window.location.href = '/';
                }
                NProgress.done();
                ");
                return;
            }
        } catch (\Throwable $th) {
            Log::error('Error Next Pin: ' . $th->getMessage());
            $this->dispatch('failed', ['message' => 'Gagal Membuat Pin, Coba Lagi Beberapa Saat.']);
            return;
        }
    }
}; ?>

<div x-data="initCreatePin" x-init="initPin">
    <div x-cloak x-data="{ show: false }" x-on:cooler.window="(event) => {
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
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
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
                        <svg class="w-[150px] text-blue-500" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M14.5 16.5H16.1152C16.9825 16.5 17.7946 16.0745 18.2883 15.3614L21.6315 10.5323C21.8588 10.204 21.889 9.77803 21.7105 9.42094C21.3678 8.73545 20.4444 8.60613 19.9265 9.17109L17.2727 12.0661C16.2059 13.23 14.5301 13.612 13.0643 13.0257L9.44043 11.5762C8.53873 11.2155 7.51727 11.3218 6.70922 11.8605L2.87237 14.4184C2.37401 14.7507 2.20104 15.402 2.4689 15.9377C2.76223 16.5244 3.47562 16.7622 4.06229 16.4689L7.24772 14.8762C7.86821 14.5659 8.54577 15.1811 8.29674 15.8286L6.50003 20.5M7.00003 4H4.00003M6.00003 7H4.00003M18 6.5C18 8.70914 16.2092 10.5 14 10.5C11.7909 10.5 10 8.70914 10 6.5C10 4.29086 11.7909 2.5 14 2.5C16.2092 2.5 18 4.29086 18 6.5Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.4">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <p class="text-center text-lg text-blue-500">Maaf sesi anda telah habis untuk melanjutkan pembayaran
                    </p>
                    <button @click="back"
                        class="mt-2 cursor-pointer rounded-md border-2 bg-blue-500 px-6 py-2 text-xl text-white transition-all hover:border-blue-500 hover:bg-white hover:text-blue-500">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-data="{ show: false }" x-on:ask-question.window="(event) => {
        show = true;
    }"
        x-show="show"
        class="bg-secondary_black/20 animate-fade fixed left-0 right-0 top-0 z-30 flex h-screen max-h-screen w-full items-center justify-center overflow-y-auto overflow-x-hidden backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t px-4 pb-2 pt-4">
                    <h3 class="text-xl font-semibold text-blue-500">
                    </h3>
                    <button type="button" @click="back"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
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
                        <svg class="w-[150px] text-green-500" viewBox="0 0 512 512" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            fill="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title>success-filled</title>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="add-copy-2" fill="currentColor" transform="translate(42.666667, 42.666667)">
                                        <path
                                            d="M213.333333,3.55271368e-14 C95.51296,3.55271368e-14 3.55271368e-14,95.51296 3.55271368e-14,213.333333 C3.55271368e-14,331.153707 95.51296,426.666667 213.333333,426.666667 C331.153707,426.666667 426.666667,331.153707 426.666667,213.333333 C426.666667,95.51296 331.153707,3.55271368e-14 213.333333,3.55271368e-14 Z M293.669333,137.114453 L323.835947,167.281067 L192,299.66912 L112.916693,220.585813 L143.083307,190.4192 L192,239.335893 L293.669333,137.114453 Z"
                                            id="Shape"> </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <p class="text-center text-lg text-blue-500">Telah Berhasil Membuat Pin, Lanjutkan Transaksi atau
                        Kembali.</p>
                    <div>
                        <button @click="back"
                            class="mt-2 cursor-pointer rounded-md border-2 bg-blue-500 px-6 py-2 text-xl text-white transition-all hover:border-blue-500 hover:bg-white hover:text-blue-500">
                            Kembali
                        </button>
                        <button @click="nextTransaction" :disabled="isLoading"
                            class="mt-2 cursor-pointer rounded-md border-2 bg-green-500 px-6 py-2 text-xl text-white transition-all hover:border-green-500 hover:bg-white hover:text-green-500 disabled:cursor-not-allowed disabled:opacity-50">
                            Lanjutkan Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-data="{ show: false }" x-on:ask-success.window="(event) => {
        show = true;
    }"
        x-show="show"
        class="bg-secondary_black/20 animate-fade fixed left-0 right-0 top-0 z-30 flex h-screen max-h-screen w-full items-center justify-center overflow-y-auto overflow-x-hidden backdrop-blur-sm md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t px-4 pb-2 pt-4">
                    <h3 class="text-xl font-semibold text-blue-500">
                    </h3>
                    <button type="button" @click="back"
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
                <div class="flex flex-col items-center gap-y-2 px-4 pb-4">
                    <div>
                        <svg class="w-[150px] text-green-500" viewBox="0 0 512 512" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            fill="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title>success-filled</title>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <g id="add-copy-2" fill="currentColor"
                                        transform="translate(42.666667, 42.666667)">
                                        <path
                                            d="M213.333333,3.55271368e-14 C95.51296,3.55271368e-14 3.55271368e-14,95.51296 3.55271368e-14,213.333333 C3.55271368e-14,331.153707 95.51296,426.666667 213.333333,426.666667 C331.153707,426.666667 426.666667,331.153707 426.666667,213.333333 C426.666667,95.51296 331.153707,3.55271368e-14 213.333333,3.55271368e-14 Z M293.669333,137.114453 L323.835947,167.281067 L192,299.66912 L112.916693,220.585813 L143.083307,190.4192 L192,239.335893 L293.669333,137.114453 Z"
                                            id="Shape"> </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <p class="text-center text-lg text-blue-500">Pin Berhasil.</p>
                    <div>
                        <button @click="nextTransaction"
                            class="mt-2 cursor-pointer rounded-md border-2 bg-green-500 px-6 py-2 text-xl text-white transition-all hover:border-green-500 hover:bg-white hover:text-green-500 disabled:cursor-not-allowed disabled:opacity-50">
                            Lanjutkan Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto mt-[3%] max-w-lg select-none" x-init="initCreatePin">
        <h1 class="mb-12 text-center text-4xl font-bold text-purple-600">Konfirmasi Pembelian</h1>
        <div class="flex flex-row justify-around">
            <template x-for="item in 6">
                <div class="flex h-[70px] w-[70px] cursor-pointer items-center justify-center rounded-xl border-2 p-2 text-6xl font-bold transition-all hover:border-purple-600 hover:bg-purple-200 hover:text-purple-600"
                    :class="{
                        'bg-purple-200 border-purple-600 text-purple-600': pins.length == item -
                            1,
                        'bg-white border-gray-300 text-gray-500': pins.length != item - 1
                    }"
                    x-text="obsecure[item-1]">
                </div>
            </template>
        </div>
        <div class="mx-auto mt-10 flex w-[70%] flex-row justify-between">
            <template x-for="(item, index) in pinsButton1" :key="index">
                <div class="flex h-[90px] w-[90px] cursor-pointer items-center justify-center rounded-xl border-2 border-gray-300 p-2 text-6xl font-bold text-gray-500 transition-all hover:border-purple-600 hover:bg-purple-200 hover:text-purple-600"
                    x-text="item" @click="pins = pins + item">
                </div>
            </template>
        </div>
        <div class="mx-auto mt-10 flex w-[70%] flex-row justify-between">
            <template x-for="(item, index) in pinsButton2" :key="index">
                <div class="flex h-[90px] w-[90px] cursor-pointer items-center justify-center rounded-xl border-2 border-gray-300 p-2 text-6xl font-bold text-gray-500 transition-all hover:border-purple-600 hover:bg-purple-200 hover:text-purple-600"
                    x-text="item" @click="pins = pins + item">
                </div>
            </template>
        </div>
        <div class="mx-auto mt-10 flex w-[70%] flex-row justify-between">
            <template x-for="(item, index) in pinsButton3" :key="index">
                <div class="flex h-[90px] w-[90px] cursor-pointer items-center justify-center rounded-xl border-2 border-gray-300 p-2 text-6xl font-bold text-gray-500 transition-all hover:border-purple-600 hover:bg-purple-200 hover:text-purple-600"
                    x-text="item" @click="pins = pins + item">
                </div>
            </template>
        </div>
        <div class="mx-auto mt-10 flex w-[70%] flex-row justify-between">
            <div class="flex h-[90px] w-[90px] cursor-pointer items-center justify-center rounded-xl border-2 border-gray-300 p-2 text-6xl font-bold text-gray-500 transition-all hover:border-purple-600 hover:bg-purple-200 hover:text-purple-600"
                x-text="0" @click="pins = pins + 0">
            </div>
            <div class="flex h-[90px] w-[90px] cursor-pointer items-center justify-center rounded-xl border-2 border-gray-300 p-2 text-6xl font-bold text-gray-500 transition-all hover:border-red-500 hover:bg-red-200 hover:text-red-500"
                @click="pins = pins.slice(0, -1)">
                <svg viewBox="0 -5 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                    fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>delete</title>
                        <desc>Created with Sketch Beta.</desc>
                        <defs> </defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup"
                                transform="translate(-516.000000, -1144.000000)" fill="currentColor">
                                <path
                                    d="M538.708,1151.28 C538.314,1150.89 537.676,1150.89 537.281,1151.28 L534.981,1153.58 L532.742,1151.34 C532.352,1150.95 531.718,1150.95 531.327,1151.34 C530.936,1151.73 530.936,1152.37 531.327,1152.76 L533.566,1154.99 L531.298,1157.26 C530.904,1157.65 530.904,1158.29 531.298,1158.69 C531.692,1159.08 532.331,1159.08 532.725,1158.69 L534.993,1156.42 L537.232,1158.66 C537.623,1159.05 538.257,1159.05 538.647,1158.66 C539.039,1158.27 539.039,1157.63 538.647,1157.24 L536.408,1155.01 L538.708,1152.71 C539.103,1152.31 539.103,1151.68 538.708,1151.28 L538.708,1151.28 Z M545.998,1162 C545.998,1163.1 545.102,1164 543.996,1164 L526.467,1164 L518.316,1154.98 L526.438,1146 L543.996,1146 C545.102,1146 545.998,1146.9 545.998,1148 L545.998,1162 L545.998,1162 Z M543.996,1144 L526.051,1144 C525.771,1143.98 525.485,1144.07 525.271,1144.28 L516.285,1154.22 C516.074,1154.43 515.983,1154.71 515.998,1154.98 C515.983,1155.26 516.074,1155.54 516.285,1155.75 L525.271,1165.69 C525.467,1165.88 525.723,1165.98 525.979,1165.98 L525.979,1166 L543.996,1166 C546.207,1166 548,1164.21 548,1162 L548,1148 C548,1145.79 546.207,1144 543.996,1144 L543.996,1144 Z"
                                    id="delete" sketch:type="MSShapeGroup"> </path>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </div>
</div>
<script>
    function initCreatePin() {
        return {
            type: @entangle('type').live,
            id: @entangle('id').live,
            pinsButton1: [1, 2, 3],
            pinsButton2: [4, 5, 6],
            pinsButton3: [7, 8, 9],
            pins: "",
            obsecure: "",
            isLoading: false,
            stopInit: false,
            async nextTransaction() {
                await this.$wire.nextTransaction();
            },
            async initCreatePin() {
                if (this.stopInit) return;
                this.stopInit = true;
                this.$watch('pins', async (value) => {
                    this.obsecure = '*'.repeat(value.length);
                    if (value.length >= 6) {
                        const res = await this.$wire.prosesPembayaran(value);
                        console.log(res);
                        if (res.con) {

                        } else {
                            this.pins = '';
                        }
                    }
                })
            },
            inputPin(pin) {
                if (this.pins.length >= 6) {
                    return;
                }
                this.pins = this.pins + pin;
            },
            initPin() {
                setTimeout(() => {
                    if (this.type === '' || this.type === null || this.type === undefined || this.id === '' ||
                        this.id === null || this.id === undefined) {
                        this.$dispatch('cooler');
                    }

                }, 1000);
            },
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
        }
    }
</script>
