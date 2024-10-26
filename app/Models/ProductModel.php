<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'model',
        'price',
        'image',
        'mileage',
        'fueltype',
        'transmission',
        'car_model_id',
        'car_price',
        'is_available', // Add this field to allow updates
    ];

    // Retrieve all products
    public function getAllProducts()
    {
        return $this->where('is_available', 1)->findAll(); // Retrieve only available products
    }

    // Retrieve a specific product by ID
    public function getProduct($id)
    {
        return $this->find($id);
    }

    // Update car availability
    public function updateCarAvailability($carModel)
    {
        return $this->set('is_available', 0) // Set availability to false
                    ->where('model', $carModel) // Use the car model to find the correct record
                    ->update();
    }
}
