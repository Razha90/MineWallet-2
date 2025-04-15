<?php
 
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Topup;
use App\Models\User;
use App\Notifications\TopUpMailNotification;
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
 
            $user->notify(new TopUpMailNotification('<h1>Top Up Berhasil Disetujui</h1><p>Top up kamu sebesar Rp ' . number_format($topup->amount, 0, ',', '.') . ' telah disetujui.</p>', $topup->id, $topup->amount));
 
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
            $user->notify(new TopUpMailNotification('<h1>Top Up Gagal</h1><p>Top up kamu sebesar Rp ' . number_format($topup->amount, 0, ',', '.') . ' gagal.</p>', $topup->id, $topup->amount));
 
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
 
<flux:main x-data="adminTopUp" x-init="init" class="p-4">
    <h1 class="text-2xl font-bold text-blue-600 mb-6">Top Up</h1>
 
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full text-sm text-left text-gray-700">
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900" x-text="item.user.name"></div>
                            <div class="text-xs text-gray-400" x-text="item.user.email"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            Rp <span x-text="formatRupiah(Number(item.amount) + Number(item.admin))"></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold"
                                :class="{
                                    'bg-yellow-100 text-yellow-800': item.status == 'pending',
                                    'bg-green-100 text-green-800': item.status == 'success',
                                    'bg-red-100 text-red-800': item.status == 'failed',
                                }"
                                x-text="item.status.charAt(0).toUpperCase() + item.status.slice(1)"
                            ></span>
                        </td>
                        <td class="px-6 py-4">
                            <template x-if="item.status == 'pending'">
                                <div class="flex gap-2">
                                    <button @click="approved(item.id)"
                                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-medium px-3 py-1 rounded-lg">
                                        Approve
                                    </button>
                                    <button @click="rejected(item.id)"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs font-medium px-3 py-1 rounded-lg">
                                        Reject
                                    </button>
                                </div>
                            </template>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="deleteTopUp(item.id)">
                                <svg class="w-5 h-5 text-red-500 hover:text-red-700" fill="currentColor"
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