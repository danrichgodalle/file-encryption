<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Application;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;


new class extends Component {

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
    public int $currentStep = 1;
    public $data;
    public $photo;
    public $sketch;
    public bool $test = true;
    public $signaturePath;
    public $signatureData;

    // #[On('signature-saved')] 
    // public function handleSignatureSaved($signature)
    // {
    //     $this->signatureData = $signature;
    // }

    public function mount()
    {
        // Check if user has a pending application
        $pendingApplication = Application::where('user_id', auth()->id())
                                      ->where('status', 'pending')
                                      ->first();

        if ($pendingApplication) {
            session()->flash('error', 'You already have a pending application waiting for approval.');
            $this->redirectRoute('user.apply-loan');
            return;
        }
      
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
           $this->years_in_business = '1';
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

    public function save()
    {
        // Convert base64 to image
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->signatureData));
        
        // Generate unique filename
        $filename = 'signatures/signature_' . time() . '_' . uniqid() . '.png';
        
        // Save the image
        Storage::disk('public')->put($filename, $image);
        
        // Store the path
        $this->signaturePath = $filename;
    }




    public function addProperties()
    {
        $this->properties[] = ['type' => '', 'make_model' => '', 'years_acquired' => '', 'estimated_cost' => ''];
    }

    public function removeProperties($index)
    {
        unset($this->properties[$index]);
        $this->properties = array_values($this->properties);
    }

    public function nextStep()
    {
        $this->validate($this->getStepValidationRules());
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function getStepValidationRules()
    {
        return match($this->currentStep) {
            1 => [
                'name' => ['required', 'string'],
                'nick_name' => ['nullable', 'string'],
                'address' => ['required', 'string'],
                'tel_no' => ['nullable', 'integer'],
                'cell_no' => ['required', 'integer'],
                'length_of_stay' => ['required', 'string'],
                'ownership' => ['required', 'string'],
                'rent_amount' => ['nullable', 'numeric'],
                'date_of_birth' => ['required', 'string'],
                'place_of_birth' => ['required', 'string'],
                'age' => ['required', 'integer'],
                'civil_status' => ['required', 'string'],
                'dependents' => ['required', 'integer'],
                'contact_person' => ['required', 'string'],
            ],
            2 => [
                'employment' => ['nullable', 'string'],
                'position' => ['nullable', 'string'],
                'employer_name' => ['nullable', 'string'],
                'employer_address' => ['nullable', 'string'],
                'nature_of_business' => ['nullable', 'string'],
                'years_in_business' => ['nullable', 'integer'],
                'business_address' => ['nullable', 'string'],
                'spouse_employment' => ['nullable', 'string'],
                'spouse_position' => ['nullable', 'string'],
                'spouse_employer_name' => ['nullable', 'string'],
                'spouse_employer_address' => ['nullable', 'string'],
            ],
            3 => [
                'properties' => ['required', 'array'],
                'properties.*.type' => ['required', 'string'],
                'properties.*.make_model' => ['required', 'string'],
                'properties.*.years_acquired' => ['required', 'string'],
                'properties.*.estimated_cost' => ['required', 'string'],
            ],
            4 => [
                'photo' => ['required', 'image', 'max:1024'],
                'sketch' => ['required', 'image', 'max:1024']
            ],
            default => [],
        };
    }

    public function saveToDb()
    {
    
        $this->validate($this->getStepValidationRules());
        $encryptedData = [
            'name' => (isset($this->name)) ? Crypt::encrypt($this->name) : null,
            'nick_name' => (isset($this->nick_name)) ? Crypt::encrypt($this->nick_name) : null,
            'address' => (isset($this->address)) ? Crypt::encrypt($this->address) : null,
            'tel_no' => (isset($this->tel_no)) ? Crypt::encrypt($this->tel_no) : null,
            'cell_no' => (isset($this->cell_no)) ? Crypt::encrypt($this->cell_no) : null,
            'length_of_stay' => (isset($this->length_of_stay)) ? Crypt::encrypt($this->length_of_stay) : null,
            'ownership' => (isset($this->ownership)) ? Crypt::encrypt($this->ownership) : null,
            'rent_amount' => (isset($this->rent_amount)) ? Crypt::encrypt($this->rent_amount) : null,
            'date_of_birth' => (isset($this->date_of_birth)) ? Crypt::encrypt($this->date_of_birth) : null,
            'place_of_birth' => (isset($this->place_of_birth)) ? Crypt::encrypt($this->place_of_birth) : null,
            'age' => (isset($this->age)) ? Crypt::encrypt($this->age) : null,
            'civil_status' => (isset($this->civil_status)) ? Crypt::encrypt($this->civil_status) : null,
            'dependents' => (isset($this->dependents)) ? Crypt::encrypt($this->dependents) : null,
            'contact_person' => (isset($this->contact_person)) ? Crypt::encrypt($this->contact_person) : null,
            'employment' => (isset($this->employment)) ? Crypt::encrypt($this->employment) : null,
            'position' => (isset($this->position)) ? Crypt::encrypt($this->position) : null,
            'employer_name' => (isset($this->employer_name)) ? Crypt::encrypt($this->employer_name) : null,
            'employer_address' => (isset($this->employer_address)) ? Crypt::encrypt($this->employer_address) : null,
            'nature_of_business' => (isset($this->nature_of_business)) ? Crypt::encrypt($this->nature_of_business) : null,
            'years_in_business' => (isset($this->years_in_business)) ? Crypt::encrypt($this->years_in_business) : null,
            'business_address' => (isset($this->business_address)) ? Crypt::encrypt($this->business_address) : null,
            'spouse_employment' => (isset($this->spouse_employment)) ? Crypt::encrypt($this->spouse_employment) : null,
            'spouse_position' => (isset($this->spouse_position)) ? Crypt::encrypt($this->spouse_position) : null,
            'spouse_employer_name' => (isset($this->spouse_employer_name)) ? Crypt::encrypt($this->spouse_employer_name) : null,
            'spouse_employer_address' => (isset($this->spouse_employer_address)) ? Crypt::encrypt($this->spouse_employer_address) : null,
            'properties' => (isset($this->properties) && count($this->properties) > 0) ? Crypt::encrypt(json_encode($this->properties)) : null,
        ];

        if($this->photo) {
            $uniqueFileName = 'photo_' . time() . '_' . uniqid() . '.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('photos', $uniqueFileName, 'public');
            $encryptedData['photo'] = Crypt::encrypt($uniqueFileName);
        }

        if($this->sketch) {
            $uniqueSketchFileName = 'sketch_' . time() . '_' . uniqid() . '.' . $this->sketch->getClientOriginalExtension();
            $this->sketch->storeAs('photos', $uniqueSketchFileName, 'public');
            $encryptedData['sketch'] = Crypt::encrypt($uniqueSketchFileName);
        }

        if($this->signatureData) {
            // Convert base64 to image
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->signatureData));
            
            // Generate unique filename
            $signatureFileName = 'signature_' . time() . '_' . uniqid() . '.png';
            
            // Save the image
            Storage::disk('public')->put('signatures/' . $signatureFileName, $image);
            
            // Store encrypted filename
            $encryptedData['signature'] = Crypt::encrypt($signatureFileName);
        }

        // Add user_id to the encrypted data
        $encryptedData['user_id'] = auth()->id();

        $created = Application::create($encryptedData);

        if($created) {
            $this->success = true;
            session()->flash('saved', [
                'title' => 'Success',
                'text' => 'You have successfully submitted your application',
            ]);
            
            $this->redirectRoute('user.signature', ['id' => $created->id]);
        }
    }
}; ?>

