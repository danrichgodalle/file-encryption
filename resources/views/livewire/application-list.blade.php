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
    public $isDecrypted = false;
    public $showSetEncryptionKey = false;
    public $newEncryptionKey = '';

    public function mount(): void
    {
       $this->applications = Application::whereStatus('pending')->get();
    }

    public function selectApplication($id): void
    {
        $this->selectedApplication = Application::find($id);
        $this->setDecryptionKey = false;
        $this->isDecrypted = false;
        $this->decryptionPassword = '';
        $this->showSetEncryptionKey = false;
        $this->newEncryptionKey = '';
        
        Flux::modal('edit-profile')->show();
    }

    public function showSetEncryptionKeyForm(): void
    {
        $this->showSetEncryptionKey = true;
    }

    public function setEncryptionKey(): void
    {
        if (empty($this->newEncryptionKey)) {
            session()->flash('status', __('Please enter an encryption key.'));
            return;
        }

        $this->selectedApplication->encryption_key = $this->newEncryptionKey;
        $this->selectedApplication->save();
        
        $this->showSetEncryptionKey = false;
        $this->newEncryptionKey = '';
        
        LivewireAlert::title('Success')
            ->text('Encryption key set successfully')
            ->success()
            ->show();
    }

    public function decrypt(): void
    {
        $encryptionKey = $this->selectedApplication->encryption_key ?? $this->defaultPassword;
        
        if ($this->decryptionPassword === $encryptionKey) {
            $this->isDecrypted = true;
        } else {
            session()->flash('status', __('Invalid decryption key.'));
        }
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

    <flux:modal name="edit-profile" class="md:w-1/2">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Application Details</flux:heading>
                <flux:subheading>View application details.</flux:subheading>
            </div>

            @if($selectedApplication)
                @if($isDecrypted)
                    <div class="space-y-6">
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

                        <div class="flex gap-2">
                            <flux:button wire:click="approved({{ $selectedApplication->id }})" variant="primary">Approved</flux:button>
                            <flux:button wire:click="showDeclinedMessage({{ $selectedApplication->id }})" variant="danger">Declined</flux:button>
                        </div>
                    </div>
                @else
                    <div class="space-y-6">
                        <div class="flex">
                            <div class="w-1/2">
                                <flux:heading size="lg">Name</flux:heading>
                                <flux:subheading>{{ Str::limit($selectedApplication->name, 20, '...') }}</flux:subheading>
                            </div>
                            <div class="w-1/2">
                                <flux:heading size="lg">Nick Name</flux:heading>
                                <flux:subheading>{{ Str::limit($selectedApplication->nick_name, 20, '...') }}</flux:subheading>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/2">
                                <flux:heading size="lg">Address</flux:heading>
                                <flux:subheading>{{ Str::limit($selectedApplication->address, 20, '...') }}</flux:subheading>
                            </div>
                            <div class="w-1/2">
                                <flux:heading size="lg">Tel No</flux:heading>
                                <flux:subheading>{{ Str::limit($selectedApplication->tel_no, 20, '...') }}</flux:subheading>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/2">
                                <flux:heading size="lg">Cell No</flux:heading>
                                <flux:subheading>{{ Str::limit($selectedApplication->cell_no, 20, '...') }}</flux:subheading>
                            </div>
                            <div class="w-1/2">
                                <flux:heading size="lg">Length of Stay</flux:heading>
                                <flux:subheading>{{ Str::limit($selectedApplication->length_of_stay, 20, '...') }}</flux:subheading>
                            </div>
                        </div>

                        @if(!$setDecryptionKey)
                            <div class="mt-6">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                This data is encrypted. Click the button below to decrypt.
                                                @if(!$selectedApplication->encryption_key)
                                                    You can also set a custom encryption key for this application.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-center gap-2">
                                    @if($selectedApplication->encryption_key)
                                        <flux:button wire:click="$set('setDecryptionKey', true)" variant="primary">
                                            Decrypt Data
                                        </flux:button>
                                    @endif
                                    @if(!$selectedApplication->encryption_key)
                                        <flux:button wire:click="showSetEncryptionKeyForm" variant="primary">
                                            Set Encryption Key
                                        </flux:button>
                                    @endif
                                    <flux:button wire:click="exportToPdf({{ $selectedApplication->id }})" variant="primary">
                                        Export PDF
                                    </flux:button>
                                </div>
                            </div>
                        @endif

                        @if($setDecryptionKey)
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Enter Decryption Key</flux:heading>
                                    @if($selectedApplication->encryption_key)
                                        <flux:subheading>Use the custom encryption key set for this application.</flux:subheading>
                                    @else
                                        <flux:subheading>Use the default decryption key.</flux:subheading>
                                    @endif
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

                        @if($showSetEncryptionKey)
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Set Custom Encryption Key</flux:heading>
                                    <flux:subheading>Set a unique encryption key for this application.</flux:subheading>
                                </div>

                                <x-auth-session-status class="text-center" :status="session('status')" />

                                <div>
                                    <flux:input type="password" wire:model="newEncryptionKey" placeholder="Enter New Encryption Key" />
                                </div>

                                <div class="flex justify-end gap-2">
                                    <flux:button wire:click="$set('showSetEncryptionKey', false)" variant="primary">Cancel</flux:button>
                                    <flux:button wire:click="setEncryptionKey" variant="primary">Set Key</flux:button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
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
