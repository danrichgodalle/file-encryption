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
        $query = Application::whereStatus('approved');
        
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
    
   <!-- <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"> -->

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-white uppercase bg-gray-800 dark:bg-gray-900 dark:text-white">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>

                <th scope="col" class="px-6 py-3">
                    Address
                </th>

                <th scope="col" class="px-6 py-3">
                    Tel No
                </th>

                <th scope="col" class="px-6 py-3">
                    Cell No
                </th>
                

                <th scope="col" class="px-6 py-3">
                    Date of Birth
                </th>
                <th scope="col" class="px-6 py-3">
                    Age
                </th>
                <th scope="col" class="px-6 py-3">
                    Civil Status
                </th>

                <th scope="col" class="px-6 py-3">
                  contact_person
                </th>

                
                <th scope="col" class="px-6 py-3">
                    Photo
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($applications as $application)
          
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <flux:button wire:click="viewDetails({{ $application->id }})" variant="primary" class="flex items-center gap-1" icon="eye" >
                                View
                            </flux:button>
                            <flux:button wire:click="exportToPdf({{ $application->id }})" variant="primary" class="flex items-center gap-1" icon="printer" >
                                Export
                            </flux:button>
                        </div>
                    </td>

                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center gap-4">
                    
                            {{  $application->name }}
                        </div>
                    </th>

                    <td class="px-6 py-4">
                        {{  $application->address}}
                    </td>

                    <td class="px-6 py-4">
                        {{  $application->tel_no}}
                    </td>

                    <td class="px-6 py-4">
                        {{  $application->cell_no}}
                    </td>
                    
                    <td class="px-6 py-4">
                        {{  $application->date_of_birth}}
                    </td>
                    <td class="px-6 py-4">
                        {{ $application->age }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->civil_status }}
                    </td>

                    <td class="px-6 py-4">
                        {{  $application->contact_person }}
                    </td>


                    <td class="py-8">
                        @if($application->photo)
                            <img src="{{ asset('storage/photos/' . $application->photo) }}"alt="Photo" class="rounded-lg mt-4" width="100">
                        @else
                            No photo available
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Application Details Modal -->
    <flux:modal name="view-application-details" class="md:w-3/4">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Application Details</flux:heading>
                <flux:subheading>View complete application information.</flux:subheading>
            </div>

            @if($selectedApplication)
                <div class="grid grid-cols-1  gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <flux:heading size="lg">Personal Information</flux:heading>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <flux:heading >Name</flux:heading>
                                <flux:text>{{ $selectedApplication->name }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Nick Name</flux:heading>
                                <flux:text>{{ $selectedApplication->nick_name }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Address</flux:heading>
                                <flux:text>{{ $selectedApplication->address }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Contact Numbers</flux:heading>
                                <flux:text>Tel: {{ $selectedApplication->tel_no }}</flux:text>
                                <flux:text>Cell: {{ $selectedApplication->cell_no }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Date of Birth</flux:heading>
                                <flux:text>{{ $selectedApplication->date_of_birth }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Age</flux:heading>
                                <flux:text>{{ $selectedApplication->age }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Civil Status</flux:heading>
                                <flux:text>{{ $selectedApplication->civil_status }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Contact Person</flux:heading>
                                <flux:text>{{ $selectedApplication->contact_person }}</flux:text>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="space-y-4">
                        <flux:heading size="lg">Employment Information</flux:heading>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <flux:heading >Employment Status</flux:heading>
                                <flux:text>{{ $selectedApplication->employment }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Position</flux:heading>
                                <flux:text>{{ $selectedApplication->position }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Employer Name</flux:heading>
                                <flux:text>{{ $selectedApplication->employer_name }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Employer Address</flux:heading>
                                <flux:text>{{ $selectedApplication->employer_address }}</flux:text>
                            </div>
                        </div>

                        <!-- Spouse Employment Information -->
                        <flux:heading size="lg">Spouse Employment Information</flux:heading>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <flux:heading >Spouse Employment</flux:heading>
                                <flux:text>{{ $selectedApplication->spouse_employment }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Spouse Position</flux:heading>
                                <flux:text>{{ $selectedApplication->spouse_position }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Spouse Employer Name</flux:heading>
                                <flux:text>{{ $selectedApplication->spouse_employer_name }}</flux:text>
                            </div>
                            <div>
                                <flux:heading >Spouse Employer Address</flux:heading>
                                <flux:text>{{ $selectedApplication->spouse_employer_address }}</flux:text>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <flux:heading size="lg">Properties</flux:heading>

                        <!-- Properties Information -->

                        @if($selectedApplication->properties)
                            <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-6">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Type</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Make/Model</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Year Acquired</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Estimated Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach (json_decode($selectedApplication->properties, true) as $index => $property)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-800">{{ $property['type'] }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-800">{{ $property['make_model'] }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-800">{{ $property['years_acquired'] }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-800">₱{{ number_format($property['estimated_cost'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        @else
                            <flux:subheading>No properties found</flux:subheading>
                        @endif
                    </div>
                   

                    <!-- Photo -->
                    <div class="col-span-1 md:col-span-1 space-y-4">
                        <flux:heading size="lg">ID Photo</flux:heading>
                        
                        @if($selectedApplication->photo)
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/photos/' . $selectedApplication->photo) }}" alt="Photo" class="rounded-lg max-w-md">
                            </div>
                        @else
                            <flux:text>No photo available</flux:text>
                        @endif
                    </div>


                    <!-- Photo -->
                    <div class="col-span-1 md:col-span-1 space-y-4">
                        <flux:heading size="lg">Residential Sketch</flux:heading>
                        
                        @if($selectedApplication->sketch)
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/photos/' . $selectedApplication->sketch) }}" alt="Photo" class="rounded-lg max-w-md">
                            </div>
                        @else
                            <flux:text>No photo available</flux:text>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button wire:click="exportToPdf({{ $selectedApplication->id }})" variant="primary" class="flex items-center gap-1" icon="printer">
                        Export to PDF
                    </flux:button>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
