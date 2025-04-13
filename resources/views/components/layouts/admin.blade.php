<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-theme="light">

<head>
    @include('partials.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
</head>

<body class="bg-white">
    <flux:sidebar sticky stashable class="bg-white!">
        <div class="text-right">
            <flux:sidebar.toggle
                class="text-gray-500! cursor-pointer border transition-all hover:border-gray-400/50 hover:shadow-md lg:hidden"
                icon="x-mark" />
        </div>
        <div class="text-xl font-bold text-purple-700">MineWallet</div>
    </flux:sidebar>
    <flux:header>
        <flux:sidebar.toggle
            class="text-gray-500! cursor-pointer border transition-all hover:border-gray-400/50 hover:shadow-md lg:hidden"
            icon="bars-2" inset="left" />
    </flux:header>
    {{ $slot }}
    <livewire:component.notifacation />
    @fluxScripts
</body>

</html>
