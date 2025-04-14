<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Topup;
use App\Models\User;
use App\Notifications\TopUpNotification;
new #[Layout('components.layouts.admin')] class extends Component {
    public $topups;
    public function mount()
    {
        $this->getTopUp();
    }

    public function getTopUp()
    {
        $this->topups = Topup::with(['user', 'bank'])
            ->where('status', '!=', 'waiting')
            ->orderByRaw("FIELD(status, 'pending', 'success', 'failed')")
            ->get()
            ->toArray();
    }

    public function approved($id)
    {
        $topup = Topup::find($id);
        if ($topup) {
            $topup->status = 'success';
            $topup->save();

            $user = User::find($topup->user_id);
            $user->saldo += $topup->amount;
            $user->save();

            $user->notify(new TopUpNotification('<h1>Top Up Berhasil Disetujui</h1><p>Top up kamu sebesar Rp ' . number_format($topup->amount, 0, ',', '.') . ' telah disetujui.</p>', $topup->id));

            $this->getTopUp();
        }
    }

    public function rejected($id)
    {
        $topup = Topup::find($id);
        if ($topup) {
            $topup->status = 'failed';
            $topup->save();

            $user = User::find($topup->user_id);
            $user->notify(new TopUpNotification('<h1>Top Up Gagal</h1><p>Top up kamu sebesar Rp ' . number_format($topup->amount, 0, ',', '.') . ' gagal.</p>', $topup->id));

            $this->getTopUp();
        }
    }

    public function deleteTopUp($id)
    {
        $topup = Topup::find($id);
        if ($topup) {
            $topup->delete();
            $this->getTopUp();
        }
    }
}; ?>

<flux:main x-data="adminTopUp" x-init="init">
    <h1 class="text-2xl font-bold text-blue-500">Top Up</h1>
    <div class="mt-8 flex flex-col gap-y-4">
        <template x-for="(item, index) in topups">
            <div class="relative w-full rounded-xl border-2 p-3"
                :class="{
                    'bg-amber-200/20 border-amber-400 text-blue-400': item.status == 'pending',
                    'bg-green-200/20 border-green-400 text-blue-400': item.status == 'success',
                    'bg-red-200/20 border-red-400 text-blue-400': item.status == 'failed',
                }">
                <div>
                    <p><span class="text-gray-500">Nama Pengguna:</span> <span x-text="item.user.name"></span></p>
                    <p>Total Rp. <span x-text="formatRupiah(Number(item.amount) + Number(item.admin))"></span></p>
                </div>
                <template x-if="item.status == 'pending'">
                    <div class="relative flex select-none flex-row items-center justify-center gap-4">
                        <div @click="approved(item.id)"
                            class="flex cursor-pointer items-center justify-center rounded-xl border-2 border-green-600 bg-green-200 p-2 text-green-600 hover:opacity-50">
                            Approve</div>
                        <div @click="rejected(item.id)"
                            class="flex items-center justify-center rounded-xl border-2 border-red-600 bg-red-200 p-2 text-red-600">
                            Rejected</div>

                    </div>
                </template>
                <div class="absolute right-0 top-0" @click="deleteTopUp(item.id)">
                    <svg class="w-[15px] cursor-pointer text-red-500" viewBox="0 -0.5 21 21" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        fill="currentColor">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                        </g>
                        <g id="SVGRepo_iconCarrier">
                            <title>delete [#1487]</title>
                            <desc>Created with Sketch.</desc>
                            <defs> </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-179.000000, -360.000000)"
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
    </div>
</flux:main>
<script>
    function adminTopUp() {
        return {
            topups: @entangle('topups').live,
            init() {
                console.log(this.topups);
            },
            formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            async approved(id) {
                await this.$wire.approved(id);
            },
            async rejected(id) {
                await this.$wire.rejected(id);
            },
            async deleteTopUp(id) {
                await this.$wire.deleteTopUp(id);
            },
        }
    }
</script>
