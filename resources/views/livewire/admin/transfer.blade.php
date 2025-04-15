<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Topup;
use App\Models\User;
use App\Notifications\TopUpNotification;
use App\Notifications\TransferMailNotification;
use App\Models\Transfer;
new #[Layout('components.layouts.admin')] class extends Component {
    public $topups;
    public function mount()
    {
        $this->getTopUp();
    }

    public function getTopUp()
    {
        $this->topups = Transfer::with(['sender', 'bank'])
            ->where('status', '!=', 'waiting')
            ->orderByRaw("FIELD(status, 'pending', 'success', 'failed')")
            ->get()
            ->toArray();
    }

    public function approved($id)
    {
        $topup = Transfer::find($id);
        if ($topup) {
            $topup->status = 'approved';
            $topup->save();

            $user = User::find($topup->sender_id);
            if ($user->saldo) {
                $user->saldo = $topup->amount;
            } else {
                $user->saldo += $topup->amount;
            }
            $user->save();

            $user->notify(new TransferMailNotification('<h1>Tranfer Telah Berhasil</h1><p>Transfer kamu sebesar Rp ' . number_format($topup->amount, 0, ',', '.') . ' telah berhasil.</p>', $topup->id, $topup->amount));

            $this->getTopUp();
        }
    }

    public function rejected($id)
    {
        $topup = Transfer::find($id);
        if ($topup) {
            $topup->status = 'failed';
            $topup->save();

            $user = User::find($topup->user_id);
            $user->notify(new TransferMailNotification('<h1>Transfer Gagal</h1><p>Transfer kamu sebesar Rp ' . number_format($topup->amount, 0, ',', '.') . ' gagal, dengan beberapa alasan.</p>', $topup->id, $topup->amount));
            $this->getTopUp();
        }
    }

    public function deleteTopUp($id)
    {
        $topup = Transfer::find($id);
        if ($topup) {
            $topup->delete();
            $this->getTopUp();
        }
    }
}; ?>

<flux:main x-data="adminTopUp" x-init="init" class="p-4">
    <h1 class="mb-6 text-2xl font-bold text-blue-600">Top Up</h1>

    <div class="overflow-x-auto rounded-xl bg-white shadow">
        <table class="min-w-full text-left text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                    <th class="px-6 py-4">Hapus</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in topups" :key="item.id">
                    <tr class="border-b hover:bg-gray-50"
                        :class="{
                            'bg-yellow-50': item.status == 'pending',
                            'bg-green-50': item.status == 'success',
                            'bg-red-50': item.status == 'failed',
                        }">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="font-medium text-gray-900" x-text="item.sender.name"></div>
                            <div class="text-xs text-gray-400" x-text="item.sender.email"></div>
                        </td>
                        <template x-if="item.bank">
                            <td class="whitespace-nowrap px-6 py-4">
                                Rp <span x-text="formatRupiah(Number(item.amount) + Number(item.bank.admin))"></span>
                            </td>
                        </template>
                        <template x-if="!item.bank">
                            <td class="whitespace-nowrap px-6 py-4">
                                Rp <span x-text="formatRupiah(Number(item.amount))"></span>
                            </td>
                        </template>

                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold"
                                :class="{
                                    'bg-yellow-100 text-yellow-800': item.status == 'pending',
                                    'bg-green-100 text-green-800': item.status == 'success',
                                    'bg-red-100 text-red-800': item.status == 'failed',
                                }"
                                x-text="item.status.charAt(0).toUpperCase() + item.status.slice(1)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <template x-if="item.status == 'pending'">
                                <div class="flex gap-2">
                                    <button @click="approved(item.id)"
                                        class="rounded-lg bg-green-500 px-3 py-1 text-xs font-medium text-white hover:bg-green-600">
                                        Approve
                                    </button>
                                    <button @click="rejected(item.id)"
                                        class="rounded-lg bg-red-500 px-3 py-1 text-xs font-medium text-white hover:bg-red-600">
                                        Reject
                                    </button>
                                </div>
                            </template>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="deleteTopUp(item.id)">
                                <svg class="h-5 w-5 text-red-500 hover:text-red-700" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V8zM4 5h12v1H4V5zm3-2a1 1 0 00-1 1v1h8V4a1 1 0 00-1-1H7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <p class="mt-4 text-sm text-gray-500">Menampilkan <span x-text="topups.length"></span> data top up.</p>
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
