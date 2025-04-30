<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Carbon\Carbon;

new class extends Component {
    public $applications;
    public $selectedApplication;

    public function mount(): void
    {
        $this->loadApplications();
    }

    public function loadApplications(): void
    {
        $this->applications = Application::all();
    }

    public function viewDetails($id): void
    {
        $this->selectedApplication = Application::findOrFail($id);
        Flux::modal('view-application-details')->show();
    }
}; ?>

<div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
        @foreach($applications as $application)
            <div class="flex flex-col items-center">
                <button 
                    wire:click="viewDetails({{ $application->id }})"
                    class="group relative flex flex-col items-center hover:opacity-80 transition-opacity"
                >
                    <!-- Folder Icon -->
                    <div class="w-24 h-24 bg-yellow-400 rounded-lg flex items-center justify-center shadow-md">
                        <flux:icon name="folder" variant="solid" class="w-16 h-16 text-yellow-600" />
                    </div>
                    <!-- Name and Date -->
                    <div class="mt-2 text-center">
                        <p class="font-medium text-gray-900 truncate max-w-[150px]">{{ $application->name }}</p>
                        <p class="text-sm text-gray-500">{{ Carbon::parse($application->created_at)->format('m/d/Y') }}</p>
                    </div>
                </button>
            </div>
        @endforeach
    </div>

    <!-- Application Details Modal -->
    <flux:modal name="view-application-details">
        <div class="space-y-6">
            @if($selectedApplication)
                <div>
                    <flux:heading size="lg">Application Details</flux:heading>
                    <flux:subheading>View complete application information.</flux:subheading>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <flux:heading>Name</flux:heading>
                        <flux:text>{{ $selectedApplication->name }}</flux:text>
                    </div>
                    <div>
                        <flux:heading>Date Created</flux:heading>
                        <flux:text>{{ Carbon::parse($selectedApplication->created_at)->format('m/d/Y') }}</flux:text>
                    </div>
                    <!-- Add other application details as needed -->
                </div>
            @endif
        </div>
    </flux:modal>
</div> 