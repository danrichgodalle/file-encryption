<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Application;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;


new #[Layout('components.layouts.form')] class extends Component {

    use WithFileUploads;

    public string $name = '';
    public string $nick_name = '';
    public string $address = '';
    public string $date_of_birth = '';
    public string $tel_no = '';
    public string $cell_no = '';
    public string $length_of_stay = '';
    public string $ownership = '';
    public string $rent_amount = '';
    public string $place_of_birth = '';
    public string $age = '';
    public string $civil_status = '';
    public string $dependents = '';
    public string $spouse = '';
    public string $contact_person = '';
    public string $employment = '';
    public string $position = '';
    public string $employer_name = '';
    public string $employer_address = '';
    public string $nature_of_business = '';
    public string $years_in_business = '';
    public string $business_address = '';
    public string $spouse_employment = '';
    public string $spouse_position = '';
    public string $spouse_employer_name = '';
    public string $spouse_employer_address = '';
    public string $source_of_income = '';
    public string $monthly_income = '';
    public array $properties = [];
    public bool $success = false;
    public int $page = 1;
    public $data;
    public $photo;
    public $sketch;
    public bool $test = true;

    public function mount()
    {
        

        $this->properties = [
            ['type' => '', 'make_model' => '', 'years_acquired' => '', 'estimated_cost' => '']
        ];

        if($this->test) {
           $this->name = 'John Doe';
           $this->nick_name = 'John Doe';
           $this->address = '123 Main St, Anytown, USA';
           $this->date_of_birth = '1990-01-01';
           $this->tel_no = '1234567890';
           $this->cell_no = '1234567890';
           $this->length_of_stay = '1 year';
           $this->ownership = 'Own';
           $this->rent_amount = '1000';
           $this->place_of_birth = 'Anytown, USA';
           $this->age = '30';
           $this->civil_status = 'Single';
           $this->dependents = '0';
           $this->contact_person = 'John Doe';
           $this->employment = 'Employed';
           $this->position = 'Manager';
           $this->employer_name = 'John Doe';
           $this->employer_address = '123 Main St, Anytown, USA';
           $this->nature_of_business = 'Business';
           $this->years_in_business = '1 year';
           $this->business_address = '123 Main St, Anytown, USA';
           $this->spouse_employment = 'Employed';
           $this->spouse_position = 'Manager';
           $this->spouse_employer_name = 'John Doe';
           $this->spouse_employer_address = '123 Main St, Anytown, USA';
           $this->properties = [
                ['type' => 'House', 'make_model' => 'John Doe', 'years_acquired' => '2020', 'estimated_cost' => '1000000'],
                ['type' => 'Car', 'make_model' => 'Toyota', 'years_acquired' => '2021', 'estimated_cost' => '200000'],
                ['type' => 'Motorcycle', 'make_model' => 'Honda', 'years_acquired' => '2022', 'estimated_cost' => '50000'],
                ['type' => 'Cellphone', 'make_model' => 'Samsung', 'years_acquired' => '2023', 'estimated_cost' => '10000'],
            ];
        }

    }

    public function addProperties()
    {
        $this->properties[] = ['type' => '', 'make_model' => '', 'years_acquired' => '', 'estimated_cost' => ''];
    }

    public function removeProperties($index)
    {
        unset($this->properties[$index]);
        $this->properties = array_values($this->properties); // reindex the array
    }

    public function save() {

        $validated = $this->validate([
            'name' => ['required', 'string'],
            'nick_name' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'tel_no' => ['nullable', 'string'],
            'cell_no' => ['required', 'string'],
            'length_of_stay' => ['required', 'string'],
            'ownership' => ['required', 'string'],
            'rent_amount' => ['nullable', 'string'],
            'date_of_birth' => ['required', 'string'],
            'place_of_birth' => ['required', 'string'],
            'age' => ['required', 'string'],
            'civil_status' => ['required', 'string'],
            'dependents' => ['required', 'string'],
            'contact_person' => ['required', 'string'],

            'employment' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
            'employer_name' => ['nullable', 'string'],
            'employer_address' => ['nullable', 'string'],

            'nature_of_business' => ['nullable', 'string'],
            'years_in_business' => ['nullable', 'string'],
            'business_address' => ['nullable', 'string'],

            'spouse_employment' => ['nullable', 'string'],
            'spouse_position' => ['nullable', 'string'],
            'spouse_employer_name' => ['nullable', 'string'],
            'spouse_employer_address' => ['nullable', 'string'],

            'properties' => ['required', 'array'],
            'properties.*.type' => ['required', 'string'],
            'properties.*.make_model' => ['required', 'string'],
            'properties.*.years_acquired' => ['required', 'string'],
            'properties.*.estimated_cost' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:1024'],
            'sketch' => ['nullable', 'image', 'max:1024'],

            // 'source_of_income' => ['required', 'string'],
            // 'monthly_income' => ['required', 'string'],
            // 'personal_properties' => ['required', 'array'],
            // 'photo' => ['required', 'image', 'max:1024'],
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
            'name' => (isset($this->data['name'])) ? Crypt::encrypt($this->data['name']) : null,
            'nick_name' => (isset($this->data['nick_name'])) ? Crypt::encrypt($this->data['nick_name']) : null,
            'address' => (isset($this->data['address'])) ? Crypt::encrypt($this->data['address']) : null,
            'tel_no' => (isset($this->data['tel_no'])) ? Crypt::encrypt($this->data['tel_no']) : null,
            'cell_no' => (isset($this->data['cell_no'])) ? Crypt::encrypt($this->data['cell_no']) : null,
            'length_of_stay' => (isset($this->data['length_of_stay'])) ? Crypt::encrypt($this->data['length_of_stay']) : null,
            'ownership' => (isset($this->data['ownership'])) ? Crypt::encrypt($this->data['ownership']) : null,
            'rent_amount' => (isset($this->data['rent_amount'])) ? Crypt::encrypt($this->data['rent_amount']) : null,
            'date_of_birth' => (isset($this->data['date_of_birth'])) ? Crypt::encrypt($this->data['date_of_birth']) : null,
            'place_of_birth' => (isset($this->data['place_of_birth'])) ? Crypt::encrypt($this->data['place_of_birth']) : null,
            'age' => (isset($this->data['age'])) ? Crypt::encrypt($this->data['age']) : null,
            'civil_status' => (isset($this->data['civil_status'])) ? Crypt::encrypt($this->data['civil_status']) : null,
            'dependents' => (isset($this->data['dependents'])) ? Crypt::encrypt($this->data['dependents']) : null,
            'contact_person' => (isset($this->data['contact_person'])) ? Crypt::encrypt($this->data['contact_person']) : null,

            'employment' => (isset($this->data['employment'])) ? Crypt::encrypt($this->data['employment']) : null,
            'position' => (isset($this->data['position'])) ? Crypt::encrypt($this->data['position']) : null,
            'employer_name' => (isset($this->data['employer_name'])) ? Crypt::encrypt($this->data['employer_name']) : null,
            'employer_address' => (isset($this->data['employer_address'])) ? Crypt::encrypt($this->data['employer_address']) : null,

            'nature_of_business' => ($this->data['nature_of_business']) ? Crypt::encrypt($this->data['nature_of_business']) : null,
            'years_in_business' => (isset($this->data['years_in_business'])) ? Crypt::encrypt($this->data['years_in_business']) : null,
            'business_address' => (isset($this->data['business_address'])) ? Crypt::encrypt($this->data['business_address']) : null,

            'spouse_employment' => (isset($this->data['spouse_employment'])) ? Crypt::encrypt($this->data['spouse_employment']) : null,
            'spouse_position' => (isset($this->data['spouse_position'])) ? Crypt::encrypt($this->data['spouse_position']) : null,
            'spouse_employer_name' => (isset($this->data['spouse_employer_name'])) ? Crypt::encrypt($this->data['spouse_employer_name']) : null,
            'spouse_employer_address' => (isset($this->data['spouse_employer_address'])) ? Crypt::encrypt($this->data['spouse_employer_address']) : null,

            'properties' => (isset($this->data['properties']) &&    count($this->data['properties']) > 0) ? Crypt::encrypt(json_encode($this->data['properties'])) : null,

            // 'date_of_birth' => ($this->data['date_of_birth']) ? Crypt::encrypt($this->data['date_of_birth']) : null,
            // 'age' => ($this->data['age']) ? Crypt::encrypt($this->data['age']) : null,
            // 'civil_status' => ($this->data['civil_status']) ? Crypt::encrypt($this->data['civil_status']) : null,
            // 'spouse' => ($this->data['spouse']) ? Crypt::encrypt($this->data['spouse']) : null,
            // 'contact_person' => ($this->data['contact_person']) ? Crypt::encrypt($this->data['contact_person']) : null,
            // 'source_of_income' => ($this->data['source_of_income']) ? Crypt::encrypt($this->data['source_of_income']) : null,
            // 'monthly_income' => ($this->data['monthly_income']) ? Crypt::encrypt($this->data['monthly_income']) : null,
            // 'personal_properties' => ($this->data['personal_properties']) ? Crypt::encrypt(json_encode($this->data['personal_properties'])) : null,
        ];

        if($this->data['photo']) {
            $uniqueFileName = 'photo_' . time() . '_' . uniqid() . '.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('photos', $uniqueFileName, 'public');
            $encryptedData['photo'] = Crypt::encrypt($uniqueFileName);
        }

        if($this->data['sketch']) {
            $uniqueSketchFileName = 'sketch' . time() . '_' . uniqid() . '.' . $this->sketch->getClientOriginalExtension();
            $this->sketch->storeAs('photos', $uniqueSketchFileName, 'public');
            $encryptedData['sketch'] = Crypt::encrypt($uniqueSketchFileName);
        }


        $created = Application::create($encryptedData);

        if($created) {
            $this->success = true;

            session()->flash('saved', [
                'title' => 'Success',
                'text' => 'You have successfully submitted your application',
            ]);

            // Redirect to welcome route
            $this->redirectRoute('home');
        }
    }

    public function back() {
        $this->page = 1;
    }

}; ?>

