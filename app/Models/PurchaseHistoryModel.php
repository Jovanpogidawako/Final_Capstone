<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseHistoryModel extends Model
{
    protected $table = 'purchase_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['car_model', 'price', 'payment_method', 'purchase_date', 'customer_name', 'customer_address', 'car_image', 'amount_paid', 'total_price', 'payment_status']; // Include new fields
    protected $useTimestamps = true;
    protected $createdField = 'purchase_date';
    protected $updatedField = '';

    public function logPurchase($data)
    {
        return $this->insert($data);
    }

    public function getPurchaseHistory()
    {
        return $this->orderBy('purchase_date', 'DESC')->findAll();
    }
}
