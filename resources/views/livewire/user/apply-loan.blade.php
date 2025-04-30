<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

new class extends Component {
    public $hasPendingApplication = false;
    public $approvedApplication = null;

    public function mount()
    {
        $this->hasPendingApplication = Application::where('user_id', auth()->id())
                                      ->where('status', 'pending')
                                      ->first();
                                      
        $this->approvedApplication = Application::where('user_id', auth()->id())
                                    ->where('status', 'approved')
                                    ->latest()
                                    ->first();
    }
}; ?>

<div>
     <!-- Apply Loan Section -->
     <div id="applySection">
        <div class="bg-white p-10 rounded-xl shadow max-w-xl mx-auto">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Apply Loan</h2>

          @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p>{{ session('error') }}</p>
            </div>
          @endif

          <div class="text-center">
            @if ($hasPendingApplication)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
                    <p>You currently have a pending loan application. Please wait for it to be processed before submitting a new application.</p>
                </div>
            @elseif ($approvedApplication)
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p class="font-semibold">Congratulations! Your loan application has been approved.</p>
                </div>
                
                <!-- Approved Application Details -->
                <div class="mt-6 text-left">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Application Details</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ $approvedApplication->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="font-medium">{{ $approvedApplication->address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Contact Numbers</p>
                                <p class="font-medium">
                                    Tel: {{ $approvedApplication->tel_no }}<br>
                                    Cell: {{ $approvedApplication->cell_no }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Employment Status</p>
                                <p class="font-medium">{{ $approvedApplication->employment }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Position</p>
                                <p class="font-medium">{{ $approvedApplication->position }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Employer</p>
                                <p class="font-medium">{{ $approvedApplication->employer_name }}</p>
                            </div>
                        </div>
                        
                
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">Properties</p>
                                @if($approvedApplication->properties)
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
                                        @foreach (json_decode($approvedApplication->properties, true) as $index => $property)
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

                     
                            <!-- Signature Section -->
                            @if($approvedApplication->signature)
                                <div class="mt-6">
                                    <p class="text-sm text-gray-600 mb-2">Signature</p>
                                    <div class="border border-gray-300 rounded-lg p-4 max-w-sm">
                                        <img 
                                            src="{{ Storage::url('signatures/' . $approvedApplication->signature) }}" 
                                            alt="Digital Signature" 
                                            class="max-w-full h-auto"
                                        >
                                    </div>
                                </div>
                            @endif
                 
                    </div>
                </div>
            @else
                <a href="{{ route('user.application-form') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200">
                    Start Application
                </a>
            @endif
          </div>
        </div>
     </div>
</div>
