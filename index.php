use with WithFileUploads

<!--public stsring $name = '';
public string $nick_name = '';
public string $address = '';
public string $tel_no = '';
public string $cell_no = '';
public string $length_of_stay = '';
public string $ownership = 'Owned';
public string $rent_amount = '';
public string $date_of_birth = '';
public string $place_of_birth = '';
public string $age = '';
public string $civil_status = '';
public string $dependents = '';
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
public string $sketch = '';
public array $properties = [
    ['type' => '', 'make_model' => '', 'years_acquired' => '', 'estimated_cost' => ''],
    ['type' => '', 'make_model' => '', 'years_acquired' => '', 'estimated_cost' => ''],
    ['type' => '', 'make_model' => '', 'years_acquired' => '', 'estimated_cost' => ''],
];
public string $upload_id = ''; // For file upload
public string $upload_id_path = ''; // For storing the path of the uploaded file
public string $upload_id_url = ''; // For storing the URL of the uploaded file
public string $upload_id_name = ''; // For storing the name of the uploaded file
public string $upload_id_size = ''; // For storing the size of the uploaded file
public string $upload_id_type = ''; // For storing the type of the uploaded file
public string $upload_id_error = ''; // For storing any error that occurs during the upload process
public string $upload_id_error_message = ''; // For storing the error message
public string $upload_id_error_code = ''; // For storing the error code that occurs during the upload process
-->

<!--
public function submit()
{
    $this->validate([
        'name' => 'required|string|max:255',
        'nick_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'tel_no' => 'required|string|max:20',
        'cell_no' => 'required|string|max:20',
        'length_of_stay' => 'required|string|max:50',
        'ownership' => 'required|string|in:Owned,Provided Free,Rented',
        'rent_amount' => 'nullable|numeric|min:0',
        'date_of_birth' => 'required|date',
        'place_of_birth' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'civil_status' => 'required|string|max:50',
        'dependents' => 'required|integer|min:0',
        'contact_person' => 'required|string|max:255',
        // Employment details
        'employment' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'employer_name' => 'nullable|string|max:255',
        'employer_address' => 'nullable|string|max:255',
        // Business details
        'nature_of_business' => 'nullable|string|max:255',
        'years_in_business' => 'nullable|integer|min:0',
        'business_address' => 'nullable|string|max:255',
        // Spouse details
        'spouse_employment' => 'nullable|string|max:255',
        'spouse_position' => 'nullable|string|max:255',
        'spouse_employer_name' => 'nullable|string|max:255',
        'spouse_employer_address' => 'nullable|string|max:255',
        // Properties
        'properties.*.type' => 'required|string|max:255',
        'properties.*.make_model' => 'required|string|max:255',
        'properties.*.years_acquired' => 'required|integer|min:0',
        'properties.*.estimated_cost' => 'required|numeric|min:0',
        // Sketch
        'sketch' => 'required|string|max:1000',
        // ID upload
        'upload_id' => 'nullable|image|max:2048', // 2MB max
        // Save the data to the database or perform any other action
        
    ]);

    -->

       <!-- public function saveToDb()
        $validated->this->validate([
            'name' => 'required|string|max:255',
            'nick_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tel_no' => 'required|string|max:20',
            'cell_no' => 'required|string|max:20',
            'length_of_stay' => 'required|string|max:50',
            'ownership' => 'required|string|in:Owned,Provided Free,Rented',
            'rent_amount' => 'nullable|numeric|min:0',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'civil_status' => 'required|string|max:50',
            'dependents' => 'required|integer|min:0',
            'contact_person' => 'required|string|max:255',
        ]);
       // Employment details
        'employment' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'employer_name' => 'nullable|string|max:255',
        'employer_address' => 'nullable|string|max:255',
        // Business details
        'nature_of_business' => 'nullable|string|max:255',
        'years_in_business' => 'nullable|integer|min:0',
        'business_address' => 'nullable|string|max:255',
        // Spouse details
        'spouse_employment' => 'nullable|string|max:255',
        'spouse_position' => 'nullable|string|max:255',
        'spouse_employer_name' => 'nullable|string|max:255',
        'spouse_employer_address' => 'nullable|string|max:255',
        // Properties
        'properties.*.type' => 'required|string|max:255',
        'properties.*.make_model' => 'required|string|max:255',
        'properties.*.years_acquired' => 'required|integer|min:0',
        'properties.*.estimated_cost' => 'required|numeric|min:0',
        // Sketch
        'sketch' => 'required|string|max:1000',
        // ID upload
        'upload_id' => 'nullable|image|max:2048', // 2MB max
    ]);
    // Save the data to the database or perform any other action

     #endregion -->--