<div>

@if($page === 1)

    <div class="max-w-3xl mx-auto p-5 font-sans bg-gray-50 rounded-lg shadow-md">
        <form wire:submit.prevent="save">
            <h2 class="text-center text-3xl font-semibold text-gray-800 mb-6">Credit Application Form</h2>
            
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="col-span-1">
                    <label for="name" class="block font-bold text-gray-700 text-sm">Name:</label>
                    <input type="text" id="name" wire:model="name"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="name" size="sm"/>
                </div>
                <div class="col-span-1">
                    <label for="nick_name" class="block font-bold text-gray-700 text-sm">Nick Name:</label>
                    <input type="text" id="nick_name" wire:model="nick_name"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="nick_name"/>
                </div>
                <div class="col-span-1">
                    <label for="address" class="block font-bold text-gray-700 text-sm">Address:</label>
                    <input type="text" id="address" wire:model="address"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="address" />
                </div>
                <div class="col-span-1">
                    <label for="tel_no" class="block font-bold text-gray-700 text-sm">Telephone No.:</label>
                    <input type="text" id="tel_no" wire:model="tel_no"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="tel_no" />
                </div>
                <div class="col-span-1">
                    <label for="cell_no" class="block font-bold text-gray-700 text-sm">Cell No.:</label>
                    <input type="text" id="cell_no" wire:model="cell_no"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="cell_no" />
                </div>
                <div class="col-span-1">
                    <label for="length_of_stay" class="block font-bold text-gray-700 text-sm">Length of Stay:</label>
                    <input type="text" id="length_of_stay" wire:model="length_of_stay"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="length_of_stay" />
                </div>
                <div class="col-span-1">
                    <label for="ownership" class="block font-bold text-gray-700 text-sm">Ownership:</label>
                    <select id="ownership" wire:model="ownership"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Ownership</option>
                        <option value="Owned">Owned</option>
                        <option value="Provided Free">Provided Free</option>
                        <option value="Rented">Rented</option>
                    </select>
                    <flux:error name="ownership" />
                </div>
                <div class="col-span-2">
                    <label for="rent_amount" class="block font-bold text-gray-700 text-sm">Rent Amount (if Rented):</label>
                    <input type="text" id="rent_amount" wire:model="rent_amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="rent_amount" />
                </div>
                <div class="col-span-1">
                    <label for="date_of_birth" class="block font-bold text-gray-700 text-sm">Date of Birth:</label>
                    <input type="date" id="date_of_birth" wire:model="date_of_birth"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="date_of_birth" />
                </div>
                <div class="col-span-1">
                    <label for="place_of_birth" class="block font-bold text-gray-700 text-sm">Place of Birth:</label>
                    <input type="text" id="place_of_birth" wire:model="place_of_birth"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="place_of_birth" />
                </div>
                <div class="col-span-1">
                    <label for="age" class="block font-bold text-gray-700 text-sm">Age:</label>
                    <input type="number" id="age" wire:model="age"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="age" />
                </div>
                <div class="col-span-1">
                    <label for="civil_status" class="block font-bold text-gray-700 text-sm">Civil Status:</label>
                    <input type="text" id="civil_status" wire:model="civil_status"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="civil_status" />
                </div>
                <div class="col-span-1">
                    <label for="dependents" class="block font-bold text-gray-700 text-sm">Number of Dependents:</label>
                    <input type="number" id="dependents" wire:model="dependents"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="dependents" />
                </div>
                <div class="col-span-1">
                    <label for="contact_person" class="block font-bold text-gray-700 text-sm">Contact Person:</label>
                    <input type="text" id="contact_person" wire:model="contact_person"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="contact_person" />
                </div>
            </div>
    
             <h3 class="text-xl font-semibold text-gray-800 mb-4">Sources of Income</h3>
            
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">A. Applicant's Employment Details</h4>
                <div class="space-y-4">
                    <div>
                        <label for="employment" class="block font-bold text-gray-700">Employment:</label>
                        <input type="text" id="employment" wire:model="employment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="employment" />
                    </div>
                    <div>
                        <label for="position" class="block font-bold text-gray-700">Position:</label>
                        <input type="text" id="position" wire:model="position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="position" />
                    </div>
                    <div>
                        <label for="employer_name" class="block font-bold text-gray-700">Name of Employer:</label>
                        <input type="text" id="employer_name" wire:model="employer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="employer_name" />
                    </div>
                    <div>
                        <label for="employer_address" class="block font-bold text-gray-700">Employer Address:</label>
                        <input type="text" id="employer_address" wire:model="employer_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="employer_address" />
                    </div>
                </div>
            </div>
    
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">B. Business</h4>
                <div class="space-y-4">
                    <div>
                        <label for="nature_of_business" class="block font-bold text-gray-700">Nature of Business:</label>
                        <input type="text" id="nature_of_business" wire:model="nature_of_business" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="nature_of_business" />
                    </div>
                    <div>
                        <label for="years_in_business" class="block font-bold text-gray-700">No. of Years in Business:</label>
                        <input type="number" id="years_in_business" wire:model="years_in_business" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="years_in_business" />
                    </div>
                    <div>
                        <label for="business_address" class="block font-bold text-gray-700">Business Address:</label>
                        <input type="text" id="business_address" wire:model="business_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="business_address" />
                    </div>
                </div>
            </div>
    
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">C. Spouse (If Employed)</h4>
                <div class="space-y-4">
                    <div>
                        <label for="spouse_employment" class="block font-bold text-gray-700">Employment:</label>
                        <input type="text" id="spouse_employment" wire:model="spouse_employment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_employment" />
                    </div>
                    <div>
                        <label for="spouse_position" class="block font-bold text-gray-700">Position:</label>
                        <input type="text" id="spouse_position" wire:model="spouse_position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_position" />
                    </div>
                    <div>
                        <label for="spouse_employer_name" class="block font-bold text-gray-700">Name of Employer:</label>
                        <input type="text" id="spouse_employer_name" wire:model="spouse_employer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="spouse_employer_address" class="block font-bold text-gray-700">Employer Address:</label>
                        <input type="text" id="spouse_employer_address" wire:model="spouse_employer_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_employer_address" />
                    </div>
                </div>
            </div>
    
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Personal Properties/Household Possessions</h3>
            <p class="text-gray-600 mb-4">(this shall be posted as collateral)</p>
    
            <div class="border-2 border-gray-300 rounded-lg p-6 bg-gray-50 shadow-md mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Type</th>
                                <th class="px-4 py-2 text-left">Make/Model</th>
                                <th class="px-4 py-2 text-left">Years Acquired</th>
                                <th class="px-4 py-2 text-left">Estimated Cost</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $index => $property)
                                <tr>
                                    <td class="px-4 py-2">
                                        <input type="text" wire:model="properties.{{ $index }}.type"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.type"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="text" wire:model="properties.{{ $index }}.make_model"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.make_model"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" wire:model="properties.{{ $index }}.years_acquired"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.years_acquired"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" wire:model="properties.{{ $index }}.estimated_cost"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.estimated_cost"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <button wire:click.prevent="removeProperties({{ $index }})" class="bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                           
                                    </td>
                                </tr>
                            @endforeach
                            
                           
                        </tbody>
                    </table>

                    <button wire:click.prevent="addProperties" class="bg-blue-500 text-white px-4 py-2 rounded">Add Properties</button>
                    <flux:error name="properties" />
                </div>
            </div>
    
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Upload</h3>
            <div class="mt-6">
                <label for="upload-id" class="block font-bold text-gray-700 mb-2">Upload  Sketch of Location of Residence/Business:</label>
                <input type="file" id="upload-id" name="upload-sketch" wire:model="sketch" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <flux:error name="sketch" />
            </div>
    
    
            <div class="mt-6">
                <label for="upload-id" class="block font-bold text-gray-700 mb-2">Upload ID:</label>
                <input type="file" id="upload-id" name="upload-id" accept="image/*" wire:model="photo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <flux:error name="photo" />
            </div>
    
            <div id="preview-box" class="mt-6 p-4 border-2 border-gray-800 rounded-lg hidden max-w-xs">
                <h3 class="text-lg font-semibold mb-2">Uploaded ID Preview</h3>
                <img id="preview-img" src="" alt="ID Preview" class="w-full h-auto border-2 border-gray-800 rounded-md">
            </div>
    
            <button type="submit" class="w-full py-3 px-4 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mt-6 text-lg font-medium transition-colors duration-200">
                Submit
            </button>
        </form>
    </div>
