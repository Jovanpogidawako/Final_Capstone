<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= $this->extend('layouts/main') ?>
    <?= $this->section('content') ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History - Luxury Car Rentals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .car-image {
            width: 100px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }
        .alert {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .toggle-container {
            display: flex;
            align-items: center;
        }
        .toggle-button {
            width: 60px;
            height: 30px;
            background-color: #ccc;
            border-radius: 15px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .toggle-button::after {
            content: '';
            position: absolute;
            width: 26px;
            height: 26px;
            background-color: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: transform 0.3s;
        }
        .toggle-on {
            background-color: #4CAF50; /* Green for Paid */
        }
        .toggle-on::after {
            transform: translateX(30px); /* Move button to the right */
        }
        .status-label {
            margin-left: 10px;
            font-weight: bold;
        }
    </style>
    <script>
        function togglePaymentStatus(button) {
            button.classList.toggle('toggle-on');
            const statusLabel = button.nextElementSibling;
            const status = button.classList.contains('toggle-on') ? 'Paid' : 'Not Paid';
            button.setAttribute('data-status', status);
            statusLabel.textContent = status; // Update the label text
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>SOLD CARS</h1>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Car Image</th>
                    <th>Purchase Date</th>
                    <th>Car Model</th>
                    <th>Price</th>
                    <th>Customer Name</th>
                    <th>Customer Address</th>
                    <th>Payment Method</th>
                    <th>Status</th> <!-- New Status Column -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $purchase): ?>
                <tr>
                    <td><img src="<?= esc($purchase['car_image']) ?>" alt="<?= esc($purchase['car_model']) ?>" class="car-image"></td>
                    <td><?= date('F j, Y, g:i a', strtotime($purchase['purchase_date'])) ?></td>
                    <td><?= esc($purchase['car_model']) ?></td>
                    <td>₱<?= number_format($purchase['price'], 2) ?></td>
                    <td><?= esc($purchase['customer_name']) ?></td>
                    <td><?= esc($purchase['customer_address']) ?></td>
                    <td><?= esc($purchase['payment_method']) ?></td>
                    <td class="toggle-container">
                        <div class="toggle-button" onclick="togglePaymentStatus(this)" data-status="Not Paid"></div>
                        <span class="status-label">Not Paid</span> <!-- Status label -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?= $this->endsection() ?>
