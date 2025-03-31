<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Application;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Validate;


new #[Layout('components.layouts.auth')] class extends Component {

    use WithFileUploads;

    public string $name = '';
    public string $address = '';
    public string $date_of_birth = '';
    public string $age = '';
    public string $civil_status = '';
    public string $spouse = '';
    public string $contact_person = '';
    public string $source_of_income = '';
    public string $monthly_income = '';
    public array $personal_properties = [];
    public bool $success = false;
    public int $page = 1;
    public $data;

    public $photo;

    public function save() {
        $validated = $this->validate([
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'date_of_birth' => ['required', 'string'],
            'age' => ['required', 'string'],
            'civil_status' => ['required', 'string'],
            'spouse' => ['required', 'string'],
            'contact_person' => ['required', 'string'],
            'source_of_income' => ['required', 'string'],
            'monthly_income' => ['required', 'string'],
            'personal_properties' => ['required', 'array'],
            'photo' => ['required', 'image', 'max:1024'],
        ]);

        $this->data = $validated;
        $this->page = 2;

        // $encryptedData = [
        //     'name' => Crypt::encrypt($validated['name']),
        //     'address' => Crypt::encrypt($validated['address']),
        //     'date_of_birth' => Crypt::encrypt($validated['date_of_birth']),wwwwwwwwwwwwwwwwwwwwwwwwwwwww
        //     'age' => Crypt::encrypt($validated['age']),
        //     'civil_status' => Crypt::encrypt($validated['civil_status']),
        //     'spouse' => Crypt::encrypt($validated['spouse']),
        //     'contact_person' => Crypt::encrypt($validated['contact_person']),wwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
        //     'source_of_Income' => Crypt::encrypt($validated['source_of_Income']),
        //     'monthly_income' => Crypt::encrypt($validated['monthly_income']),
        //     'personal_properties' => Crypt::encrypt(json_encode($validated['personal_properties'])),
        // ];

        // $created = Application::create($encryptedData);

        // if($created) {
        //     $this->success = true;
        // }
    }

    public function saveToDb()
    {
        $encryptedData = [
            'name' => Crypt::encrypt($this->data['name']),
            'address' => Crypt::encrypt($this->data['address']),
            'date_of_birth' => Crypt::encrypt($this->data['date_of_birth']),
            'age' => Crypt::encrypt($this->data['age']),
            'civil_status' => Crypt::encrypt($this->data['civil_status']),
            'spouse' => Crypt::encrypt($this->data['spouse']),
            'contact_person' => Crypt::encrypt($this->data['contact_person']),
            'source_of_income' => Crypt::encrypt($this->data['source_of_income']),
            'monthly_income' => Crypt::encrypt($this->data['monthly_income']),
            'personal_properties' => Crypt::encrypt(json_encode($this->data['personal_properties'])),
        ];

        if($this->data['photo']) {
            $uniqueFileName = time() . '_' . uniqid() . '.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('photos', $uniqueFileName, 'public');
            $encryptedData['photo'] = Crypt::encrypt($uniqueFileName);
        }



        $created = Application::create($encryptedData);

        if($created) {
            $this->success = true;
            session()->flash('status', __('Successfully saved to database'));
        }

    }

    public function back() {
        $this->page = 1;
    }

}; ?>

