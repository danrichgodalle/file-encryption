<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
      Admin Dashboard
    </a>
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 dark:text-gray-100 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
           href="{{ route('admin.dashboard') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2v10a1 1 0 01-1 1h-3" />
          </svg>
          <span class="ml-4">Dashboard</span>
        </a>
      </li>
      {{-- Add more sidebar links here --}}
    </ul>
  </div>
</aside>
