<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= $this->include('layout/header') ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Shop - Luxury Car Rentals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #333333;
            --accent-color: #666666;
            --background-color: #ffffff;
            --text-color: #000000;
            --success-color: #28a745;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .search-container {
            padding-top: 50px;
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .search-container input {
            width: 300px;
            padding: 12px;
            border: 2px solid var(--primary-color);
            border-radius: 25px 0 0 25px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-container input:focus {
            border-color: var(--accent-color);
        }

        .search-btn {
            padding: 12px 20px;
            border: 2px solid var(--primary-color);
            background-color: var(--primary-color);
            color: var(--background-color);
            cursor: pointer;
            border-radius: 0 25px 25px 0;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background-color: var(--background-color);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            position: relative;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .car-title {
            font-size: 1.5rem;
            margin: 0 0 0.5rem;
            color: var(--primary-color);
        }

        .price {
            font-size: 1.25rem;
            color: var(--accent-color);
            font-weight: 600;
        }

        .car-details {
            margin-top: 1rem;
        }

        .car-details p {
            display: flex;
            align-items: center;
            margin: 0.5rem 0;
            font-size: 0.9rem;
        }

        .car-details i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .checkout-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--background-color);
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-size: 1rem;
            margin-top: 1rem;
            border: 2px solid var(--primary-color);
        }

        .checkout-btn:hover {
            background-color: var(--background-color);
            color: var(--primary-color);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            opacity: 1;
        }

        .modal-content {
            background-color: var(--background-color);
            margin: 5% auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            max-width: 500px;
            width: 90%;
            transform: scale(0.8);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.show .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .close {
            align-self: flex-end;
            color: var(--accent-color);
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: var(--primary-color);
        }

        .car-info {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .car-info img {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .car-info h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .price-modal {
            font-size: 1.5rem;
            color: var(--accent-color);
            font-weight: 600;
        }

        .payment-methods h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .payment-methods form {
            display: flex;
            flex-direction: column;
        }

        .payment-methods input,
        .payment-methods select {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid var(--accent-color);
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .payment-methods input:focus,
        .payment-methods select:focus {
            border-color: var(--primary-color);
        }

        .payment-methods button {
            background-color: var(--primary-color);
            color: var(--background-color);
            padding: 12px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .payment-methods button:hover {
            background-color: var(--accent-color);
        }

        .success-message {
            text-align: center;
            padding: 2rem;
        }

        .success-message i {
            color: var(--success-color);
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .success-message h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .success-message p {
            color: var(--accent-color);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .success-message .checkout-btn {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .success-message .checkout-btn:hover {
            background-color: var(--background-color);
            color: var(--success-color);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for cars..." onkeyup="searchCars()">
        <button class="search-btn"><i class="fas fa-search"></i></button>
    </div>

    <div class="container">
        <?php if (!empty($cars) && is_array($cars)): ?>
            <?php foreach ($cars as $car): ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?= base_url('uploaded_img/' . $car['image']) ?>" alt="<?= esc($car['model']) ?>" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <h3 class="car-title"><?= esc($car['model']) ?></h3>
                        <p class="price">₱<?= number_format($car['price'], 2) ?> </p>
                        
                        <div class="car-details">
                            <p><i class="fas fa-gas-pump"></i> <?= esc($car['fueltype']) ?></p>
                            <p><i class="fas fa-cogs"></i> <?= esc($car['transmission']) ?></p>
                            <p><i class="fas fa-tachometer-alt"></i> <?= number_format($car['mileage']) ?> km</p>
                        </div>

                        <button class="checkout-btn" onclick="openModal('<?= esc($car['model']) ?>', <?= esc($car['price']) ?>, '<?= base_url('uploaded_img/' . $car['image']) ?>')">
                            <i class="fas fa-car"></i> Buy this Car
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No cars available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <!-- Payment Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="car-info">
                <img id="modalCarImage" src="" alt="Car Image">
                <h2 id="modalCarModel"></h2>
                <div class="price-modal" id="modalCarPrice"></div>
            </div>
            <div class="payment-methods">
                <h2>Payment Details</h2>
                <form method="POST" action="<?= base_url('/submitPayment'); ?>">
                    <!-- Hidden inputs for car details -->
                    <input type="hidden" name="car_model" id="modalCarModelInput" value="">
                    <input type="hidden" name="car_price" id="modalCarPriceInput" value="">
                    <input type="hidden" name="car_image" id="modalCarImageInput" value="">

                    <input type="text" id="card-number" name="card-number" placeholder="Card Number" required>
                    <input type="text" id="card-name" name="card-name" placeholder="Full Name" required>
                    <input type="text" id="card-address" name="card-address" placeholder="Address" required>
                    <select id="payment-method" name="payment-method" required>
                        <option value="">Select Payment Method</option>
                        <option value="creditCard">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="gcash">GCash</option>
                    </select>
                    <button type="submit"><i class="fas fa-credit-card"></i> Complete Payment</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSuccessModal()">&times;</span>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <h2>Purchase Successful!</h2>
                <p>Thank you for your purchase. Your car will be ready for pickup soon.</p>
                <button onclick="closeSuccessModal()" class="checkout-btn">
                    <i class="fas fa-check"></i> Done
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(carModel, carPrice, carImage) {
            document.getElementById("modalCarModel").innerText = carModel;
            document.getElementById("modalCarPrice").innerText = "₱" + carPrice.toLocaleString() + " / day";
            document.getElementById("modalCarImage").src = carImage;

            // Set hidden fields for form submission
            document.getElementById("modalCarModelInput").value = carModel;
            document.getElementById("modalCarPriceInput").value = carPrice;
            document.getElementById("modalCarImageInput").value = carImage;

            const modal = document.getElementById("myModal");
            modal.style.display = "block";
            setTimeout(() => {
                modal.classList.add("show");
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById("myModal");
            modal.classList.remove("show");
            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        }

        function closeSuccessModal() {
            const successModal = document.getElementById("successModal");
            successModal.classList.remove("show");
            setTimeout(() => {
                successModal.style.display = "none";
            }, 300);
        }

        function showSuccessMessage() {
            // First close the payment modal
            closeModal();
            
            // Then show the success modal
            const successModal = document.getElementById("successModal");
            successModal.style.display = "block";
            setTimeout(() => {
                successModal.classList.add("show");
            }, 10);
        }

        function searchCars() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const cards = document.getElementsByClassName('card');

            for (