<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;


new class extends Component {
    public $applications;
    public $selectedApplication;
    public $setDecryptionKey = false;
    public $defaultPassword = '12345678';
    public $decryptionPassword;
    public $declineReason = '';
    public $showDeclineForm = false;

    public function mount(): void
    {
       $this->applications = Application::whereStatus('pending')->get();
       
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


        // $application = Application::find($id);
        // $application->name = decrypt($application->name);
        // $application->date_of_birth = decrypt($application->date_of_birth);
        // $application->age = decrypt($application->age);
        // $application->civil_status = decrypt($application->civil_status);
        // $application->spouse = decrypt($application->spouse);
        // $application->contact_person = decrypt($application->contact_person);
        // $application->source_of_income = decrypt($application->source_of_income);
        // $application->monthly_income = decrypt($application->monthly_income);
        // $application->personal_properties = decrypt($application->personal_properties);
        // $application->save();
    }

    public function approved($id)
    {
        $application = Application::find($id);
        $application->name = $application->name ?  decrypt($application->name) : '';
        $application->nick_name = $application->nick_name ?  decrypt($application->nick_name) : '';
        $application->address = $application->address ?  decrypt($application->address) : '';
        $application->tel_no = $application->tel_no ?  decrypt($application->tel_no) : '';
        $application->cell_no = $application->cell_no ?  decrypt($application->cell_no) : '';
        $application->length_of_stay = $application->length_of_stay ?  decrypt($application->length_of_stay) : '';
        $application->ownership = $application->ownership ?  decrypt($application->ownership) : '';
        $application->rent_amount = $application->rent_amount ?  decrypt($application->rent_amount) : '';
        
        $application->date_of_birth = $application->date_of_birth ?  decrypt($application->date_of_birth) : '';
        $application->place_of_birth = $application->place_of_birth ?  decrypt($application->place_of_birth) : '';
        $application->age = $application->age ?  decrypt($application->age) : '';
        $application->civil_status = $application->civil_status ?  decrypt($application->civil_status) : '';


        $application->dependents = $application->dependents ?  decrypt($application->dependents) : '';
        $application->contact_person = $application->contact_person ?  decrypt($application->contact_person) : '';
        $application->employment = $application->employment ?  decrypt($application->employment) : '';
        $application->position = $application->position ?  decrypt($application->position) : '';
        $application->employer_name = $application->employer_name ?  decrypt($application->employer_name) : '';
        $application->employer_address = $application->employer_address ?  decrypt($application->employer_address) : '';

        $application->spouse_employment = $application->spouse_employment ?  decrypt($application->spouse_employment) : '';
        $application->spouse_position = $application->spouse_position ?  decrypt($application->spouse_position) : '';
        $application->spouse_employer_name = $application->spouse_employer_name ?  decrypt($application->spouse_employer_name) : '';
        $application->spouse_employer_address = $application->spouse_employer_address ?  decrypt($application->spouse_employer_address) : '';
        

        $application->properties = $application->properties ?  decrypt($application->properties) : '';
        $application->photo = $application->photo ?  decrypt($application->photo) : '';
        $application->sketch = $application->sketch ?  decrypt($application->sketch) : '';
        $application->signature = $application->signature ?  decrypt($application->signature) : '';
        $application->status = 'approved';
        $application->save();
        Flux::modal('edit-profile')->close();

        LivewireAlert::title('Success')
                ->text('Application approved successfully')
                ->success()
                ->show();

        $this->mount();
    }

    public function showDeclinedMessage($id)
    {
        $this->selectedApplication = Application::find($id);
        $this->showDeclineForm = true;
        $this->setDecryptionKey = false;
        
        Flux::modal('decline-form')->show();
    }

    public function discard($id)
    {
        $application = Application::find($id);
        $application->name = $application->name ?  decrypt($application->name) : '';
        $application->nick_name = $application->nick_name ?  decrypt($application->nick_name) : '';
        $application->address = $application->address ?  decrypt($application->address) : '';
        $application->tel_no = $application->tel_no ?  decrypt($application->tel_no) : '';
        $application->cell_no = $application->cell_no ?  decrypt($application->cell_no) : '';
        $application->length_of_stay = $application->length_of_stay ?  decrypt($application->length_of_stay) : '';
        $application->ownership = $application->ownership ?  decrypt($application->ownership) : '';
        $application->rent_amount = $application->rent_amount ?  decrypt($application->rent_amount) : '';
        
        $application->date_of_birth = $application->date_of_birth ?  decrypt($application->date_of_birth) : '';
        $application->place_of_birth = $application->place_of_birth ?  decrypt($application->place_of_birth) : '';
        $application->age = $application->age ?  decrypt($application->age) : '';
        $application->civil_status = $application->civil_status ?  decrypt($application->civil_status) : '';


        $application->dependents = $application->dependents ?  decrypt($application->dependents) : '';
        $application->contact_person = $application->contact_person ?  decrypt($application->contact_person) : '';
        $application->employment = $application->employment ?  decrypt($application->employment) : '';
        $application->position = $application->position ?  decrypt($application->position) : '';
        $application->employer_name = $application->employer_name ?  decrypt($application->employer_name) : '';
        $application->employer_address = $application->employer_address ?  decrypt($application->employer_address) : '';

        $application->spouse_employment = $application->spouse_employment ?  decrypt($application->spouse_employment) : '';
        $application->spouse_position = $application->spouse_position ?  decrypt($application->spouse_position) : '';
        $application->spouse_employer_name = $application->spouse_employer_name ?  decrypt($application->spouse_employer_name) : '';
        $application->spouse_employer_address = $application->spouse_employer_address ?  decrypt($application->spouse_employer_address) : '';
        

        $application->properties = $application->properties ?  decrypt($application->properties) : '';
        $application->photo = $application->photo ?  decrypt($application->photo) : '';
        $application->sketch = $application->sketch ?  decrypt($application->sketch) : '';
        $application->signature = $application->signature ?  decrypt($application->signature) : '';
        $application->status = 'declined';
        $application->decline_reason = $this->declineReason;
        $application->save();


        Flux::modal('decline-form')->close();
        $this->declineReason = '';
        $this->showDeclineForm = false;


        LivewireAlert::title('Success')
                ->text('Application Declined')
                ->success()
                ->show();

        $this->mount();
    }

    public function exportToPdf($id)
    {
        $application = Application::find($id);
        
    
        $data = [
            'application' => $application,
            'title' => 'Application Details'
        ];
        
        $pdf = PDF::loadView('pdf.single-application', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'application-' . $id . '.pdf');
    }

}; ?>

