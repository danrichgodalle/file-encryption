@role('admin')
<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
@endrole

@role('user')
    <x-layouts.app.user-sidebar :title="$title ?? null">
        {{ $slot }}
    </x-layouts.app.user-sidebar>
@endrole
