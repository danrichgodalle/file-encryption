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
                <td><input type="number" id="tel_no" wire:model="tel_no" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" min="1000000" max="999999999999999" title="Telephone number must be a number with 7 to 15 digits." oninput="validateTelNo(this)"></td>

                <td><label for="cell_no" style="font-weight: bold;">Cell No.:</label></td>
                <td><input type="number" id="cell_no" wire:model="cell_no" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" min="1000000000" max="999999999999999" title="Cell number must be a number with 10 to 15 digits." oninput="validateCellNo(this)"></td>
            </tr>
            <tr>
                <td><label for="length_of_stay" style="font-weight: bold;">Length of Stay:</label></td>
                <td><input type="number" id="length_of_stay" wire:model="length_of_stay" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
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
                <td colspan="3"><input type="number" id="rent_amount" wire:model="rent_amount" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="date_of_birth" style="font-weight: bold;">Date of Birth:</label></td>
                <td><input type="date" id="date_of_birth" wire:model="date_of_birth" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" onchange="calculateAge()"></td>
                <td><label for="place_of_birth" style="font-weight: bold;">Place of Birth:</label></td>
                <td><input type="text" id="place_of_birth" wire:model="place_of_birth" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="age" style="font-weight: bold;">Age:</label></td>
                <td><input type="number" id="age" wire:model="age" required readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="civil_status" style="font-weight: bold;">Civil Status:</label></td>
                <td><input type="text" id="civil_status" wire:model="civil_status" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td><label for="dependents" style="font-weight: bold;">Number of Dependents:</label></td>
                <td><input type="number" id="dependents" wire:model="dependents" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></td>
                <td><label for="contact_person" style="font-weight: bold;">Contact Person:</label></td>
                <td><input type="tel" id="contact_person" wire:model="contact_person" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" pattern="[0-9]{10,15}" title="Contact number must be a number with 10 to 15 digits."></td>
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

        <div style="margin-top: 20px;">
            <label for="upload-id" style="display: block; margin-bottom: 8px;">Upload ID:</label>
            <input type="file" id="upload-id" name="upload-id" accept="image/*" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" onchange="previewImage(event)">
        </div>

        <div style="margin-top: 20px;">
            <label for="upload-signature" style="display: block; margin-bottom: 8px;">Upload Signature:</label>
            <input type="file" id="upload-signature" name="upload-signature" accept="image/*" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" onchange="previewSignature(event)">
        </div>

        <div id="preview-signature-box" style="margin-top: 20px; padding: 10px; border: 2px solid #2c3e50; border-radius: 8px; display: none; max-width: 300px;">
            <h3 style="font-size: 16px; margin-bottom: 10px;">Uploaded Signature Preview</h3>
            <img id="preview-signature-img" src="" alt="Signature Preview" style="max-width: 100%; height: auto; border: 2px solid #2c3e50; border-radius: 4px;">
        </div>

        <div id="preview-box" style="margin-top: 20px; padding: 10px; border: 2px solid #2c3e50; border-radius: 8px; display: none; max-width: 300px;">
            <h3 style="font-size: 16px; margin-bottom: 10px;">Uploaded ID Preview</h3>
            <img id="preview-img" src="" alt="ID Preview" style="max-width: 100%; height: auto; border: 2px solid #2c3e50; border-radius: 4px;">
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background-color: #2c3e50; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; margin-top: 20px;">Submit</button>
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
            previewBox.style.display = 'block';
        };
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function previewSignature(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var previewBox = document.getElementById('preview-signature-box');
            var previewImg = document.getElementById('preview-signature-img');
            previewImg.src = e.target.result;
            previewBox.style.display = 'block';
        };
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function calculateAge() {
        const dob = new Date(document.getElementById('date_of_birth').value);
        const today = new Date();
        const age = today.getFullYear() - dob.getFullYear();
        const month = today.getMonth() - dob.getMonth();
        
        if (month < 0 || (month === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        document.getElementById('age').value = age;
    }

    function validateTelNo(input) {
        if (input.value.length < 7 || input.value.length > 15) {
            alert("Telephone number must be between 7 to 15 digits.");
        }
    }

    function validateCellNo(input) {
        if (input.value.length < 10 || input.value.length > 15) {
            alert("Cell number must be between 10 to 15 digits.");
        }
    }
</script>