<div>
    <div class="grid grid-cols-4 gap-6 p-6">
        @foreach($applications as $application)
            <div class="flex flex-col items-center cursor-pointer" wire:click="selectApplication({{ $application->id }})">
                <!-- Folder Icon -->
                <div class="w-24 h-20 bg-yellow-400 rounded-t-lg relative flex items-center justify-center mb-2">
                    <div class="absolute -top-2 w-12 h-3 bg-yellow-400 rounded-t-lg"></div>
                </div>
                <!-- Name and Date -->
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $selectedApplication && $setDecryptionKey ? decrypt($application->name) : Str::limit($application->name, 20, '...') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $selectedApplication && $setDecryptionKey ? decrypt($application->date_of_birth) : Str::limit($application->date_of_birth, 20, '...') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <flux:modal name="edit-profile" class="md:w-1/2" wire:model.self="setDecryptionKey">

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
                                <flux:heading size="lg">Adddress</flux:heading>
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
                                <flux:heading size="lg">Signature</flux:heading>
                                
                                @if($selectedApplication->signature)
                                    <div class="flex justify-center">
                                        <img src="{{ asset('storage/signatures/' . decrypt($selectedApplication->signature)) }}" alt="Signature" class="rounded-lg max-w-md">
                                    </div>
                                @else
                                    <flux:text>No signature available</flux:text>
                                @endif
                            </div>
                        </div>

                            
                    
                        <flux:spacer />
                    
                    
                        <div class="flex gap-2">
                                <flux:button wire:click="approved({{ $selectedApplication->id }})" variant="primary">Approved</flux:button>
                                <flux:button wire:click="showDeclinedMessage({{ $selectedApplication->id }})" variant="danger">Declined</flux:button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </flux:modal>

    <flux:modal name="decline-form" class="md:w-1/2" wire:model.self="showDeclineForm">
        @if($showDeclineForm)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Decline Reason</flux:heading>
                </div>

                <div>
                    <flux:input type="text" wire:model="declineReason" placeholder="Enter decline reason" />
                </div>

                <div class="flex">
                    <flux:spacer />
                    <flux:button wire:click="discard({{ $selectedApplication->id }})" variant="primary">Discard</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>
</div>
