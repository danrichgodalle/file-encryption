<?php

use Livewire\Volt\Component;
use App\Models\Application;

new class extends Component {

    public $applications;
    public function mount(): void
    {
       $this->applications = Application::whereStatus('approved')->get();
    }
    //
}; ?>

<div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
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
                        {{  $application->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{  $application->date_of_birth}}
                    </td>
                    <td class="px-6 py-4">
                        {{ $application->age }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->civil_status }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->spouse }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->contact_person }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $application->source_of_income }}
                    </td>
                    <td class="px-6 py-4">
                        {{  $application->monthly_income }}
                    </td>
                    <td class="px-6 py-4">
                        @if($application->personal_properties)
                            <ul>
                                @foreach(json_decode($application->personal_properties) as $property)
                                    <li>{{ $property }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>

                    <td class="py-8">
                        <img src="{{ asset('storage/photos/' . $application->photo) }}" alt="Photo" class="rounded-lg mt-4" width="100">
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
