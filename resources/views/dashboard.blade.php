<x-layouts.app title="Dashboard">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 p-6 flex flex-col items-center justify-center dark:border-neutral-700">
                <h2 class="text-2xl font-bold text-green-600">{{ \App\Models\Application::whereStatus('approved')->count() }}</h2>
                <p class="text-gray-600 dark:text-gray-400">Total Approved Applications</p>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 p-6 flex flex-col items-center justify-center dark:border-neutral-700">
                <h2 class="text-2xl font-bold text-blue-600">{{ \App\Models\Application::whereStatus('pending')->count() }}</h2>
                <p class="text-gray-600 dark:text-gray-400">Pending Applications</p>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 p-6 flex flex-col items-center justify-center dark:border-neutral-700">
                <h2 class="text-2xl font-bold text-red-600">{{ \App\Models\Application::whereStatus('declined')->count() }}</h2>
                <p class="text-gray-600 dark:text-gray-400">Declined Applications</p>
            </div>
        </div>
        
    </div>
</x-layouts.app>
