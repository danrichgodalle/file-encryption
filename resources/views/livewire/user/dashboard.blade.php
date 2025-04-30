<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>

    <div id="dashboardSection">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Your Dashboard</h1>
        <div class="bg-white p-10 rounded-xl shadow text-center">
          <h2 class="text-2xl font-bold text-gray-700 mb-4">Hello, {{ auth()->user()->name }}!</h2>
          <p class="text-gray-600">Use the sidebar to apply for a loan or view your loan status.</p>
        </div>
      </div>
    
</div>
