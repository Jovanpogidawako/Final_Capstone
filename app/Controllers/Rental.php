<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RentingModel;
use DateTime;

class Rental extends BaseController
{
    public function index()
    {
        $model = new RentingModel();
        $rentals = $model->findAll(); // Fetch all rentals
    
        $userName = session()->get('user_name', '');
        $userPhone = session()->get('user_phone', '');
    
        // Pass user and rental data to the view
        return view('user/renting', [
            'user_name' => $userName,
            'user_phone' => $userPhone,
            'rentals' => $rentals,
        ]);
    }

    public function submit()
    {
        $model = new RentingModel();

        // Get form data
        $data = [
            'CarID' => $this->request->getVar('car_id'),
            'FirstLocation' => $this->request->getVar('firstlocation'),
            'SecondLocation' => $this->request->getVar('secondlocation'),
            'Name' => $this->request->getVar('name'),
            'Phone' => $this->request->getVar('phone'),
            'StartDate' => $this->request->getVar('start_date'),
            'EndDate' => $this->request->getVar('end_date'),
            'StartTime' => $this->request->getVar('start_time'),
            'EndTime' => $this->request->getVar('end_time'),
            'price' => $this->request->getVar('price'),
            'Status' => 'pending', // Set initial status as 'pending'
        ];

        // Insert data into the database
        $insertResult = $model->insert($data);

        if ($insertResult) {
            $response = [
                'success' => true,
                'message' => 'Rental submitted successfully'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error occurred while submitting the rental'
            ];
        }

        // Return JSON response
        return $this->response->setJSON($response);
    }

    public function adminIndex()
    {
        $model = new RentingModel();
        $rentals = $model->findAll();

        // Update status and color for each rental
        foreach ($rentals as &$rental) {
            $rental['Status'] = $this->calculateRentalStatus($rental);
            $rental['statusColor'] = $this->getStatusColor($rental['Status']);
        }

        return view('admin/rental_management', ['rentals' => $rentals]);
    }

    public function getRentals()
    {
        $model = new RentingModel();
        $rentals = $model->findAll(); // Retrieve all rentals

        $events = [];
        foreach ($rentals as $rental) {
            // Determine rental status based on current date and time
            $currentDateTime = new DateTime();
            $startDateTime = new DateTime($rental['StartDate'] . ' ' . $rental['StartTime']);
            $endDateTime = new DateTime($rental['EndDate'] . ' ' . $rental['EndTime']);
            $status = 'pending';

            if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
                $status = 'ongoing';
            } elseif ($currentDateTime > $endDateTime) {
                $status = 'done';
            }

            $rental['Status'] = $status;

            $events[] = [
                'id' => $rental['RentalID'],
                'title' => $rental['Name'],
                'start' => $rental['StartDate'] . 'T' . $rental['StartTime'],
                'end' => $rental['EndDate'] . 'T' . $rental['EndTime'],
                'color' => $this->getRentalColor($status),
                'extendedProps' => [
                    'firstLocation' => $rental['FirstLocation'],
                    'secondLocation' => $rental['SecondLocation'],
                    'phone' => $rental['Phone'],
                    'price' => $rental['price'],
                    'status' => $status
                ]
            ];
        }

        return $this->response->setJSON($events);
    }

    public function updateRental()
    {
        $model = new RentingModel();

        // Get rental ID and form data
        $rentalId = $this->request->getVar('rental_id');
        $data = [
            'FirstLocation' => $this->request->getVar('firstlocation'),
            'SecondLocation' => $this->request->getVar('secondlocation'),
            'Name' => $this->request->getVar('name'),
            'Phone' => $this->request->getVar('phone'),
            'StartDate' => $this->request->getVar('start_date'),
            'EndDate' => $this->request->getVar('end_date'),
            'StartTime' => $this->request->getVar('start_time'),
            'EndTime' => $this->request->getVar('end_time'),
        ];

        // Update the rental record in the database
        $model->update($rentalId, $data);

        // Redirect back to the rental management page after updating
        return redirect()->to(site_url('rentman'))->with('status', 'Rental updated successfully');
    }

    public function deleteRental($id)
    {
        $model = new RentingModel();
        $model->delete($id); // Delete the rental by its ID

        // Redirect to admin page with success message
        return redirect()->to(site_url('rentman'))->with('status', 'Rental deleted successfully');
    }

    public function history()
    {
        $model = new RentingModel();
        $rentals = $model->findAll(); // Retrieve all rentals

        // Update status and color for each rental
        foreach ($rentals as &$rental) {
            $rental['Status'] = $this->calculateRentalStatus($rental);
            $rental['statusColor'] = $this->getStatusColor($rental['Status']);
        }

        return view('user/renting_history', ['rentals' => $rentals]);
    }

    private function calculateRentalStatus($rental)
    {
        $currentDateTime = new DateTime();
        $startDateTime = new DateTime($rental['StartDate'] . ' ' . $rental['StartTime']);
        $endDateTime = new DateTime($rental['EndDate'] . ' ' . $rental['EndTime']);

        if ($currentDateTime < $startDateTime) {
            return 'Upcoming';
        } elseif ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
            return 'Ongoing';
        } else {
            return 'Completed';
        }
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Completed':
                return '#28a745'; // Green
            case 'Ongoing':
                return '#007bff'; // Blue
            case 'Upcoming':
                return '#ffc107'; // Yellow
            default:
                return '#6c757d'; // Grey
        }
    }
    
    public function show()
    {
        $model = new RentingModel();
        $rentals = $model->findAll(); // Retrieve all rentals
        foreach ($rentals as &$rental) {
            $rental['Status'] = $this->calculateRentalStatus($rental);
            $rental['statusColor'] = $this->getStatusColor($rental['Status']);
        }

        return view('user/renting_history', ['rentals' => $rentals]);
    }
    public function mapping() 
    {
        $model = new RentingModel();
        
        // Fetch all rental records
        $data['rental_data'] = $model->findAll(); 

        // Check if rental data was retrieved
        if (empty($data['rental_data'])) {
            session()->setFlashdata('message', 'No rental information found.');
        }

        return view('admin/rental_map', $data); // Pass data to the view
    }
  }