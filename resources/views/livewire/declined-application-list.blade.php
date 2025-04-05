<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    public $applications;
    public $selectedApplication;
    public $setDecryptionKey = false;
    public $defaultPassword = '12345678';
    public $decryptionPassword;

    public function mount(): void
    {
       $this->applications = Application::whereStatus('declined')->get();
    }

    public function selectApplication($id): void
    {
        $this->selectedApplication = Application::find($id);
        Flux::modal('edit-profile')->show();
    }

    public function decrypt(): void
    {
        if ($this->decryptionPassword === $this->defaultPassword) {
            $this->setDecryptionKey = true;
        }else {
            session()->flash('status', __('Invalid decryption key.'));
        }
    }

    public function exportToPdf($id)
    {
        $application = Application::find($id);

        // Convert photo to base64 if exists
        $photoSrc = null;
        if ($application->photo) {
            $photoPath = public_path('storage/photos/' . $application->photo);
            if (file_exists($photoPath)) {
                $photoData = base64_encode(file_get_contents($photoPath));
                $photoSrc = 'data:image/jpeg;base64,' . $photoData;
            }
        }

        $photoSketchSrc = null;
        if ($application->sketch) {
            $photoSketchPath = public_path('storage/photos/' . $application->sketch);
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
    }
}; ?>

