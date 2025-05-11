<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public $loans;
    public $selectedLoan = null;
    public $declineReason = '';
    public $paymentAmount;
    public $paymentDate;
    public $editingPayment = null;

    public function mount()
    {
        $this->loans = Loan::with(['user', 'payments'])->latest()->get();
    }

    public function approveLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->update(['status' => 'approved']);
        $this->mount();
        session()->flash('message', 'Loan approved successfully.');
    }

    public function declineLoan($loanId)
    {
        $this->validate([
            'declineReason' => 'required|string|min:10'
        ]);

        $loan = Loan::findOrFail($loanId);
        $loan->update([
            'status' => 'declined',
            'decline_reason' => $this->declineReason
        ]);

        $this->declineReason = '';
        $this->mount();
        session()->flash('message', 'Loan declined successfully.');
    }

    public function selectLoan($loanId)
    {
        $this->selectedLoan = Loan::with(['payments'])->findOrFail($loanId);
        $this->paymentAmount = $this->selectedLoan->daily_payment;
        $this->paymentDate = now()->format('Y-m-d');
    }

    public function addPayment()
    {
        if (!$this->selectedLoan->canAcceptPayments()) {
            session()->flash('error', 'Cannot add payments to a completed loan.');
            return;
        }

        $this->validate([
            'paymentAmount' => 'required|numeric|min:0',
            'paymentDate' => 'required|date'
        ]);

        $this->selectedLoan->payments()->create([
            'amount' => $this->paymentAmount,
            'payment_date' => $this->paymentDate
        ]);

        // Check if total payments meet or exceed the total loan amount
        $totalPaid = $this->selectedLoan->payments()->sum('amount');
        if ($totalPaid >= $this->selectedLoan->total_amount) {
            $this->selectedLoan->update(['status' => 'completed']);
            session()->flash('message', 'Loan has been marked as completed.');
        }

        $this->mount();
        $this->selectLoan($this->selectedLoan->id);
        session()->flash('message', 'Payment added successfully.');
    }

    public function editPayment($paymentId)
    {
        $this->editingPayment = Payment::findOrFail($paymentId);
        $this->paymentAmount = $this->editingPayment->amount;
        $this->paymentDate = $this->editingPayment->payment_date->format('Y-m-d');
    }

    public function updatePayment()
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:0',
            'paymentDate' => 'required|date'
        ]);

        $this->editingPayment->update([
            'amount' => $this->paymentAmount,
            'payment_date' => $this->paymentDate
        ]);

        // Check if total payments meet or exceed the total loan amount
        $totalPaid = $this->selectedLoan->payments()->sum('amount');
        if ($totalPaid >= $this->selectedLoan->total_amount) {
            $this->selectedLoan->update(['status' => 'completed']);
            session()->flash('message', 'Loan has been marked as completed.');
        }

        $this->editingPayment = null;
        $this->mount();
        $this->selectLoan($this->selectedLoan->id);
        session()->flash('message', 'Payment updated successfully.');
    }

    public function deletePayment($paymentId)
    {
        Payment::findOrFail($paymentId)->delete();
        $this->mount();
        $this->selectLoan($this->selectedLoan->id);
        session()->flash('message', 'Payment deleted successfully.');
    }
}; ?>