<div style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
    <form wire:submit.prevent="submit">
        <h2 style="text-align: center; color: #2c3e50;">Credit Application Form</h2>
        
        <table style="width: 100%; border-spacing: 10px; margin-bottom: 20px;">
            <tr>
                <td><label for="name" style="font-weight: bold;">Name:</label></td>
                <td><input type="text" id="name" wire:model="name" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="nick_name" style="font-weight: bold;">Nick Name:</label></td>
                <td><input type="text" id="nick_name" wire:model="nick_name" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="address" style="font-weight: bold;">Address:</label></td>
                <td colspan="3"><input type="text" id="address" wire:model="address" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="tel_no" style="font-weight: bold;">Telephone No.:</label></td>
                <td><input type="text" id="tel_no" wire:model="tel_no" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="cell_no" style="font-weight: bold;">Cell No.:</label></td>
                <td><input type="text" id="cell_no" wire:model="cell_no" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="length_of_stay" style="font-weight: bold;">Length of Stay:</label></td>
                <td><input type="text" id="length_of_stay" wire:model="length_of_stay" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="ownership" style="font-weight: bold;">Ownership:</label></td>
                <td>
                    <select id="ownership" wire:model="ownership" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="Owned">Owned</option>
                        <option value="Provided Free">Provided Free</option>
                        <option value="Rented">Rented</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="rent_amount" style="font-weight: bold;">Rent Amount (if Rented):</label></td>
                <td colspan="3"><input type="text" id="rent_amount" wire:model="rent_amount" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="date_of_birth" style="font-weight: bold;">Date of Birth:</label></td>
                <td><input type="date" id="date_of_birth" wire:model="date_of_birth" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="place_of_birth" style="font-weight: bold;">Place of Birth:</label></td>
                <td><input type="text" id="place_of_birth" wire:model="place_of_birth" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="age" style="font-weight: bold;">Age:</label></td>
                <td><input type="number" id="age" wire:model="age" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="civil_status" style="font-weight: bold;">Civil Status:</label></td>
                <td><input type="text" id="civil_status" wire:model="civil_status" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="dependents" style="font-weight: bold;">Number of Dependents:</label></td>
                <td><input type="number" id="dependents" wire:model="dependents" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="contact_person" style="font-weight: bold;">Contact Person:</label></td>
                <td><input type="text" id="contact_person" wire:model="contact_person" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
        </table>

        <h3 style="color: #2c3e50;">Sources of Income</h3>
<div style="border: 1px solid #ccc; padding: 20px; margin-top: 20px; border-radius: 4px;">
    <h4 style="color: #2c3e50;">A. Applicant's Employment Details</h4>
    <div style="margin-bottom: 10px;">
        <label for="employment" style="font-weight: bold;">Employment:</label>
        <input type="text" id="employment" wire:model="employment" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="position" style="font-weight: bold;">Position:</label>
        <input type="text" id="position" wire:model="position" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="employer_name" style="font-weight: bold;">Name of Employer:</label>
        <input type="text" id="employer_name" wire:model="employer_name" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="employer_address" style="font-weight: bold;">Employer Address:</label>
        <input type="text" id="employer_address" wire:model="employer_address" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
