<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {

    public $applications;
    public $search = '';
    public $selectedApplication;

    public function mount(): void
    {
       $this->loadApplications();
    }

    public function loadApplications(): void
    {
        $query = Application::whereStatus('declined');
        
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        
        $this->applications = $query->get();
    }

    public function updatedSearch(): void
    {
        $this->loadApplications();
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
    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Search by name..." 
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($applications as $application)
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
                        <p class="mt-2 text-sm text-gray-500">DownloadPDF Document</p>
                    </div>
                </div>

                {{-- <div class="flex justify-end mt-6">
                    <flux:button wire:click="exportToPdf({{ $selectedApplication->id }})" variant="primary" class="flex items-center gap-1" icon="printer">
                        Export to PDF
                    </flux:button>
                </div> --}}
            @endif
        </div>
    </flux:modal>
</div>
