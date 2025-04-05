<div class="max-w-3xl mx-auto p-5 font-sans bg-gray-50 rounded-lg shadow-md">
    <form wire:submit.prevent="submit">
        <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Credit Application Form</h2>
        
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="col-span-1">
                <label for="name" class="block font-bold text-gray-700">Name:</label>
                <input type="text" id="name" wire:model="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="nick_name" class="block font-bold text-gray-700">Nick Name:</label>
                <input type="text" id="nick_name" wire:model="nick_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-2">
                <label for="address" class="block font-bold text-gray-700">Address:</label>
                <input type="text" id="address" wire:model="address" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="tel_no" class="block font-bold text-gray-700">Telephone No.:</label>
                <input type="text" id="tel_no" wire:model="tel_no" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="cell_no" class="block font-bold text-gray-700">Cell No.:</label>
                <input type="text" id="cell_no" wire:model="cell_no" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="length_of_stay" class="block font-bold text-gray-700">Length of Stay:</label>
                <input type="text" id="length_of_stay" wire:model="length_of_stay" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="ownership" class="block font-bold text-gray-700">Ownership:</label>
                <select id="ownership" wire:model="ownership" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Owned">Owned</option>
                    <option value="Provided Free">Provided Free</option>
                    <option value="Rented">Rented</option>
                </select>
            </div>
            <div class="col-span-2">
                <label for="rent_amount" class="block font-bold text-gray-700">Rent Amount (if Rented):</label>
                <input type="text" id="rent_amount" wire:model="rent_amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="date_of_birth" class="block font-bold text-gray-700">Date of Birth:</label>
                <input type="date" id="date_of_birth" wire:model="date_of_birth" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="place_of_birth" class="block font-bold text-gray-700">Place of Birth:</label>
                <input type="text" id="place_of_birth" wire:model="place_of_birth" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="age" class="block font-bold text-gray-700">Age:</label>
                <input type="number" id="age" wire:model="age" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="civil_status" class="block font-bold text-gray-700">Civil Status:</label>
                <input type="text" id="civil_status" wire:model="civil_status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="dependents" class="block font-bold text-gray-700">Number of Dependents:</label>
                <input type="number" id="dependents" wire:model="dependents" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-1">
                <label for="contact_person" class="block font-bold text-gray-700">Contact Person:</label>
                <input type="text" id="contact_person" wire:model="contact_person" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-4">Sources of Income</h3>
        
        <div class="border border-gray-300 rounded-lg p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">A. Applicant's Employment Details</h4>
            <div class="space-y-4">
                <div>
                    <label for="employment" class="block font-bold text-gray-700">Employment:</label>
                    <input type="text" id="employment" wire:model="employment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="position" class="block font-bold text-gray-700">Position:</label>
                    <input type="text" id="position" wire:model="position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="employer_name" class="block font-bold text-gray-700">Name of Employer:</label>
                    <input type="text" id="employer_name" wire:model="employer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="employer_address" class="block font-bold text-gray-700">Employer Address:</label>
                    <input type="text" id="employer_address" wire:model="employer_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="border border-gray-300 rounded-lg p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">B. Business</h4>
            <div class="space-y-4">
                <div>
                    <label for="nature_of_business" class="block font-bold text-gray-700">Nature of Business:</label>
                    <input type="text" id="nature_of_business" wire:model="nature_of_business" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="years_in_business" class="block font-bold text-gray-700">No. of Years in Business:</label>
                    <input type="number" id="years_in_business" wire:model="years_in_business" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="business_address" class="block font-bold text-gray-700">Business Address:</label>
                    <input type="text" id="business_address" wire:model="business_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="border border-gray-300 rounded-lg p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">C. Spouse (If Employed)</h4>
            <div class="space-y-4">
                <div>
                    <label for="spouse_employment" class="block font-bold text-gray-700">Employment:</label>
                    <input type="text" id="spouse_employment" wire:model="spouse_employment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="spouse_position" class="block font-bold text-gray-700">Position:</label>
                    <input type="text" id="spouse_position" wire:model="spouse_position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="spouse_employer_name" class="block font-bold text-gray-700">Name of Employer:</label>
                    <input type="text" id="spouse_employer_name" wire:model="spouse_employer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="spouse_employer_address" class="block font-bold text-gray-700">Employer Address:</label>
                    <input type="text" id="spouse_employer_address" wire:model="spouse_employer_address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        </tr>
                    </thead>
                    <tbody>
              
                        <tr>
                            <td class="px-4 py-2">
                                <input type="text" wire:model="properties[type]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" wire:model="properties[make_model]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" wire:model="properties[years_acquired]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" wire:model="properties[estimated_cost]" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                        </tr>
                  
                    </tbody>
                </table>
            </div>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-4">Sketch of Location of Residence/Business</h3>
        <textarea wire:model="sketch" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 h-32"></textarea>

        <div class="mt-6">
            <label for="upload-id" class="block font-bold text-gray-700 mb-2">Upload ID:</label>
            <input type="file" id="upload-id" name="upload-id" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="previewImage(event)">
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

<script>
    function previewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var previewBox = document.getElementById('preview-box');
            var previewImg = document.getElementById('preview-img');
            previewImg.src = e.target.result;
            previewBox.classList.remove('hidden');
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