<div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manage Loans</h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Total Loans: {{ $loans->count() }}</span>
            </div>
        </div>

        @if (session('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded relative mb-4 animate-fade-in-down">
                <p class="font-medium">{{ session('message') }}</p>
            </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-white-700 px-4 py-3 rounded relative mb-4 animate-fade-in-down">
            <p class="font-medium">{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Loans List -->
            <div class="space-y-4 overflow-y-auto max-h-[800px] pr-2">
                <div class="sticky top-0 bg-white z-10 pb-2">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Loan Applications</h3>
                </div>
                @foreach($loans as $loan)
                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200" 
                         wire:key="loan-{{ $loan->id }}">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1 space-y-2">
                                <div class="flex items-center space-x-2">
                                    <h4 class="font-semibold text-lg text-gray-800">{{ $loan->user->name }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full capitalize
                                        @if($loan->status === 'approved') bg-green-100 text-green-800
                                        @elseif($loan->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($loan->status === 'completed') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $loan->status }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-500">Amount:</span>
                                        <span class="font-medium">PHP {{ number_format($loan->amount, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Total Amount:</span>
                                        <span class="font-medium">PHP {{ number_format($loan->total_amount, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Daily Payment:</span>
                                        <span class="font-medium">PHP {{ number_format($loan->daily_payment, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Balance:</span>
                                        <span class="font-medium">PHP {{ number_format($loan->total_amount - $loan->payments->sum('amount'), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @if($loan->status === 'pending')
                                    <button wire:click="approveLoan({{ $loan->id }})" 
                                        class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approve
                                    </button>
                                    <button x-data @click="$dispatch('open-modal', 'decline-loan-{{ $loan->id }}')"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Decline
                                    </button>
                                @endif
                                @if($loan->status === 'approved')
                                    <button wire:click="selectLoan({{ $loan->id }})"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Manage Payments
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Decline Modal -->
                        <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'decline-loan-{{ $loan->id }}') open = true" class="relative">
                            <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center">
                                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">Decline Loan Application</h3>
                                    <textarea wire:model="declineReason" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        rows="3" 
                                        placeholder="Please provide a reason for declining this loan application..."></textarea>
                                    <div class="mt-4 flex justify-end space-x-2">
                                        <button @click="open = false" 
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                            Cancel
                                        </button>
                                        <button wire:click="declineLoan({{ $loan->id }})" @click="open = false"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            Confirm Decline
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($loans->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No loans found</h3>
                        <p class="mt-1 text-sm text-gray-500">There are currently no loan applications in the system.</p>
                    </div>
                @endif
            </div>

            <!-- Payments Management -->
            @if($selectedLoan)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-xl font-bold text-gray-800">Manage Payments for {{ $selectedLoan->user->name }}</h3>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="p-4 border-b border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-4">Payment Summary</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Total Amount Due</p>
                                <p class="text-lg font-semibold text-gray-900">PHP {{ number_format($selectedLoan->total_amount, 2) }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Total Paid</p>
                                <p class="text-lg font-semibold text-green-600">PHP {{ number_format($selectedLoan->payments->sum('amount'), 2) }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Remaining Balance</p>
                                <p class="text-lg font-semibold text-blue-600">PHP {{ number_format($selectedLoan->total_amount - $selectedLoan->payments->sum('amount'), 2) }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="text-lg font-semibold capitalize
                                    @if($selectedLoan->status === 'approved') text-green-600
                                    @elseif($selectedLoan->status === 'pending') text-yellow-600
                                    @elseif($selectedLoan->status === 'completed') text-blue-600
                                    @else text-red-600 @endif">
                                    {{ $selectedLoan->status }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <div class="p-4 border-b border-gray-200">
                        <form wire:submit.prevent="{{ $editingPayment ? 'updatePayment' : 'addPayment' }}" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">PHP</span>
                                    </div>
                                    <input type="number" wire:model="paymentAmount" step="0.01" 
                                        class="pl-12 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                @error('paymentAmount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" wire:model="paymentDate" 
                                    class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                @error('paymentDate') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                {{ $editingPayment ? 'Update Payment' : 'Add Payment' }}
                            </button>
                        </form>
                    </div>

                    <!-- Payment History -->
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-4">Payment History</h4>
                        <div class="space-y-2 max-h-[400px] overflow-y-auto">
                            @forelse($selectedLoan->payments->sortByDesc('payment_date') as $payment)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200" 
                                     wire:key="payment-{{ $payment->id }}">
                                    <div>
                                        <p class="font-medium text-gray-900">PHP {{ number_format($payment->amount, 2) }}</p>
                                        <p class="text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="editPayment({{ $payment->id }})"
                                            class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="deletePayment({{ $payment->id }})"
                                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    No payments recorded yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div> 