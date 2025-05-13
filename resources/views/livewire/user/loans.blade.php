<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

new class extends Component {
    public $amount = 3000;
    public $loans;
    public $hasActiveLoan = false;
    public $hasApprovedApplication = false;
    
    public function mount()
    {
        $this->loans = Auth::user()->loans()->with('payments')->latest()->get();
        $this->hasActiveLoan = Auth::user()->loans()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
        $this->hasApprovedApplication = Application::where('user_id', Auth::user()->id)->where('status', 'approved')->exists();
    }

    public function applyLoan()
    {
        if (!$this->hasApprovedApplication) {
            session()->flash('error', 'You need an approved application form before you can apply for a loan.');
            return;
        }

        if ($this->hasActiveLoan) {
            session()->flash('error', 'You already have an active loan. Please complete your current loan before applying for a new one.');
            return;
        }

        $this->validate([
            'amount' => 'required|numeric|min:3000',
        ]);

        $dailyPayment = $this->amount / 30; // 30 days payment term
        $totalAmount = $this->amount * 1.08; // 8% interest

        Auth::user()->loans()->create([
            'amount' => $this->amount,
            'total_amount' => $totalAmount,
            'daily_payment' => $dailyPayment,
        ]);

        $this->amount = 3000;
        $this->mount();
        session()->flash('message', 'Loan application submitted successfully.');
    }
}; ?>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Apply for Loan Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Apply for a Loan</h2>
            
            @if (session('message'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(!$hasApprovedApplication)
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">You need to have an approved application form before you can apply for a loan. Please complete your application first.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($hasActiveLoan)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">You currently have an active loan. You can apply for a new loan once your current loan is completed.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit="applyLoan" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Loan Amount (PHP)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₱</span>
                        </div>
                        <input type="number" 
                            wire:model="amount" 
                            min="3000" 
                            step="100" 
                            class="pl-8 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                            {{ (!$hasApprovedApplication || $hasActiveLoan) ? 'disabled' : '' }}>
                    </div>
                    @error('amount') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out"
                    {{ (!$hasApprovedApplication || $hasActiveLoan) ? 'disabled' : '' }}
                    :class="{ 'opacity-50 cursor-not-allowed': {{ (!$hasApprovedApplication || $hasActiveLoan) ? 'true' : 'false' }} }">
                    Apply for Loan
                </button>
            </form>
        </div>
    </div>

    <!-- Loans History Section -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Loans</h2>
        
        <div class="space-y-6">
            @foreach($loans as $loan)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <h3 class="text-lg font-semibold text-gray-900">PHP {{ number_format($loan->amount, 2) }}</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($loan->status === 'approved') bg-green-100 text-green-800
                                        @elseif($loan->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($loan->status === 'declined') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-base font-medium text-gray-900">PHP {{ number_format($loan->total_amount, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Daily Payment</p>
                                        <p class="text-base font-medium text-gray-900">PHP {{ number_format($loan->daily_payment, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <span class="text-sm text-gray-500">Applied on {{ $loan->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        @if($loan->status === 'declined')
                            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">Reason: {{ $loan->decline_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Payment History Section -->
                        @if($loan->payments->isNotEmpty())
                            <div class="mt-6 border-t border-gray-100 pt-6">
                                <h4 class="font-semibold text-lg text-gray-900 mb-4">Payment History</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($loan->payments->sortByDesc('payment_date') as $payment)
                                                <tr>
                                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $payment->payment_date->format('M d, Y') }}</td>
                                                    <td class="px-4 py-3 text-sm text-gray-900">PHP {{ number_format($payment->amount, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Total Paid</td>
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">PHP {{ number_format($loan->payments->sum('amount'), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Remaining Balance</td>
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">PHP {{ number_format($loan->total_amount - $loan->payments->sum('amount'), 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($loans->isEmpty())
                <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-4 text-gray-500 text-base">No loans found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
