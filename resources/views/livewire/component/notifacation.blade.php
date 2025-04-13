<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>

</div>
@script
    <script>
        const userId = {{ auth()->user()->id }};
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('📨 Broadcast notification received:', notification);
            })
            .subscribed(() => {
                console.log('✅ Berhasil subscribe ke channel user');
            })
            .error((error) => {
                console.error('❌ Gagal subscribe ke channel:', error);
            });
    
    </script>
@endscript
