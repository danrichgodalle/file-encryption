<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Client Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50">

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#3D8BFF] text-white flex flex-col justify-between">
      <div>
        <!-- Profile Section -->
        <div class="p-6 text-center">
          <img src="https://i.ibb.co/4pDNDk1/avatar.png" alt="Avatar" class="w-16 h-16 rounded-full mx-auto mb-2 border-2 border-white shadow">
          <div class="text-lg font-semibold">{{ Auth::guard('client')->user()->name }}</div>
          <div class="text-sm text-blue-100">{{ Auth::guard('client')->user()->email }}</div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col px-6 space-y-2">
          <button onclick="showSection('dashboard')" class="bg-blue-300 text-blue-900 font-semibold rounded-xl py-2 px-4 text-left">Dashboard</button>
          <button onclick="showSection('loans')" class="hover:bg-blue-400 rounded-xl py-2 px-4 text-left">My Loans</button>
          <button onclick="showSection('apply')" class="hover:bg-blue-400 rounded-xl py-2 px-4 text-left">Apply Loan</button> <!-- Updated here -->
          <a href="#" class="hover:bg-blue-400 rounded-xl py-2 px-4">Client Users</a>
        </nav>
      </div>

      <!-- Logout Button -->
      <div class="p-6">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full border border-white text-white rounded-xl py-2 hover:bg-white hover:text-[#3D8BFF] transition">
            Logout
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">

      <!-- Dashboard (Welcome Page) -->
      <div id="dashboardSection">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Welcome to Your Dashboard</h1>
        </div>
        <div class="bg-white p-10 rounded-xl shadow text-center">
          <h2 class="text-2xl font-bold text-gray-700 mb-4">Hello, {{ Auth::guard('client')->user()->name }}!</h2>
          <p class="text-gray-600">Welcome to your personal dashboard. Use the sidebar to navigate through your loan options and status.</p>
        </div>
      </div>

      <!-- My Loans (Loan Monitoring + Due Date Box) -->
      <div id="loansSection" class="hidden">
        <div class="mb-6">
          <h1 class="text-3xl font-bold text-gray-800 mb-4">My Loan Monitoring</h1>

          <!-- Due Date Box -->
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

          <!-- Monitoring Table -->
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
      </div>

      <!-- Apply Loan (Loan Application Form) -->
      <div id="applySection" class="hidden">
        <div class="mb-6">
          <h1 class="text-3xl font-bold text-gray-800 mb-4">Apply for a Loan</h1>
          <div class="bg-white rounded-xl shadow p-6">
            <form class="space-y-4">
              <input type="text" placeholder="Loan Amount" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
              <input type="text" placeholder="Loan Type" class="w-full border border-gray-300 rounded-lg px-4 py-2">
              <input type="text" placeholder="Purpose" class="w-full border border-gray-300 rounded-lg px-4 py-2">
              <textarea placeholder="Description" class="w-full border border-gray-300 rounded-lg px-4 py-2 h-24 resize-none"></textarea>
              <button type="submit" class="w-full bg-[#3D8BFF] text-white py-2 rounded-lg text-lg font-semibold hover:bg-blue-500 transition">Submit Application</button>
            </form>
          </div>
        </div>
      </div>

    </main>
  </div>

  <!-- JavaScript to Toggle Sections -->
  <script>
    function showSection(section) {
      document.getElementById('dashboardSection').classList.add('hidden');
      document.getElementById('loansSection').classList.add('hidden');
      document.getElementById('applySection').classList.add('hidden');

      if (section === 'dashboard') {
        document.getElementById('dashboardSection').classList.remove('hidden');
      } else if (section === 'loans') {
        document.getElementById('loansSection').classList.remove('hidden');
      } else if (section === 'apply') {
        document.getElementById('applySection').classList.remove('hidden');
      }
    }
  </script>

</body>
</html>
