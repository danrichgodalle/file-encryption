<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Illuminate\Support\Facades\Crypt;


new class extends Component {
    public $applications;
    public $selectedApplication;
    public $setDecryptionKey = false;
    public $defaultPassword = '12345678';
    public $decryptionPassword;

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
        $application->name = decrypt($application->name);
        $application->date_of_birth = decrypt($application->date_of_birth);
        $application->age = decrypt($application->age);
        $application->civil_status = decrypt($application->civil_status);
        $application->spouse = decrypt($application->spouse);
        $application->contact_person = decrypt($application->contact_person);
        $application->source_of_Income = decrypt($application->source_of_income);
        $application->monthly_income = decrypt($application->monthly_income);
        $application->personal_properties = decrypt($application->personal_properties);
        $application->photo = decrypt($application->photo);
        $application->status = 'approved';
        $application->save();
        Flux::modal('edit-profile')->close();
        $this->mount();
    }

}; ?>

<div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Decrypt
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
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
                    Spouse
                </th>

                <th scope="col" class="px-6 py-3">
                  contact_person
                </th>

                <th scope="col" class="px-6 py-3">
                 source_of_income
                </th>

                <th scope="col" class="px-6 py-3">
                 monthly_income
                </th>

                <th scope="col" class="px-6 py-3">
                    personal_properties
                </th>

                <th scope="col" class="px-6 py-3">
                    Photo
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($applications as $application)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center gap-4">

                                <flux:button wire:click="selectApplication({{  $application->id }})">Decrypt</flux:button>

                        </div>
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{  Str::limit($application->name, 20, '...') }}
                    </th>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->date_of_birth, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->age, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->civil_status, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->spouse, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->contact_person, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ Str::limit($application->source_of_Income, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->monthly_income, 20, '...') }}
                    </td>
                    <td class="px-6 py-4">
                        {{  Str::limit($application->personal_properties, 20, '...') }}
                    </td>

                    <td>
                        {{  Str::limit($application->photo, 20, '...') }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <flux:modal name="edit-profile" class="md:w-96">

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
                    <div>
                        <p><strong>Name:</strong> {{ decrypt($selectedApplication->name) }}</p>
                        <p><strong>Name:</strong> {{ decrypt($selectedApplication->date_of_birth) }}</p>
                        <p><strong>Age:</strong> {{ decrypt($selectedApplication->age) }}</p>
                        <p><strong>Civil Status:</strong> {{ decrypt($selectedApplication->civil_status) }}</p>
                        <p><strong>Spouse:</strong> {{ decrypt($selectedApplication->spouse) }}</p>
                        <p><strong>Contact Person:</strong> {{ decrypt($selectedApplication->contact_person) }}</p>
                        <p><strong>Source of Income:</strong> {{ decrypt($selectedApplication->source_of_Income) }}</p>
                        <p><strong>Monthly Income:</strong> {{ decrypt($selectedApplication->monthly_income) }}</p>
                        <p><strong>Personal Properties:</strong> {{ decrypt($selectedApplication->personal_properties) }}</p>
                        @if($selectedApplication->photo)
                            <img src="{{ asset('storage/photos/' . decrypt($selectedApplication->photo)) }}" alt="Photo" class="w-32 h-32 object-cover rounded-lg mt-4">
                        @endif

                    </div>
                    <div class="flex">
                        <flux:spacer />
                        <flux:button wire:click="approved({{ $selectedApplication->id }})" variant="primary">Approved</flux:button>
                    </div>
                @endif
            </div>
        @endif
    </flux:modal>
</div>
