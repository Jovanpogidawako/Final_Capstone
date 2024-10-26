<?php

namespace App\Controllers;

use App\Models\PurchaseHistoryModel;
use App\Models\RentingModel;

class HistoryController extends BaseController
{
    public function combinedHistory()
    {
        // Get the logged-in user's ID
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/signin')->with('error', 'Please log in to view your history.');
        }

        $purchaseHistoryModel = new PurchaseHistoryModel();
        $purchases = $purchaseHistoryModel->where('user_id', $userId)->findAll();

        $rentingModel = new RentingModel();
        $rentals = $rentingModel->where('user_id', $userId)->findAll();
        foreach ($rentals as &$rental) {
            $rental['Status'] = $this->calculateRentalStatus($rental);
            $rental['statusColor'] = $this->getStatusColor($rental['Status']);
        }

        // Combine both histories into one array
        $data = [
            'purchases' => $purchases,
            'rentals' => $rentals
        ];

        return view('combined_history', $data);
    }

    // Define the calculateRentalStatus method
    private function calculateRentalStatus($rental)
    {
        $currentDate = date('Y-m-d');
        if ($rental['EndDate'] < $currentDate) {
            return 'Completed';
        } elseif ($rental['StartDate'] > $currentDate) {
            return 'Upcoming';
        } else {
            return 'Ongoing';
        }
    }

    // Define the getStatusColor method
    private function getStatusColor($status)
    {
        switch (strtolower($status)) {
            case 'completed':
                return 'success';
            case 'upcoming':
                return 'primary';
            case 'ongoing':
                return 'info';
            default:
                return 'secondary';
        }
    }
}