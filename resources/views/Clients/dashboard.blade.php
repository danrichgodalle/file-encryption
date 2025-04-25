<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-50">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#3D8BFF] text-white flex flex-col justify-between">
      <div>
        <!-- Profile Section -->
        <div class="p-6 text-center">
          <img
            src="https://i.ibb.co/4pDNDk1/avatar.png"
            alt="Avatar"
            class="w-16 h-16 rounded-full mx-auto mb-2 border-2 border-white shadow"
          />
          <!-- Dynamic user name display -->
          <div class="text-lg font-semibold">{{ Auth::guard('client')->user()->name }}</div>
          <div class="text-sm text-blue-100">{{ Auth::guard('client')->user()->email }}</div>
        </div>
        <nav class="flex flex-col px-6 space-y-2">
          <button onclick="showSection('dashboard')" class="bg-blue-300 text-blue-900 font-semibold rounded-xl py-2 px-4 text-left">
            Dashboard
          </button>
          <button onclick="showSection('loans')" class="hover:bg-blue-400 rounded-xl py-2 px-4 text-left">My Loans</button>
          <button onclick="showSection('apply')" class="hover:bg-blue-400 rounded-xl py-2 px-4 text-left">Apply Loan</button>
        </nav>
      </div>
      <div class="p-6">
        <!-- Laravel Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button
            type="submit"
            class="w-full border border-white text-white rounded-xl py-2 hover:bg-white hover:text-[#3D8BFF] transition"
          >
            Logout
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
      <!-- Dashboard Section -->
      <div id="dashboardSection">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Your Dashboard</h1>
        <div class="bg-white p-10 rounded-xl shadow text-center">
          <h2 class="text-2xl font-bold text-gray-700 mb-4">Hello, {{ Auth::guard('client')->user()->name }}!</h2>
          <p class="text-gray-600">Use the sidebar to apply for a loan or view your loan status.</p>
        </div>
      </div>

      <!-- Apply Loan Section -->
      <div id="applySection" class="hidden">
        <div class="bg-white p-10 rounded-xl shadow max-w-xl mx-auto">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Apply Loan</h2>

          <!-- Upload Image Form -->
          <form id="applicationForm" method="POST" action="/submit-form">
            <div style="margin-bottom: 1rem;">
              <label class="block text-sm font-medium text-gray-700 mb-2">Select Form Image (JPG/PNG):</label>
              <input
                type="file"
                id="imageInput"
                accept="image/*"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4"
              />
            </div>

            <!-- Hidden field to store PDF base64 -->
            <input type="hidden" name="application_pdf" id="application_pdf" />

            <button
              type="button"
              id="generateBtn"
              onclick="processImage()"
              class="w-full bg-blue-600 text-white py-2 rounded-lg text-lg font-semibold hover:bg-blue-500 transition"
            >
              📄 View as PDF
            </button>

            <button
              type="submit"
              id="submitBtn"
              disabled
              class="w-full bg-[#3D8BFF] text-white py-2 rounded-lg text-lg font-semibold hover:bg-blue-500 transition mt-4"
            >
              ✅ Submit
            </button>

            <p id="status" style="margin-top: 1rem; font-weight: bold;"></p>
          </form>

          <!-- Upload ID Section (added here in Apply Loan) -->
          <div class="bg-white shadow rounded-xl p-6 mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upload ID for Verification</h2>
            <form id="uploadIDForm" method="POST" action="/upload-id">
              <div class="flex flex-col space-y-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select ID Image (JPG/PNG):</label>
                <input
                  type="file"
                  id="idInput"
                  accept="image/*"
                  required
                  class="w-full border border-gray-300 rounded-lg px-4 py-2"
                />
                <button
                  type="submit"
                  class="w-full bg-green-600 text-white py-2 rounded-lg text-lg font-semibold hover:bg-green-500 transition"
                >
                  📤 Upload ID
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- My Loans Section -->
      <div id="loansSection" class="hidden">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">My Loan Monitoring</h1>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-xl mb-6 shadow">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-xl font-semibold">Loan Approved</h2>
              <p class="text-sm">Approval Date: <span class="font-medium">April 24, 2025</span></p>
              <p class="text-sm">Loan Amount: <span class="font-medium">₱3,000.00</span></p>
            </div>
            <div class="text-right">
              <h2 class="text-xl font-semibold">Next Due Date</h2>
              <p class="text-2xl font-bold">June 23, 2025</p>
              <span class="text-sm">₱3,000.00 total loan</span>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
          <table class="min-w-full text-sm text-gray-700">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Amount Paid</th>
                <th class="px-4 py-2 text-left">Balance</th>
                <th class="px-4 py-2 text-left">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b">
                <td class="px-4 py-2">April 20, 2025</td>
                <td class="px-4 py-2">₱300.00</td>
                <td class="px-4 py-2">₱2,700.00</td>
                <td class="px-4 py-2 text-green-600 font-semibold">Paid</td>
              </tr>
              <tr class="border-b">
                <td class="px-4 py-2">April 21, 2025</td>
                <td class="px-4 py-2">₱300.00</td>
                <td class="px-4 py-2">₱2,400.00</td>
                <td class="px-4 py-2 text-green-600 font-semibold">Paid</td>
              </tr>
              <tr class="border-b">
                <td class="px-4 py-2">April 22, 2025</td>
                <td class="px-4 py-2">₱300.00</td>
                <td class="px-4 py-2">₱2,100.00</td>
                <td class="px-4 py-2 text-yellow-500 font-semibold">Pending</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script>
    let generatedPDF = false; // Flag to ensure one-time generation

    // Function to process the image and generate PDF
    async function processImage() {
      // Check if the PDF has already been generated
      if (generatedPDF) {
        alert('The PDF has already been generated and cannot be regenerated.');
        return;
      }

      const file = document.getElementById('imageInput').files[0];
      if (!file) {
        alert('Please upload an image.');
        return;
      }

      document.getElementById('status').innerText = '🕐 Extracting text from image...';

      const reader = new FileReader();
      reader.onload = async function (e) {
        const imageData = e.target.result;

        // Run OCR using Tesseract
        const result = await Tesseract.recognize(imageData, 'eng', {
          logger: m => {
            document.getElementById('status').innerText = `📖 OCR Progress: ${Math.round((m.progress || 0) * 100)}%`;
          }
        });

        const extractedText = result.data.text;

        // Generate PDF using jsPDF
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        pdf.setFontSize(12);

        // Add spacing between lines
        const lineHeight = 10; // Adjust this value to increase/decrease the spacing
        let yPosition = 20; // Starting Y position

        // Split the extracted text into lines (para hindi magdikit-dikit)
        const lines = pdf.splitTextToSize(extractedText, 180); // Adjust 180 to control line width

        // Loop through the lines and add them to the PDF with spacing
        lines.forEach(line => {
          pdf.text(line, 10, yPosition);
          yPosition += lineHeight; // Add spacing after each line
        });

        // Show PDF preview
        const pdfBlob = pdf.output('blob');
        const url = URL.createObjectURL(pdfBlob);
        window.open(url, '_blank'); // Open in new tab

        // Set base64 value in hidden input for submission
        const base64PDF = pdf.output('datauristring');
        document.getElementById('application_pdf').value = base64PDF;

        // Mark the PDF as generated
        generatedPDF = true;

        // Disable the generate button and enable the submit button
        document.getElementById('generateBtn').disabled = true;
        document.getElementById('submitBtn').disabled = false;

        document.getElementById('status').innerText = '✅ PDF generated. You may now submit.';
      };

      reader.readAsDataURL(file);
    }

    // Prevent submit if no PDF generated yet
    document.getElementById('applicationForm').addEventListener('submit', function (e) {
      if (!generatedPDF) {
        e.preventDefault();
        alert('Please generate the PDF first.');
      }
    });

    // Show the correct section in the main content
    function showSection(section) {
      document.getElementById('dashboardSection').classList.add('hidden');
      document.getElementById('loansSection').classList.add('hidden');
      document.getElementById('applySection').classList.add('hidden');
      document.getElementById(section + 'Section').classList.remove('hidden');
    }
  </script>
</body>
</html>
