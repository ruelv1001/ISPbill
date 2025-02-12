<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<div class="w-64 min-h-screen bg-white hidden md:block">
    <nav class="mt-10">
        <div x-data="{ open: false }">

            <x-sidebar-item :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fas fa-tachometer-alt" style="margin-right: 10px;"></i> {{ __('Dashboard') }}
            </x-sidebar-item>

            <x-sidebar-item :href="route('packages.index')" :active="request()->routeIs('packages.index')">
                <i class="fas fa-box" style="margin-right: 10px;"></i> {{ __('Packages') }}
            </x-sidebar-item>

            @if(auth()->user()->isAdmin())
                <x-sidebar-item :href="route('users.index')" :active="request()->routeIs('users.index')">
                    <i class="fas fa-users" style="margin-right: 10px;"></i> {{ __('Customer') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('transaction.index')" :active="request()->routeIs('transaction.index')">
                    <i class="fas fa-exchange-alt" style="margin-right: 10px;"></i> {{ __('Transaction') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('company.edit')" :active="request()->routeIs('company.edit')">
                    <i class="fas fa-building" style="margin-right: 10px;"></i> {{ __('ISPs') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('router.index')" :active="request()->routeIs('router.index')">
                    <i class="fas fa-wifi" style="margin-right: 10px;"></i> {{ __('Router') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('user-management.index')"
                    :active="request()->routeIs('user-management.index')">
                    <i class="fas fa-user-shield" style="margin-right: 10px;"></i> {{ __('User Management') }}
                </x-sidebar-item>
            @endif

            <x-sidebar-item :href="route('ticket.index')" :active="request()->routeIs('ticket.index')">
                <i class="fas fa-ticket-alt" style="margin-right: 10px;"></i> {{ __('Ticket') }}
            </x-sidebar-item>

        </div>
    </nav>
</div>
