<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
<<<<<<< HEAD
=======
            background-color: #f4f6f7;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        .container {
            display: flex;
            width: 100%;
        }

        .sidebar {
<<<<<<< HEAD
            background-color: #2c3e50;
=======
            background-color: #34495e;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
            color: white;
            width: 250px;
            padding: 20px;
            box-sizing: border-box;
<<<<<<< HEAD
=======
            display: flex;
            flex-direction: column;
            justify-content: space-between;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
<<<<<<< HEAD
=======
            font-size: 24px;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
<<<<<<< HEAD
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
=======
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #2c3e50;
        }

        .logout-btn {
            margin-top: 20px;
            padding: 10px;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        .main-content {
            padding: 20px;
            flex-grow: 1;
        }

        h3 {
<<<<<<< HEAD
            color: #2c3e50;
=======
            color: #34495e;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        .dashboard {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
<<<<<<< HEAD
=======
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }

        form input {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
<<<<<<< HEAD
=======
            border-radius: 5px;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        form button {
            padding: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
<<<<<<< HEAD
=======
            border-radius: 5px;
            transition: background-color 0.3s;
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        }

        form button:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
<<<<<<< HEAD
            <h2>Client Dashboard</h2>
            <ul>
                <li><a href="#dashboard">Dashboard</a></li>
                <li><a href="#application-form">Application Form</a></li>
                <li><a href="#loan">Loan</a></li>
            </ul>
=======
            <div>
                <h2>Client Dashboard</h2>
                <ul>
                    <li><a href="#dashboard">Dashboard</a></li>
                    <li><a href="#application-form">Application Form</a></li>
                    <li><a href="#loan">My Loan</a></li>
                </ul>
            </div>
            <button class="logout-btn">Log Out</button>
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
        </div>
        <div class="main-content">
            <div id="dashboard" class="dashboard">
                <h3>Welcome to Your Dashboard</h3>
                <p>This is the main area where you can see an overview of your account and recent activity.</p>
            </div>

            <div id="application-form" style="display:none;">
                <h3>Application Form</h3>
                <form>
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phone" name="phone" required>

                    <button type="submit">Submit</button>
                </form>
            </div>

            <div id="loan" style="display:none;">
                <h3>Loan Information</h3>
                <form>
                    <label for="loan-amount">Loan Amount:</label>
                    <input type="number" id="loan-amount" name="loan-amount" placeholder="₱" required>

                    <label for="due-date">Due Date:</label>
                    <input type="date" id="due-date" name="due-date" required>

                    <button type="submit">Save Loan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dashboard = document.getElementById('dashboard');
            const applicationForm = document.getElementById('application-form');
            const loan = document.getElementById('loan');

            const dashboardLink = document.querySelector('a[href="#dashboard"]');
            const applicationLink = document.querySelector('a[href="#application-form"]');
            const loanLink = document.querySelector('a[href="#loan"]');

            dashboardLink.addEventListener('click', function() {
                dashboard.style.display = 'block';
                applicationForm.style.display = 'none';
                loan.style.display = 'none';
            });

            applicationLink.addEventListener('click', function() {
                applicationForm.style.display = 'block';
                dashboard.style.display = 'none';
                loan.style.display = 'none';
            });

            loanLink.addEventListener('click', function() {
                loan.style.display = 'block';
                dashboard.style.display = 'none';
                applicationForm.style.display = 'none';
            });

            // Default view
            dashboard.style.display = 'block';
            applicationForm.style.display = 'none';
            loan.style.display = 'none';
        });
    </script>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 7a4cd16f6780aaeeb13f26c74ddde990a00e72b8
