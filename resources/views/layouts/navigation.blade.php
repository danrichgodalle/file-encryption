<x-nav-link :href="route('application.list')" :active="request()->routeIs('application.list')">
    {{ __('Pending Applications') }}
</x-nav-link>

<x-nav-link :href="route('application.list.declined')" :active="request()->routeIs('application.list.declined')">
    {{ __('Declined Applications') }}
</x-nav-link> 