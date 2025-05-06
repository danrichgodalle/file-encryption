<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* Sidebar Background */
            .sidebar-bg {
                background: linear-gradient(180deg, #6EE7B7, #3B82F6); /* Light blue gradient */
                border-right: 1px solid #ddd;
                transition: background 0.3s ease; /* Smooth transition for background */
            }

            /* Sidebar item styles */
            .sidebar-item {
                color: white; /* White text */
                font-weight: bold; /* Bold text */
                background-color: transparent; /* Transparent by default */
                transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition for hover and active states */
            }

            /* Hover and active states */
            .sidebar-item:hover,
            .sidebar-item[aria-current="page"] {
                background-color: rgba(255, 255, 255, 0.1); /* Light hover effect */
                color: #F59E0B; /* Change text color on hover to gold */
            }

            /* Sidebar icons */
            .sidebar-icon {
                color: #E0F2FE; /* Light blue icon color */
                transition: color 0.3s ease; /* Smooth transition for icon color */
            }

            .sidebar-icon:hover {
                color: #F59E0B; /* Gold on hover */
            }

            /* Sidebar profile section */
            .sidebar-profile .flux-profile {
                background-color: #3B82F6; /* Light blue background for profile */
                border-radius: 50%;
                padding: 8px;
                color: white;
                font-weight: bold;
            }

            .sidebar-profile .flux-profile span {
                color: #ffffff;
            }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 sidebar-bg">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group class="grid">
                    <flux:navlist.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="sidebar-item">
                        <span class="sidebar-icon">🏠</span> {{ __('Dashboard') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item :href="route('application.list')" :current="request()->routeIs('application.list')" wire:navigate class="sidebar-item">
                        <span class="sidebar-icon">📝</span> {{ __('Applications') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item :href="route('application.list.approved')" :current="request()->routeIs('application.list.approved')" wire:navigate class="sidebar-item">
                        <span class="sidebar-icon">✅</span> {{ __('Approved Applications') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item :href="route('application.list.declined')" :current="request()->routeIs('application.list.declined')" wire:navigate class="sidebar-item">
                        <span class="sidebar-icon">❌</span> {{ __('Declined Applications') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item :href="route('admin.manage.loans')" :current="request()->routeIs('admin.manage.loans')" wire:navigate class="sidebar-item">
                        <span class="sidebar-icon">💰</span> {{ __('Manage Loans') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                    class="sidebar-profile"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
