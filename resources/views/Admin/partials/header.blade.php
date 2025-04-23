<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
  <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu" aria-label="Menu">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="M3 5h14a1 1 0 010 2H3a1 1 0 010-2zm0 4h14a1 1 0 010 2H3a1 1 0 010-2zm0 4h14a1 1 0 010 2H3a1 1 0 010-2z"
              clip-rule="evenodd"></path>
      </svg>
    </button>
    <ul class="flex items-center flex-shrink-0 space-x-6">
      <li class="relative">
        <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none">
          <img class="object-cover w-8 h-8 rounded-full"
               src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}"
               alt="" aria-hidden="true" />
        </button>
      </li>
    </ul>
  </div>
</header>
