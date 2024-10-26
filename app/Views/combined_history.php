<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= $this->include('layout/header') ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - Luxury Car Rentals</title>
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
        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        /* Purchase History Styles */
        .purchase-log {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .purchase-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .purchase-card:hover {
            transform: translateY(-5px);
        }
        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .purchase-details {
            padding: 20px;
        }
        .purchase-date, .real-time-date {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }
        .car-model {
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .price {
            font-size: 1.1em;
            font-weight: 600;
            color: #4CAF50;
            margin-bottom: 10px;
        }
        .customer-info, .payment-info {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
        }

        /* Rental History Styles */
        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .rental-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .status {
            font-weight: bold;
        }
        .status.success {
            color: green;
        }
        .status.primary {
            color: blue;
        }
        .status.info {
            color: orange;
        }
        .status.secondary {
            color: grey;
        }
        .price {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Combined History</h1>

        <!-- Purchase History Section -->
        <h2>Purchase History</h2>
        <?php if (!empty($purchases)): ?>
            <div class="purchase-log">
                <?php foreach ($purchases as $purchase): ?>
                    <div class="purchase-card">
                        <img src="<?= esc($purchase['car_image']) ?>" alt="<?= esc($purchase['car_model']) ?>" class="car-image">
                        <div class="purchase-details">
                            <div class="purchase-date">
                                <i class="fas fa-calendar-alt"></i> Purchased on: <?= date('F j, Y, g:i a', strtotime($purchase['purchase_date'])) ?>
                            </div>
                            <div class="car-model"><?= esc($purchase['car_model']) ?></div>
                            <div class="price">₱<?= number_format($purchase['price'], 2) ?></div>
                            <div class="customer-info">
                                <i class="fas fa-user"></i> <?= esc($purchase['customer_name']) ?>
                            </div>
                            <div class="customer-info">
                                <i class="fas fa-map-marker-alt"></i> <?= esc($purchase['customer_address']) ?>
                            </div>
                            <div class="payment-info">
                                <i class="fas fa-credit-card"></i> <?= esc($purchase['payment_method']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No purchase history available.</p>
        <?php endif; ?>

        <!-- Rental History Section -->
        <h2>Rental History</h2>
        <?php if (!empty($rentals)): ?>
            <?php foreach ($rentals as $rental): ?>
                <div class="card rental-item">
                    <div>
                        <strong>Name:</strong> <?= esc($rental['Name']) ?><br>
                        <strong>First Location:</strong> <?= esc($rental['FirstLocation']) ?><br>
                        <strong>Second Location:</strong> <?= esc($rental['SecondLocation']) ?><br>
                        <strong>Start Date:</strong> <?= esc($rental['StartDate']) ?> <?= esc($rental['StartTime']) ?><br>
                        <strong>End Date:</strong> <?= esc($rental['EndDate']) ?> <?= esc($rental['EndTime']) ?><br>
                        <strong class="price">Price: PHP <?= esc(number_format((float)$rental['price'], 2)) ?></strong><br>
                        <strong class="status <?= strtolower($rental['statusColor']) ?>">Status: <?= esc($rental['Status']) ?></strong>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No rental history available.</p>
        <?php endif; ?>
    </div>

    <?= $this->include('layout/footer') ?>
</body>
</html>
