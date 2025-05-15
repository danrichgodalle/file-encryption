<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $selectedApplication;
    public $dateFilter = 'all'; // Options: all, latest_month, last_month, custom
    public $startDate = '';
    public $endDate = '';

    public function getApplicationsProperty()
    {
        $query = Application::whereStatus('approved');
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        // Apply date filters
        switch ($this->dateFilter) {
            case 'latest_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'last_month':
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                      ->whereYear('created_at', Carbon::now()->subMonth()->year);
                break;
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($this->startDate)->startOfDay(),
                        Carbon::parse($this->endDate)->endOfDay()
                    ]);
                }
                break;
        }
        return $query->latest()->paginate(20);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedDateFilter(): void
    {
        if ($this->dateFilter === 'latest_month' || $this->dateFilter === 'last_month') {
            $this->startDate = '';
            $this->endDate = '';
        }
        $this->resetPage();
    }

    public function updatedStartDate(): void
    {
        $this->resetPage();
    }

    public function updatedEndDate(): void
    {
        $this->resetPage();
    }

    public function viewDetails($id): void
    {
        $this->selectedApplication = Application::findOrFail($id);
        Flux::modal('view-application-details')->show();
    }

    public function exportToPdf($id)
    {
        try {
            $application = Application::findOrFail($id);
            
            // Convert photo to base64 if exists
            $photoSrc = null;
            if ($application->photo) {
                $photoPath = storage_path('app/public/photos/' . $application->photo);

                if (file_exists($photoPath)) {
                    $photoData = base64_encode(file_get_contents($photoPath));
                    $photoSrc = 'data:image/jpeg;base64,' . $photoData;
                }
            }

            $photoSketchSrc = null;
            if ($application->sketch) {
                $photoSketchPath = storage_path('app/public/photos/' . $application->sketch);
                if (file_exists($photoSketchPath)) {
                    $photoSketchData = base64_encode(file_get_contents($photoSketchPath));
                    $photoSketchSrc = 'data:image/jpeg;base64,' . $photoSketchData;
                }
            }

            // Add signature processing
            $signatureSrc = null;
            if ($application->signature) {
                $signaturePath = storage_path('app/public/signatures/' . $application->signature);
                if (file_exists($signaturePath)) {
                    $signatureData = base64_encode(file_get_contents($signaturePath));
                    $signatureSrc = 'data:image/jpeg;base64,' . $signatureData;
                }
            }

            // Format personal properties
            $personalProperties = [];
            if ($application->properties) {
                $properties = json_decode($application->properties, true);
                if (is_array($properties)) {
                    $personalProperties = $properties;
                }
            }

            $data = [
                'application' => $application,
                'title' => 'Application Details',
                'photoSrc' => $photoSrc,
                'photoSketchSrc' => $photoSketchSrc,
                'signatureSrc' => $signatureSrc,
                'personalProperties' => $personalProperties
            ];
            
            $pdf = PDF::loadView('pdf.application-details', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isPhpEnabled', true);
            
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->output();
            }, 'application-' . $id . '.pdf');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
    //
}; ?>

<div>
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="space-y-4">
            <!-- Search Bar -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Search by name..." 
                    class="pl-10 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                >
            </div>

            <!-- Filter Controls -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Filter</label>
                    <select 
                        wire:model.live="dateFilter"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                    >
                        <option value="all">All Time</option>
                        <option value="latest_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="custom">Custom Date Range</option>
                    </select>
                </div>

                @if($dateFilter === 'custom')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input 
                            type="date" 
                            wire:model.live="startDate"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input 
                            type="date" 
                            wire:model.live="endDate"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                        >
                    </div>
                @endif
            </div>

            <!-- Active Filters Display -->
            <div class="flex flex-wrap gap-2 pt-2">
                @if($dateFilter !== 'all')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        @switch($dateFilter)
                            @case('latest_month')
                                This Month
                                @break
                            @case('last_month')
                                Last Month
                                @break
                            @case('custom')
                                Custom Range: {{ $startDate }} - {{ $endDate }}
                                @break
                        @endswitch
                        <button wire:click="$set('dateFilter', 'all')" class="ml-2 text-blue-600 hover:text-blue-900">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                @endif
                @if($search)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Search: "{{ $search }}"
                        <button wire:click="$set('search', '')" class="ml-2 text-blue-600 hover:text-blue-900">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($this->applications as $application)
            <div class="flex flex-col items-center">
                <button 
                    wire:click="viewDetails({{ $application->id }})"
                    class="group relative flex flex-col items-center hover:opacity-80 transition-opacity"
                >
                    <!-- Folder Icon -->
                    <div class="w-24 h-24 bg-yellow-400 rounded-t-lg flex items-center justify-center shadow-md">
                        <flux:icon name="folder" variant="solid" class="w-16 h-16 text-yellow-600" />
                    </div>
                    <!-- Name and Date -->
                    <div class="mt-2 text-center">
                        <p class="font-medium text-gray-900 truncate max-w-[150px]">{{ $application->name }}</p>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($application->created_at)->format('m/d/Y') }}</p>
                    </div>
                </button>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $this->applications->links() }}
    </div>

    <!-- Application Details Modal -->
    <flux:modal name="view-application-details" class="md:w-3/4">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Application Details</flux:heading>
                <flux:subheading>View complete application information.</flux:subheading>
            </div>

            @if($selectedApplication)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="font-medium text-gray-700">Name</label>
                            <p>{{ $selectedApplication->name }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Tel No.</label>
                            <p>{{ $selectedApplication->tel_no }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Mobile No.</label>
                            <p>{{ $selectedApplication->cell_no }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Address</label>
                            <p>{{ $selectedApplication->address }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Age</label>
                            <p>{{ $selectedApplication->age }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center cursor-pointer"  wire:click="exportToPdf({{ $selectedApplication->id }})">
                        <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                            <flux:icon name="document-text" variant="solid" class="w-20 h-20 text-red-500" />
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Download PDF Document</p>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
