<?php

use Livewire\Volt\Component;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

new class extends Component {

    public $signatureData = false;

    public $applicationId;

    public function mount($id)
    {
        $this->applicationId = $id;
    }

    public function save()
    {
        if (!$this->signatureData) {
            return;
        }

        // Convert base64 to image
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->signatureData));
        
        // Generate unique filename
        $filename = 'signature_' . time() . '_' . uniqid() . '.png';
        
        // Save the image
        Storage::disk('public')->put('signatures/' . $filename, $image);

        // Update the application with the encrypted signature filename
        $application = Application::find($this->applicationId);
        if ($application) {
            $application->signature = Crypt::encrypt($filename);
            $application->save();
        }

        // Redirect to apply-loan page
        return $this->redirect(route('user.apply-loan'), navigate: true);
    }

    public function refresh()
    {
        $this->signatureData = false;
        $this->render();
    }
}; ?>

<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Digital Signature</h2>
        
        @if($signatureData)
            <div class="space-y-4">
                <div class="border-2 border-gray-200 rounded-lg p-4 bg-gray-50">
                    <img src="{{ $signatureData }}" alt="Signature Preview" class="max-w-md mx-auto">
                </div>
                <div class="flex justify-center">
                    <button type="button" 
                            wire:click="refresh" 
                            class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Draw New Signature
                    </button>
                </div>
            </div>
        @endif

        @if(!$signatureData)
            <div class="space-y-4">
                <p class="text-gray-600 mb-4">Please sign in the box below:</p>
                <div class="border-2 border-gray-200 rounded-lg bg-white">
                    <canvas id="signaturePad" class="w-full h-64" wire:ignore></canvas>
                </div>
                <div class="flex justify-center gap-3">
                    <button type="button" 
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center gap-2"
                            onclick="clearSignature()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Clear
                    </button>
                    <button type="button" 
                            id="signature-save-btn" 
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2"
                            wire:click="save">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Save Signature
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', function () {
        document.getElementById('signature-save-btn').addEventListener('click', function () {
            if (signaturePad.isEmpty()) {
                // Enhanced error message with better styling
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg';
                errorDiv.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Please provide a signature first
                    </div>
                `;
                document.body.appendChild(errorDiv);
                setTimeout(() => errorDiv.remove(), 3000);
                return;
            }

            const data = signaturePad.toDataURL();
            @this.set('signatureData', data);
        });
    });

    // Initialize when component loads
    document.addEventListener('livewire:initialized', () => {
        initializeSignaturePad();
    });
</script>