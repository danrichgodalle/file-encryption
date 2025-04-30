<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">

        <aside class="w-64 bg-[#3D8BFF] text-white flex flex-col justify-between">
            <div>
                <div class="p-6 text-center">
                    <div>
                        <div class="p-6 text-center">
                            <img
                              src="https://i.ibb.co/4pDNDk1/avatar.png"
                              alt="Avatar"
                              class="w-16 h-16 rounded-full mx-auto mb-2 border-2 border-white shadow"
                            />
                            <!-- Dynamic user name display -->
                            <div class="text-lg font-semibold">{{ auth()->user()->name }}</div>
                            <div class="text-sm text-blue-100">{{ auth()->user()->email }}</div>
                          </div>

                          <nav class="flex flex-col px-6 space-y-2">
                            <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'bg-blue-300 text-blue-900' : 'hover:bg-blue-400' }} font-semibold rounded-xl py-2 px-4 text-left">
                              Dashboard
                            </a>

                            <a href="{{ route('user.apply-loan') }}" class="{{ request()->routeIs('user.apply-loan') ? 'bg-blue-300 text-blue-900' : 'hover:bg-blue-400' }} font-semibold rounded-xl py-2 px-4 text-left">
                              Apply Loan
                            </a>

                            
                            <a href="{{ route('user.loans') }}" class="{{ request()->routeIs('user.loans') ? 'bg-blue-300 text-blue-900' : 'hover:bg-blue-400' }} font-semibold rounded-xl py-2 px-4 text-left">
                              My Loans
                            </a>
                            
                          </nav>
                    </div>
                </div>
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
            {{ $slot }}
        </main>

    </div>
    @fluxScripts

    <script>
      
      let signaturePad;

      function initializeSignaturePad() {
          const canvas = document.getElementById('signaturePad');
          signaturePad = new SignaturePad(canvas, {
              backgroundColor: 'rgb(255, 255, 255)'
          });

          // Adjust canvas size
          function resizeCanvas() {
              const ratio = Math.max(window.devicePixelRatio || 1, 1);
              canvas.width = canvas.offsetWidth * ratio;
              canvas.height = canvas.offsetHeight * ratio;
              canvas.getContext("2d").scale(ratio, ratio);
              signaturePad.clear();
          }

          window.addEventListener("resize", resizeCanvas);
          resizeCanvas();
      }

      function clearSignature() {
          signaturePad.clear();
          
      }
    </script>
    
</body>
</html>