<div>
    <div class="mb-4">
        <flux:heading size="lg">Declined Applications</flux:heading>
    </div>
    
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              
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
                    Contact Person
                </th>
                <th scope="col" class="px-6 py-3">
                    Decline Reason
                </th>
                <th scope="col" class="px-6 py-3">
                    Export
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    {{-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center gap-4">
                            <flux:button wire:click="selectApplication({{  $application->id }})">Decrypt</flux:button>
                        </div>
                    </th> --}}
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{  $application->name }}
                    </th>

                    <td class="px-6 py-4">  
                        {{  $application->address }}
                    </td>

                    <td class="px-6 py-4">
                        {{  $application->tel_no }}
                    </td>

                    <td class="px-6 py-4">
                        {{  $application->cell_no }}
                    </td>

                    <td class="px-6 py-4">
                        {{  $application->date_of_birth }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->age }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->civil_status }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->contact_person }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->decline_reason, 30, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        <flux:button wire:click="exportToPdf({{  $application->id }})" variant="primary" class="flex items-center gap-1" icon="printer">
                            Export
                        </flux:button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <flux:modal name="edit-profile" class="md:w-1/2">
        @if(!$setDecryptionKey)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Enter Decryption Key</flux:heading>
                </div>

                <x-auth-session-status class="text-center" :status="session('status')" />

                <div>
                    <flux:input type="password" wire:model="decryptionPassword" placeholder="Enter Decryption Key" />
                </div>

                <div class="flex">
                    <flux:spacer />
                    <flux:button wire:click="decrypt" variant="primary">Decrypt</flux:button>
                </div>
            </div>
        @endif

        @if($setDecryptionKey)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Application Details</flux:heading>
                    <flux:subheading>View and decrypt application details.</flux:subheading>
                </div>

                @if($selectedApplication)
                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Name</flux:heading>
                            <flux:subheading>{{ $selectedApplication->name ? decrypt($selectedApplication->name) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Nick Name</flux:heading>
                            <flux:subheading>{{ $selectedApplication->nick_name ? decrypt($selectedApplication->nick_name) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Address</flux:heading>
                            <flux:subheading>{{ $selectedApplication->address ? decrypt($selectedApplication->address) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Tel No</flux:heading>
                            <flux:subheading>{{ $selectedApplication->tel_no ? decrypt($selectedApplication->tel_no) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Cell No</flux:heading>
                            <flux:subheading>{{ $selectedApplication->cell_no ? decrypt($selectedApplication->cell_no) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Length of Stay</flux:heading>
                            <flux:subheading>{{ $selectedApplication->length_of_stay ? decrypt($selectedApplication->length_of_stay) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Ownership</flux:heading>
                            <flux:subheading>{{ $selectedApplication->ownership ? decrypt($selectedApplication->ownership) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Rent Amount</flux:heading>
                            <flux:subheading>{{ $selectedApplication->rent_amount ? decrypt($selectedApplication->rent_amount) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Date Of Birth</flux:heading>
                            <flux:subheading>{{ $selectedApplication->date_of_birth ? decrypt($selectedApplication->date_of_birth) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Place of Birth</flux:heading>
                            <flux:subheading>{{ $selectedApplication->place_of_birth ? decrypt($selectedApplication->place_of_birth) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Age</flux:heading>
                            <flux:subheading>{{ $selectedApplication->age ? decrypt($selectedApplication->age) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Civil Status</flux:heading>
                            <flux:subheading>{{ $selectedApplication->civil_status ? decrypt($selectedApplication->civil_status) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Dependents</flux:heading>
                            <flux:subheading>{{ $selectedApplication->dependents ? decrypt($selectedApplication->dependents) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Contact Person</flux:heading>
                            <flux:subheading>{{ $selectedApplication->contact_person ? decrypt($selectedApplication->contact_person) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Employment</flux:heading>
                            <flux:subheading>{{ $selectedApplication->employment ? decrypt($selectedApplication->employment) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Position</flux:heading>
                            <flux:subheading>{{ $selectedApplication->position ? decrypt($selectedApplication->position) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Employer Name</flux:heading>
                            <flux:subheading>{{ $selectedApplication->employer_name ? decrypt($selectedApplication->employer_name) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Employer Address</flux:heading>
                            <flux:subheading>{{ $selectedApplication->employer_address ? decrypt($selectedApplication->employer_address) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Spouse Employment</flux:heading>
                            <flux:subheading>{{ $selectedApplication->spouse_employment ? decrypt($selectedApplication->spouse_employment) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Spouse Position</flux:heading>
                            <flux:subheading>{{ $selectedApplication->spouse_position ? decrypt($selectedApplication->spouse_position) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">Spouse Employer Name</flux:heading>
                            <flux:subheading>{{ $selectedApplication->spouse_employer_name ? decrypt($selectedApplication->spouse_employer_name) : '' }}</flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Spouse Employer Address</flux:heading>
                            <flux:subheading>{{ $selectedApplication->spouse_employer_address ? decrypt($selectedApplication->spouse_employer_address) : '' }}</flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-full">
                            <flux:heading size="lg">Properties</flux:heading>
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
                                        @foreach (json_decode(decrypt($selectedApplication->properties), true) as $index => $property)
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
                    </div>

                    <div class="flex">
                        <div class="w-1/2">
                            <flux:heading size="lg">ID Photo</flux:heading>
                            <flux:subheading>
                                @if($selectedApplication->photo)
                                    <img src="{{ asset('storage/photos/' . decrypt($selectedApplication->photo)) }}" alt="Photo" class="w-32 h-32 object-cover rounded-lg mt-4">
                                @else
                                    <flux:subheading>No ID photo found</flux:subheading>
                                @endif
                            </flux:subheading>
                        </div>
                        <div class="w-1/2">
                            <flux:heading size="lg">Sketch</flux:heading>
                            <flux:subheading>
                                @if($selectedApplication->sketch)
                                    <img src="{{ asset('storage/photos/' . decrypt($selectedApplication->sketch)) }}" alt="Photo" class="w-32 h-32 object-cover rounded-lg mt-4">
                                @else
                                    <flux:subheading>No sketch found</flux:subheading>
                                @endif
                            </flux:subheading>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-full">
                            <flux:heading size="lg">Decline Reason</flux:heading>
                            <flux:subheading>{{ $selectedApplication->decline_reason }}</flux:subheading>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </flux:modal>
</div> 