@endif

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
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Nick Name:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['nick_name'] }}</dd>
            </div>


            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Address:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['address'] }}</dd>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Telephone No.:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['tel_no'] }}</dd>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Cell No.:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['cell_no'] }}</dd>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Length of Stay:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['length_of_stay'] }}</dd>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Ownership:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['ownership'] }}</dd>
            </div>
            
            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Rent Amount:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['rent_amount'] }}</dd>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Date of Birth:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['date_of_birth'] }}</dd>
            </div>

            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Place of Birth:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['place_of_birth'] }}</dd>
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
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Number of Dependents:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['dependents'] }}</dd>
            </div>


            <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Contact Person:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['contact_person'] }}</dd>
            </div>


            <div class="bg-green-600 text-white text-center py-6 mb-6 rounded-t-lg shadow-md" style="background-color: #28a745 !important;">
                <h2 class="text-2xl font-semibold">Source Of Income</h2>
            </div>
            
            @if($data['employment'])
                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Employment:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['employment'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Position:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['position'] }}</dd>
                </div>


                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Employer Name:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['employer_name'] }}</dd>
                </div>


                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Employer Address:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['employer_address'] }}</dd>
                </div>
                
            @endif


            @if($data['nature_of_business'])
                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Nature of Business:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['nature_of_business'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">No. of Years in Business:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['years_in_business'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Business Address:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['business_address'] }}</dd>
                </div>
                
            @endif


            @if($data['spouse_employment'])
                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Spouse Employment:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['spouse_employment'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Spouse Position:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['spouse_position'] }}</dd>
                </div>
                
                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Spouse Employer Name:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['spouse_employer_name'] }}</dd>
                </div>

                <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3">Spouse Employer Address:</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">{{ $data['spouse_employer_address'] }}</dd>
                </div>
            @endif

            @if(count($data['properties']) > 0)

                <div class="bg-green-600 text-white text-center py-6 mb-6 rounded-t-lg shadow-md" style="background-color: #28a745 !important;">
                    <h2 class="text-2xl font-semibold">Properties</h2>
                </div>

                <table class="min-w-full border border-gray-200 divide-y divide-gray-200 mt-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Type</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Make/Model</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Year Acquired</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Estimated Cost</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($properties as $property)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $property['type'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $property['make_model'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $property['years_acquired'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">₱{{ number_format($property['estimated_cost'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

           

            {{-- <div class="flex flex-col py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300">Personal Properties:</dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                    @foreach($data['properties'] as $property)
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ $property }}</span>
                    @endforeach
                </dd>
            </div> --}}
        </div>

        <div class="bg-green-600 text-white text-center py-6 mb-6 rounded-t-lg shadow-md" style="background-color: #28a745 !important;">
            <h2 class="text-2xl font-semibold">Uploaded Documents</h2>
        </div>

        <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
            <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3"> Sketch :</dt>
            <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">
                @if ($sketch)
                    <img src="{{ $sketch->temporaryUrl() }}">
                @else
                    <span class="text-gray-500">No sketch uploaded</span>
                @endif
            </dd>
        </div>

        <div class="flex justify-between items-center py-3 px-2 bg-gray-50 dark:bg-gray-700 rounded-md">
            <dt class="text-sm font-semibold text-gray-600 dark:text-gray-300 w-1/3"> Uploaded ID :</dt>
            <dd class="text-lg font-semibold text-gray-900 dark:text-white w-2/3">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}">
                @else
                    <span class="text-gray-500">No ID uploaded</span>
                @endif
            </dd>
        </div>

        

        <div class="flex gap-4 mt-6">
            <flux:button variant="primary" type="button" class="w-full py-3 px-6 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition ease-in-out duration-300" wire:click="back">{{ __('Back') }}</flux:button>
            <flux:button variant="danger" type="button" class="w-full py-3 px-6 rounded-md bg-red-500 text-white hover:bg-red-600 transition ease-in-out duration-300" wire:click="saveToDb">{{ __('Submit') }}</flux:button>
        </div>
    </dl>

@endif
    
   
</div>
