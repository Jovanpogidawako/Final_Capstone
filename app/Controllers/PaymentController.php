<?php 
namespace App\Controllers;  

use App\Models\ProductModel;
use App\Models\PaymentModel;
use App\Models\PurchaseHistoryModel;
use CodeIgniter\Controller;
class PaymentController extends BaseController  
{  
    protected $paymentModel;  

    public function __construct()  
    {  
        $this->paymentModel = new PaymentModel();  
    }  

    public function submit()  
    {  
        $data = [  
            'card_number' => $this->request->getPost('card-number'),  
            'card_name'   => $this->request->getPost('card-name'),  
            'card_address'=> $this->request->getPost('card-address'),  
            'payment_method' => $this->request->getPost('payment-method'),  
            'car_model_id' => $this->request->getPost('car_model_id')  // ensure this exists in your form  
        ];  

        // Validate the input data here if necessary  
        if ($this->paymentModel->insert($data)) {  
            return redirect()->to('/payments')->with('success', 'Payment submitted successfully.');  
        } else {  
            // Handle validation errors  
            return redirect()->back()->withInput()->with('errors', $this->paymentModel->errors());  
        }  
    }  

    public function update($id)  
    {  
        $payment = $this->paymentModel->find($id);  

        if (!$payment) {  
            return redirect()->to('/payments')->with('error', 'Payment record not found.');  
        }  

        $data = [  
            'card_number' => $this->request->getPost('card-number'),  
            'card_name'   => $this->request->getPost('card-name'),  
            'card_address'=> $this->request->getPost('card-address'),  
            'payment_method' => $this->request->getPost('payment-method'),  
            'car_model_id' => $this->request->getPost('car_model_id'),  // ensure this exists in your form  
        ];  

        // Update the record in the database  
        if ($this->paymentModel->update($id, $data)) {  
            return redirect()->to('/payments')->with('success', 'Payment updated successfully.');  
        } else {  
            // Handle validation errors  
            return redirect()->back()->withInput()->with('errors', $this->paymentModel->errors());  
        }  
    }  
    public function index()  
    {
        $purchaseHistoryModel = new PurchaseHistoryModel();
        $data['purchases'] = $purchaseHistoryModel->getPurchaseHistory();
        return view('admin/payment_management', $data);
    }

    public function delete($id)  
    {  
        $payment = $this->paymentModel->find($id);  

        if ($payment) {  
            $this->paymentModel->delete($id);  
            return redirect()->to('/payments')->with('success', 'Payment record deleted successfully.');  
        } else {  
            return redirect()->to('/payments')->with('error', 'Payment record not found.');  
        }  
    }  
}