</div>

<div style="border: 1px solid #ccc; padding: 20px; margin-top: 20px; border-radius: 4px;">
    <h4 style="color: #2c3e50;">B. Business</h4>
    <div style="margin-bottom: 10px;">
        <label for="nature_of_business" style="font-weight: bold;">Nature of Business:</label>
        <input type="text" id="nature_of_business" wire:model="nature_of_business" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="years_in_business" style="font-weight: bold;">No. of Years in Business:</label>
        <input type="number" id="years_in_business" wire:model="years_in_business" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="business_address" style="font-weight: bold;">Business Address:</label>
        <input type="text" id="business_address" wire:model="business_address" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
</div>

<div style="border: 1px solid #ccc; padding: 20px; margin-top: 20px; border-radius: 4px;">
    <h4 style="color: #2c3e50;">C. Spouse (If Employed)</h4>
    <div style="margin-bottom: 10px;">
        <label for="spouse_employment" style="font-weight: bold;">Employment:</label>
        <input type="text" id="spouse_employment" wire:model="spouse_employment" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="spouse_position" style="font-weight: bold;">Position:</label>
        <input type="text" id="spouse_position" wire:model="spouse_position" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="spouse_employer_name" style="font-weight: bold;">Name of Employer:</label>
        <input type="text" id="spouse_employer_name" wire:model="spouse_employer_name" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="spouse_employer_address" style="font-weight: bold;">Employer Address:</label>
        <input type="text" id="spouse_employer_address" wire:model="spouse_employer_address" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
</div>


<h3 style="color: #2c3e50;">Personal Properties/Household Possessions</h3>
<p>(this shall be posted as collateral)</p>

<!-- Box containing the table -->
<div style="border: 2px solid #ccc; padding: 20px; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
    <table style="width: 100%; border-spacing: 10px; margin-bottom: 20px;">
        <tr>
            <th>Type</th>
            <th>Make/Model</th>
            <th>Years Acquired</th>
            <th>Estimated Cost</th>
        </tr>
        @foreach($properties as $index => $property)
            <tr>
                <td><input type="text" wire:model="properties.{{$index}}.type" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><input type="text" wire:model="properties.{{$index}}.make_model" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><input type="number" wire:model="properties.{{$index}}.years_acquired" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><input type="number" wire:model="properties.{{$index}}.estimated_cost" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
        @endforeach
    </table>
</div>


        <h3 style="color: #2c3e50;">Sketch of Location of Residence/Business</h3>
        <textarea wire:model="sketch" required style="width: 100%; padding: 10px; height: 100px; border: 1px solid #ccc; border-radius: 4px;"></textarea>

      
<!-- Upload ID Section -->
<div style="margin-top: 20px;">
    <label for="upload-id" style="display: block; margin-bottom: 8px;">Upload ID:</label>
    <input type="file" id="upload-id" name="upload-id" accept="image/*" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" onchange="previewImage(event)">
</div>

<!-- Box for Previewing ID -->
<div id="preview-box" style="margin-top: 20px; padding: 10px; border: 2px solid #2c3e50; border-radius: 8px; display: none; max-width: 300px;">
    <h3 style="font-size: 16px; margin-bottom: 10px;">Uploaded ID Preview</h3>
    <img id="preview-img" src="" alt="ID Preview" style="max-width: 100%; height: auto; border: 2px solid #2c3e50; border-radius: 4px;">
</div>

<!-- Submit Button -->
<button type="submit" style="width: 100%; padding: 10px; background-color: #2c3e50; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; margin-top: 20px;">Submit</button>

<script>
    function previewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var previewBox = document.getElementById('preview-box');
            var previewImg = document.getElementById('preview-img');
            previewImg.src = e.target.result;
            previewBox.style.display = 'block';  // Show the preview box
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
