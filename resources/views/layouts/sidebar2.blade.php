<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Sidebar Wrapper with White Background -->
<div
    style="background-color: #ffffff; padding: 15px; margin-top: 15px; height: 100vh; overflow-y: auto; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">


    <nav class="mt-10">
        <div x-data="{ open: false }">

            <x-sidebar-item :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                style="font-size: 18px;">
                <i class="fas fa-tachometer-alt" style="margin-right: 10px;"></i> {{ __('Dashboard') }}
            </x-sidebar-item>

            <x-sidebar-item :href="route('packages.index')" :active="request()->routeIs('packages.index')"
                style="font-size: 18px;">
                <i class="fas fa-box" style="margin-right: 10px;"></i> {{ __('Packages') }}
            </x-sidebar-item>
            @if(optional(auth()->user()->user_limit)->customer_view == 1)
                <x-sidebar-item :href="route('users.index')" :active="request()->routeIs('users.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-users" style="margin-right: 10px;"></i> {{ __('Customer') }}
                </x-sidebar-item>
            @endif
            @if(optional(auth()->user()->user_limit)->transaction_view == 1)
                <x-sidebar-item :href="route('transaction.index')" :active="request()->routeIs('transaction.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-exchange-alt" style="margin-right: 10px;"></i> {{ __('Transaction') }}
                </x-sidebar-item>
            @endif



            @if(optional(auth()->user()->user_limit)->user_management_view == 1)
                <x-sidebar-item :href="route('user-management.index')" :active="request()->routeIs('user-management.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-user-shield" style="margin-right: 10px;"></i> {{ __('User Management') }}
                </x-sidebar-item>
            @endif
            @if(optional(auth()->user()->user_limit)->transaction_view == 1)
                <x-sidebar-item :href="route('ticket.index')" :active="request()->routeIs('ticket.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-ticket-alt" style="margin-right: 10px;"></i> {{ __('Ticket') }}
                </x-sidebar-item>
            @endif


                @if(optional(auth()->user()->user_limit)->tickets_view == 1)
                    <x-sidebar-item :href="route('ticket.index')" :active="request()->routeIs('ticket.index')" style="font-size: 18px;">
                        <i class="fas fa-ticket-alt" style="margin-right: 10px;"></i> {{ __('Ticket') }}
                    </x-sidebar-item>
                @endif

                @if(optional(auth()->user()->user_limit)->router_view == 1)
                    <x-sidebar-item :href="route('router.index')" :active="request()->routeIs('router.index')" style="font-size: 18px;">
                        <i class="fas fa-wifi" style="margin-right: 10px;"></i> {{ __('Router') }}
                    </x-sidebar-item>
                @endif
                
            @if(auth()->user()->isAdmin())



                <x-sidebar-item :href="route('users.index')" :active="request()->routeIs('users.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-users" style="margin-right: 10px;"></i> {{ __('Customer') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('transaction.index')" :active="request()->routeIs('transaction.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-exchange-alt" style="margin-right: 10px;"></i> {{ __('Transaction') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('company.edit')" :active="request()->routeIs('company.edit')"
                    style="font-size: 18px;">
                    <i class="fas fa-building" style="margin-right: 10px;"></i> {{ __('ISPs') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('router.index')" :active="request()->routeIs('router.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-wifi" style="margin-right: 10px;"></i> {{ __('Router') }}
                </x-sidebar-item>

                <x-sidebar-item :href="route('user-management.index')" :active="request()->routeIs('user-management.index')"
                    style="font-size: 18px;">
                    <i class="fas fa-user-shield" style="margin-right: 10px;"></i> {{ __('User Management') }}
                </x-sidebar-item>
            @endif

            <x-sidebar-item :href="route('ticket.index')" :active="request()->routeIs('ticket.index')"
                style="font-size: 18px;">
                <i class="fas fa-ticket-alt" style="margin-right: 10px;"></i> {{ __('Ticket') }}
            </x-sidebar-item>

        </div>
    </nav>
</div>
