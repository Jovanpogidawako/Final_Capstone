<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General body styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Container for central layout */
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Main heading */
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-align: center;
        }

        /* Calendar section */
        #calendar {
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            margin: auto;
        }

        /* Close button for modal */
        .close {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 25px;
            color: #888;
            transition: color 0.3s;
        }

        .close:hover {
            color: #e74c3c;
        }

        /* Modal background */
        #updateModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        /* Button styling */
        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
            padding: 10px 15px;
        }

        /* Specific style for the update button */
        button[type="submit"] {
            background-color: green;
        }

        button[type="submit"]:hover {
            background-color: darkgreen;
        }

        /* Input field styling */
        input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="date"]:focus, input[type="time"]:focus {
            border-color: #3498db;
            outline: none;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .modal-content {
                width: 90%;
                padding: 20px;
            }
        }

        /* Calendar event styles */
        .fc-event {
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 5px;
            text-align: center;
        }

        .fc-daygrid-event:hover {
            opacity: 0.8;
        }

        /* Custom styles for the calendar header */
        .fc-toolbar {
            background-color: #ecf0f1;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .fc-toolbar button {
            margin: 0 5px;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #3498db;
            color: #fff;
            border: none;
        }

        .fc-toolbar button:hover {
            background-color: #2980b9;
        }

        /* Calendar view styles */
        .fc-daygrid-day {
            background-color: #f8f9fa;
            border-radius: 5px;
            margin: 2px;
            transition: background-color 0.2s;
        }

        .fc-daygrid-day:hover {
            background-color: #dfe6e9;
        }

        /* Enhanced styles for the rental info modal */
        #rentalInfoModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .rental-info-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 30px;
            border: 1px solid #e0e0e0;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .rental-info-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .rental-info-close:hover,
        .rental-info-close:focus {
            color: #2c3e50;
            text-decoration: none;
            cursor: pointer;
        }

        #rentalInfoTitle {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-item i {
            font-size: 1.2rem;
            margin-right: 10px;
            color: #3498db;
            width: 25px;
            text-align: center;
        }

        .info-item span {
            font-size: 1rem;
            color: #34495e;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .status-completed { background-color: #2ecc71; color: white; }
        .status-ongoing { background-color: #3498db; color: white; }
        .status-upcoming { background-color: #f1c40f; color: #2c3e50; }
        <style>
    /* Style for Accept and Decline buttons */
    .action-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }
    .accept-button {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .accept-button:hover {
        background-color: #218838;
    }
    .decline-button {
        background-color: #dc3545;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .decline-button:hover {
        background-color: #c82333;
    }
</style>
    </style>
</head>
<body>
    <div class="container">
        <h1>Rental Management Calendar</h1>
        <div id="calendar"></div>
    </div>


    <!-- Enhanced Rental Info Modal -->
    <div id="rentalInfoModal">
        <div class="rental-info-content">
            <span class="rental-info-close">&times;</span>
            <h2 id="rentalInfoTitle"></h2>
            <div id="rentalInfoContent"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?= json_encode(array_map(function($rental) {
                    return [
                        'id' => $rental['RentalID'],
                        'title' => $rental['Name'],
                        'start' => "{$rental['StartDate']}T{$rental['StartTime']}",
                        'end' => "{$rental['EndDate']}T{$rental['EndTime']}",
                        'backgroundColor' => $rental['statusColor'],
                        'extendedProps' => [
                            'firstLocation' => $rental['FirstLocation'],
                            'secondLocation' => $rental['SecondLocation'],
                            'phone' => $rental['Phone'],
                            'status' => $rental['Status'],
                            'startTime' => $rental['StartTime'],
                            'price' => $rental['price'],
                            'endTime' => $rental['EndTime']
                        ]
                    ];
                }, $rentals)); ?>,
                eventDidMount: function(info) {
                    var status = info.event.extendedProps.status;
                    var color = info.event.backgroundColor;
                    var el = info.el;
                    var parentEl = el.closest('.fc-daygrid-day-frame');
                    
                    if (parentEl) {
                        var statusEl = document.createElement('div');
                        statusEl.className = 'rental-status';
                        statusEl.style.backgroundColor = color;
                        parentEl.insertBefore(statusEl, parentEl.firstChild);
                    }
                },
                eventClick: function(info) {
                    showRentalInfo(info.event);
                },
                dateClick: function(info) {
                    showDateInfo(info.date);
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                }
            });
            calendar.render();
        });

        function showRentalInfo(event) {
            var modal = document.getElementById('rentalInfoModal');
            var title = document.getElementById('rentalInfoTitle');
            var content = document.getElementById('rentalInfoContent');

            title.textContent = event.title;
            var statusClass = 'status-' + event.extendedProps.status.toLowerCase();
            content.innerHTML = `
                <div class="status-badge ${statusClass}">${event.extendedProps.status}</div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><strong>From:</strong> ${event.extendedProps.firstLocation}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-pin"></i>
                    <span><strong>To:</strong> ${event.extendedProps.secondLocation}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <span>${event.extendedProps.phone}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span><strong>Start:</strong> ${event.start.toLocaleString()}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>End:</strong> ${event.end ? event.end.toLocaleString() : 'N/A'}</span>
                </div>
                <div class="info-item">
    <i class="fas fa-dollar-sign"></i>
    <span><strong>Price:</strong> $${event.extendedProps.price}</span>
</div>

            `;

            modal.style.display = 'block';
        }

        function showDateInfo(date) {
            var modal = document.getElementById('rentalInfoModal');
            var title = document.getElementById('rentalInfoTitle');
            var content = document.getElementById('rentalInfoContent');

            title.textContent = 'Date Information';
            content.innerHTML = `
                <div class="info-item">
                    <i class="fas fa-calendar-day"></i>
                    <span><strong>Selected Date:</strong> ${date.toLocaleDateString()}</span>
                </div>
            `;

            modal.style.display = 'block';
        }

        // Close modal when clicking on <span> (x)
        document.querySelector('.rental-info-close').onclick = function() {
            document.getElementById('rentalInfoModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('rentalInfoModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        function clearForm() {
            
            document.getElementById('updateForm').reset();
        }
    </script>
</body>
<?= $this->endSection() ?>