<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>

    <!-- Dashboard Section -->
    <div id="dashboardSection">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Your Dashboard</h1>
        <div class="bg-white p-10 rounded-xl shadow text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Hello, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600">Use the sidebar to apply for a loan or view your loan status.</p>
        </div>
    </div>

    <!-- Promo Alert Section -->
    <div id="promoAlertSection" class="bg-yellow-500 p-0 rounded-xl shadow text-center mb-6">
        <h1 class="text-3xl font-bold text-white mb-2">🎉 Promo Alert! 🎉</h1>
        <p class="text-lg font-semibold text-white mb-2">Grabe! Ito na ang pagkakataon mo na manalo ng amazing prizes!</p>
        <p class="text-md text-white">Join now and grab a chance to win the raffle item below!</p>
    </div>

    <!-- Promo / Raffle Flyers Section -->
    <div id="promotionsSection" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

        <!-- Promo Item 1 -->
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg hover:scale-105 transform transition duration-300">
            <h3 class="text-xl font-bold mb-2">Win a Washing Machine!</h3>
            <p class="text-sm mb-4">Join our raffle for a chance to win a brand new washing machine!</p>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-300" onclick="openRaffleModal('Washing Machine', 200)">Buy Now</button>
        </div>

        <!-- Promo Item 2 (Fixed TV Button) -->
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:scale-105 transform transition duration-300">
            <h3 class="text-xl font-bold mb-2">42 inch TV!</h3>
            <p class="text-sm mb-4">Join our raffle for a chance to win 2nd hand 42" TV!</p>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-300" onclick="openRaffleModal('42 inch TV', 200)">Apply Now</button>
        </div>

        <!-- Promo Item 3 -->
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg hover:scale-105 transform transition duration-300">
            <h3 class="text-xl font-bold mb-2">Laptop Raffle</h3>
            <p class="text-sm mb-4">Join our Raffle to win a brand new laptop. Don't miss out!</p>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-300" onclick="openRaffleModal('Laptop', 250)">Enter Now</button>
        </div>

        <!-- Promo Item 4 -->
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg hover:scale-105 transform transition duration-300">
            <h3 class="text-xl font-bold mb-2">Win a Oven Toaster!</h3>
            <p class="text-sm mb-4">Join our raffle for a chance to win 2nd hand Oven Toaster!</p>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-300" onclick="openRaffleModal('Discount Voucher', 150)">Join Now</button>
        </div>

        <!-- Promo Item 5 -->
        <div class="bg-orange-500 text-white p-6 rounded-lg shadow-lg hover:scale-105 transform transition duration-300">
            <h3 class="text-xl font-bold mb-2">Win a 2nd hand Refrigerator!</h3>
            <p class="text-sm mb-4">Enter our raffle and win 2nd hand samsung Refrigerator!</p>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-300" onclick="openRaffleModal('Boracay Trip', 500)">Enter the Raffle</button>
        </div>

        <!-- Promo Item 6 -->
        <div class="bg-teal-500 text-white p-6 rounded-lg shadow-lg hover:scale-105 transform transition duration-300">
            <h3 class="text-xl font-bold mb-2">Win a chance at Smartphones!</h3>
            <p class="text-sm mb-4">Buy Now Our ticket raffle entry for a chance to win the latest smartphone model!</p>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-300" onclick="openRaffleModal('Smartphone', 300)">Enter The Raffle Entry Now!</button>
        </div>

    </div>

    <!-- Raffle Ticket Modal -->
    <div id="raffleModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4">Your Raffle Ticket</h3>
            <p id="raffleTicketDescription" class="text-lg mb-4">Do you want to buy a raffle ticket for: <span class="font-bold" id="raffleItem"></span>?</p>
            <p class="text-gray-600 mb-4">Ticket Price: ₱<span id="ticketPrice" class="font-semibold">0</span></p>

            <div class="flex justify-between mt-6">
                <button onclick="buyTicket()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-300">Buy Ticket</button>
                <button onclick="closeRaffleModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-300">Cancel</button>
            </div>
        </div>
    </div>

</div>

<script>
    // Function to open the raffle modal and set the raffle item and price
    function openRaffleModal(item, price) {
        document.getElementById('raffleItem').innerText = item;
        document.getElementById('ticketPrice').innerText = price;
        document.getElementById('raffleModal').classList.remove('hidden');
    }

    // Function to close the raffle modal
    function closeRaffleModal() {
        document.getElementById('raffleModal').classList.add('hidden');
    }

    // Function to handle ticket purchase
    function buyTicket() {
        alert('You have successfully bought a ticket!');
        closeRaffleModal();
    }
</script>
