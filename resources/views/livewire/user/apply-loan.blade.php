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
     <div id="applySection" class="py-12 px-4">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-lg max-w-4xl mx-auto border border-gray-100">
          <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Loan Application</h2>

          @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-lg shadow-sm">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
          @endif

          <div class="text-center">
            @if ($hasPendingApplication)
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 mb-8 rounded-xl shadow-sm">
                    <p class="text-lg">You currently have a pending loan application. Please wait for it to be processed before submitting a new application.</p>
                </div>
            @elseif ($approvedApplication)
                <div class="bg-green-50 border border-green-200 text-green-800 p-6 mb-8 rounded-xl shadow-sm">
                    <p class="text-xl font-bold">🎉 Congratulations!</p>
                    <p class="text-lg mt-2">Your loan application has been approved.</p>
                </div>
                
                <!-- Approved Application Details -->
                <div class="mt-8 text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Application Details</h3>
                    <div class="space-y-6">
                        <!-- Photo Section -->
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">Applicant Photo</h4>
                            @if($approvedApplication->photo)
                                <div class="flex items-center justify-center">
                                    <div class="relative w-48 h-48 rounded-lg overflow-hidden border-4 border-white shadow-lg">
                                        <img 
                                            src="{{ Storage::url('photos/' . $approvedApplication->photo) }}" 
                                            alt="Applicant Photo" 
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 bg-white rounded-lg border-2 border-dashed border-gray-300">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No photo uploaded</p>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl">
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $approvedApplication->name }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Address</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $approvedApplication->address }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Contact Numbers</p>
                                <div class="mt-1">
                                    <p class="text-lg font-semibold text-gray-900">Tel No.: {{ $approvedApplication->tel_no }}</p>
                                    <p class="text-lg font-semibold text-gray-900">Mobile No.: {{ $approvedApplication->cell_no }}</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Employment Details</p>
                                <div class="mt-1">
                                    <p class="text-lg font-semibold text-gray-900">Status: {{ $approvedApplication->employment }}</p>
                                    <p class="text-lg font-semibold text-gray-900">Position: {{ $approvedApplication->position }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">Business Information</h4>
                            @if($approvedApplication->businesses)
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Name of Business</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nature of Business</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Years in Business</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Address</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach (json_decode($approvedApplication->businesses, true) as $index => $property)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $property['name'] }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $property['nature'] }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $property['years'] }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $property['address'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <p class="text-gray-500 text-center py-4">No business information available</p>
                            @endif
                        </div>
                        
                        <div class="mt-8">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">Properties</h4>
                            @if($approvedApplication->properties)
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Make/Model</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Year Acquired</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Estimated Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach (json_decode($approvedApplication->properties, true) as $index => $property)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $property['type'] }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $property['make_model'] }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $property['years_acquired'] }}</td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">₱{{ number_format($property['estimated_cost'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <p class="text-gray-500 text-center py-4">No properties available</p>
                            @endif
                        </div>

                        <!-- Signature Section -->
                        @if($approvedApplication->signature)
                            <div class="mt-8">
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Digital Signature</h4>
                                <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 max-w-sm mx-auto">
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
                <a href="{{ route('user.application-form') }}" 
                   class="inline-flex items-center justify-center bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-blue-700 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span>Start New Application</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
          </div>
        </div>
     </div>
</div>
