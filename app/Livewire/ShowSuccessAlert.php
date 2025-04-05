<?php

namespace App\Livewire;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ShowSuccessAlert extends Component
{
    public function mount()
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->show();
        }
       
    }
    
    public function render()
    {
        return view('livewire.show-success-alert');
    }
}