<div class="max-w-1xl mx-auto p-5 font-sans bg-gray-50 rounded-lg shadow-md">
    <!-- Stepper -->
    <div class="mb-15">
        <div class="flex items-center justify-between">
            <div class="flex items-center w-full">
                <!-- Step 1 -->
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 {{ $currentStep >= 1 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 text-gray-300' }}">
                        <span class="font-bold">1</span>
                    </div>
                    <div class="absolute top-0 text-center mt-16 w-32 text-xs font-medium {{ $currentStep >= 1 ? 'text-green-600' : 'text-gray-500' }}">Personal Information</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $currentStep >= 2 ? 'border-green-600' : 'border-gray-300' }}"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 {{ $currentStep >= 2 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 text-gray-300' }}">
                        <span class="font-bold">2</span>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium {{ $currentStep >= 2 ? 'text-green-600' : 'text-gray-500' }}">Source of Income</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $currentStep >= 3 ? 'border-green-600' : 'border-gray-300' }}"></div>
                
                <!-- Step 3 -->
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 {{ $currentStep >= 3 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 text-gray-300' }}">
                        <span class="font-bold">3</span>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium {{ $currentStep >= 3 ? 'text-green-600' : 'text-gray-500' }}">Personal Property</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $currentStep >= 4 ? 'border-green-600' : 'border-gray-300' }}"></div>
                
                <!-- Step 4 -->
                <div class="flex items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 {{ $currentStep >= 4 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 text-gray-300' }}">
                        <span class="font-bold">4</span>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium {{ $currentStep >= 4 ? 'text-green-600' : 'text-gray-500' }}">Upload Documents</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: Personal Information -->
    @if($currentStep === 1)
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-6">Personal Information</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-1">
                    <label for="name" class="block font-bold text-gray-700 text-sm">Name:</label>
                    <input type="text" id="name" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="name"/>
                </div>
                <div class="col-span-1">
                    <label for="nick_name" class="block font-bold text-gray-700 text-sm">Nick Name:</label>
                    <input type="text" id="nick_name" wire:model="nick_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="nick_name"/>
                </div>
                <div class="col-span-1">
                    <label for="address" class="block font-bold text-gray-700 text-sm">Address:</label>
                    <input type="text" id="address" wire:model="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="address"/>
                </div>
                <div class="col-span-1">
                    <label for="tel_no" class="block font-bold text-gray-700 text-sm">Telephone No.:</label>
                    <input type="text" id="tel_no" wire:model="tel_no" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="tel_no"/>
                </div>
                <div class="col-span-1">
                    <label for="cell_no" class="block font-bold text-gray-700 text-sm">Cell No.:</label>
                    <input type="text" id="cell_no" wire:model="cell_no" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="cell_no"/>
                </div>
                <div class="col-span-1">
                    <label for="length_of_stay" class="block font-bold text-gray-700 text-sm">Length of Stay:</label>
                    <input type="text" id="length_of_stay" wire:model="length_of_stay" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="length_of_stay"/>
                </div>
                <div class="col-span-1">
                    <label for="ownership" class="block font-bold text-gray-700 text-sm">Ownership:</label>
                    <select id="ownership" wire:model="ownership" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Ownership</option>
                        <option value="Owned">Owned</option>
                        <option value="Provided Free">Provided Free</option>
                        <option value="Rented">Rented</option>
                    </select>
                    <flux:error name="ownership"/>
                </div>
                <div class="col-span-2">
                    <label for="rent_amount" class="block font-bold text-gray-700 text-sm">Rent Amount (if Rented):</label>
                    <input type="text" id="rent_amount" wire:model="rent_amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="rent_amount"/>
                </div>
                <div class="col-span-1">
                    <label for="date_of_birth" class="block font-bold text-gray-700 text-sm">Date of Birth:</label>
                    <input type="date" id="date_of_birth" wire:model="date_of_birth" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="date_of_birth"/>
                </div>
                <div class="col-span-1">
                    <label for="place_of_birth" class="block font-bold text-gray-700 text-sm">Place of Birth:</label>
                    <input type="text" id="place_of_birth" wire:model="place_of_birth" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="place_of_birth"/>
                </div>
                <div class="col-span-1">
                    <label for="age" class="block font-bold text-gray-700 text-sm">Age:</label>
                    <input type="number" id="age" wire:model="age" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="age"/>
                </div>
                <div class="col-span-1">
                    <label for="civil_status" class="block font-bold text-gray-700 text-sm">Civil Status:</label>
                    <input type="text" id="civil_status" wire:model="civil_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="civil_status"/>
                </div>
                <div class="col-span-1">
                    <label for="dependents" class="block font-bold text-gray-700 text-sm">Number of Dependents:</label>
                    <input type="number" id="dependents" wire:model="dependents" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="dependents"/>
                </div>
                <div class="col-span-1">
                    <label for="contact_person" class="block font-bold text-gray-700 text-sm">Contact Person:</label>
                    <input type="text" id="contact_person" wire:model="contact_person" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="contact_person"/>
                </div>
            </div>
        </div>
    @endif

    <!-- Step 2: Source of Income -->
    @if($currentStep === 2)
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-6">Source of Income</h2>
            
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">A. Applicant's Employment Details</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="employment" class="block font-bold text-gray-700">Employment:</label>
                        <input type="text" id="employment" wire:model="employment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="employment"/>
                    </div>
                    <div>
                        <label for="position" class="block font-bold text-gray-700">Position:</label>
                        <input type="text" id="position" wire:model="position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="position"/>
                    </div>
                    <div class="col-span-2">
                        <label for="employer_name" class="block font-bold text-gray-700">Name of Employer:</label>
                        <input type="text" id="employer_name" wire:model="employer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="employer_name"/>
                    </div>
                    <div class="col-span-2">
                        <label for="employer_address" class="block font-bold text-gray-700">Employer Address:</label>
                        <input type="text" id="employer_address" wire:model="employer_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="employer_address"/>
                    </div>
                </div>
            </div>
    
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">B. Business</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="nature_of_business" class="block font-bold text-gray-700">Nature of Business:</label>
                        <input type="text" id="nature_of_business" wire:model="nature_of_business" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="nature_of_business"/>
                    </div>
                    <div>
                        <label for="years_in_business" class="block font-bold text-gray-700">No. of Years in Business:</label>
                        <input type="number" id="years_in_business" wire:model="years_in_business" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="years_in_business"/>
                    </div>
                    <div class="col-span-2">
                        <label for="business_address" class="block font-bold text-gray-700">Business Address:</label>
                        <input type="text" id="business_address" wire:model="business_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="business_address"/>
                    </div>
                </div>
            </div>
    
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">C. Spouse (If Employed)</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="spouse_employment" class="block font-bold text-gray-700">Employment:</label>
                        <input type="text" id="spouse_employment" wire:model="spouse_employment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_employment"/>
                    </div>
                    <div>
                        <label for="spouse_position" class="block font-bold text-gray-700">Position:</label>
                        <input type="text" id="spouse_position" wire:model="spouse_position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_position"/>
                    </div>
                    <div class="col-span-2">
                        <label for="spouse_employer_name" class="block font-bold text-gray-700">Name of Employer:</label>
                        <input type="text" id="spouse_employer_name" wire:model="spouse_employer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_employer_name"/>
                    </div>
                    <div class="col-span-2">
                        <label for="spouse_employer_address" class="block font-bold text-gray-700">Employer Address:</label>
                        <input type="text" id="spouse_employer_address" wire:model="spouse_employer_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <flux:error name="spouse_employer_address"/>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Step 3: Personal Property -->
    @if($currentStep === 3)
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-6">Personal Properties/Household Possessions</h2>
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
                                        <input type="text" wire:model="properties.{{ $index }}.type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.type"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="text" wire:model="properties.{{ $index }}.make_model" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.make_model"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" wire:model="properties.{{ $index }}.years_acquired" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.years_acquired"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" wire:model="properties.{{ $index }}.estimated_cost" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <flux:error name="properties.{{ $index }}.estimated_cost"/>
                                    </td>
                                    <td class="px-4 py-2">
                                        <button wire:click.prevent="removeProperties({{ $index }})" class="bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button wire:click.prevent="addProperties" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Add Properties</button>
                    <flux:error name="properties"/>
                </div>
            </div>
        </div>
    @endif

    <!-- Step 4: Upload Documents -->
    @if($currentStep === 4)
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-6">Upload Documents</h2>
            
            <div class="space-y-6">
                <div>
                    <label for="sketch" class="block font-bold text-gray-700 mb-2">Upload Sketch of Location of Residence/Business:</label>
                    <input type="file" id="sketch" wire:model="sketch" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="sketch"/>
                </div>

                <div>
                    <label for="photo" class="block font-bold text-gray-700 mb-2">Upload ID:</label>
                    <input type="file" id="photo" wire:model="photo" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <flux:error name="photo"/>
                </div>

                @if($sketch)
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold mb-2">Sketch Preview</h3>
                        <img src="{{ $sketch->temporaryUrl() }}" alt="Sketch Preview" class="max-w-xs border rounded-lg">
                    </div>
                @endif

                @if($photo)
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold mb-2">ID Preview</h3>
                        <img src="{{ $photo->temporaryUrl() }}" alt="ID Preview" class="max-w-xs border rounded-lg">
                    </div>
                @endif
                {{-- <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">Signature</h3>
                    <p class="mt-1 text-sm text-gray-600">Please provide your signature below.</p>
                    
                    <div class="mt-4" wire:ignore.self>
                        <livewire:signature-pad />

                        <flux:error name="signatureData"/>
                    </div>
                </div> --}}
            </div>
        </div>
    @endif

    <!-- Navigation Buttons -->
    <div class="flex justify-between mt-6">
        @if($currentStep > 1)
            <button wire:click="previousStep" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
            </button>
        @else
            <div></div>
        @endif

        @if($currentStep < 4)
            <button wire:click="nextStep" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-200 flex items-center">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @else
        
            <button wire:click="saveToDb" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Submit Application
            </button>
        @endif
    </div>

</div>


</div>