<div>
    @if($page === 2)
        <dl class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg border border-gray-300 dark:bg-gray-800 dark:border-gray-700">

            <div class="bg-green-600 text-white text-center py-6 mb-6 rounded-t-lg shadow-md" style="background-color: #28a745 !important;">
                <h2 class="text-2xl font-semibold">Application Form</h2>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Name:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['name'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Address:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['address'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Date of Birth:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['date_of_birth'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Age:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['age'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Civil Status:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['civil_status'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Spouse:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['spouse'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Contact Person:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['contact_person'] }}</dd>
                </div>


                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3"> source of income :</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['source_of_income'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Monthly Income:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['monthly_income'] }}</dd>
                </div>

                <div class="flex flex-col py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300">Personal Properties:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                        @foreach($data['personal_properties'] as $property)
                            <span class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ $property }}</span>
                        @endforeach
                    </dd>
                </div>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3"> Uploaded Image :</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}">
                    @endif
                </dd>
            </div>

            <div class="flex gap-4 mt-6">
                <flux:button variant="primary" type="button" class="w-full py-3 px-6 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition ease-in-out duration-300" wire:click="back">{{ __('Back') }}</flux:button>
                <flux:button variant="danger" type="button" class="w-full py-3 px-6 rounded-md bg-red-500 text-white hover:bg-red-600 transition ease-in-out duration-300" wire:click="saveToDb">{{ __('Submit') }}</flux:button>
            </div>
        </dl>




            <x-auth-session-status class="text-center" :status="session('status')" />
        </dl>
    @endif

    @if($page === 1)

        <form wire:submit="save" class="flex flex-col gap-6 px-3 py-3">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <flux:input wire:model="name" label="Name"  required placeholder="Name" />
                </div>
                <div class="w-full md:w-1/2 px-3">

                    <flux:input wire:model="address" :label="__('Address')"  required :placeholder="__('ADDRESS')"/>
                </div>

            </div>

            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                    <flux:input wire:model="date_of_birth" type="date" :label="__('Date of Birth')"   required   :placeholder="__('Date of Birth')"/>
                </div>
                <div class="w-full md:w-1/2 px-3">

                    <flux:input wire:model="age" :label="__('Age')"  required :placeholder="__('Age')" />
                </div>

            </div>

            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <flux:input wire:model="civil_status" :label="__('Civil Status')"  :placeholder="__('Civil Status')"/>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <flux:input wire:model="spouse" :label="__('Spouse')"  required :placeholder="__('Spouse')" />
                </div>

            </div>

            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <flux:input wire:model="contact_person" :label="__('Contact Person')"  required :placeholder="__('Contact Person')"/>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <flux:input wire:model="source_of_income" :label="__('Source Of Income')"  required :placeholder="__('Source Of Income')"/>
                </div>

            </div>

            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <flux:input wire:model="monthly_income" :label="__('Monthly Income')"  required :placeholder="__('Monthly Income')"/>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="text-sm font-medium select-none text-zinc-800 dark:text-white" for="grid-zip">
                        Personal Properties
                    </label>
                    <flux:checkbox wire:model="personal_properties" value="Ref" :label="__('refregirator')"/>
                    <flux:checkbox wire:model="personal_properties" value="motorcyle" :label="__('motorcyle')" />
                    <flux:checkbox wire:model="personal_properties" value="Loptop" :label="__('Loptop')" />
                    <flux:checkbox wire:model="personal_properties" value="Cellphone" :label="__('Cellphone')" />
                    <flux:checkbox wire:model="personal_properties" value="Speaker" :label="__('Speaker')" />
                    <flux:checkbox wire:model="personal_properties" value="dvd" :label="__('dvd')" />
                    <flux:checkbox wire:model="personal_properties" value="Blender" :label="__('Blender')" />
                    <flux:checkbox wire:model="personal_properties" value="Washing Machine" :label="__('Washing Machine')" />
                </div>
            </div>

            <div class="flex flex-col gap-6">


                <div class="w-full px-3 mb-6 md:mb-0">
                    <flux:input type="file" wire:model="photo" label=""/>
                    @error('photo') <span class="error">{{ $message }}</span> @enderror
                </div>



                <div class="w-full  px-3 mb-6 md:mb-0">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}">
                    @endif
                </div>

            </div>

            <flux:button variant="primary" type="submit" class="w-full">{{ __('next') }}</flux:button>
            <flux:button variant="primary" type="button" class="w-full" wire:click="back" onclick="window.location.href='{{ url('/') }}'">{{ __('Back') }}</flux:button>

        </form>
    @endif
</div>
