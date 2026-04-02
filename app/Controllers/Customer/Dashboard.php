<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\Products;

class Dashboard extends BaseController
{
    // ================= DASHBOARD =================
    public function index()
    {
        try {
            $userId = session('id');

            if (!$userId) {
                return redirect()->to('/customer/login')
                    ->with('error', 'Session expired. Please login again.');
            }

            $userModel = new Users();
            $user = $userModel->find($userId);

            if (!$user) {
                log_message('warning', 'User not found in dashboard: ID ' . $userId);

                session()->destroy();

                return redirect()->to('/customer/login')
                    ->with('error', 'User not found. Please login again.');
            }

            return view('customer/dashboard', ['user' => $user]);

        } catch (\Exception $e) {
            log_message('error', 'Dashboard Error: ' . $e->getMessage());

            return redirect()->to('/customer/login')
                ->with('error', 'Something went wrong.');
        }
    }

    // ================= SAVE LOCATION =================
    public function updateLocation()
    {
        try {
            $userId = session('id');

            if (!$userId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                    'csrfToken' => csrf_hash()
                ]);
            }

            $lat = $this->request->getPost('lat');
            $lng = $this->request->getPost('lng');
            $address = $this->request->getPost('address');

            if (!$lat || !$lng) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid coordinates',
                    'csrfToken' => csrf_hash()
                ]);
            }

            $userModel = new Users();

            $userModel->update($userId, [
                'lat' => $lat,
                'lng' => $lng,
                'address' => $address ?? 'Selected Location',
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'lat' => $lat,
                'lng' => $lng,
                'csrfToken' => csrf_hash() // 🔥 IMPORTANT
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Update Location Error: ' . $e->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Server error',
                'csrfToken' => csrf_hash()
            ]);
        }
    }

    // ================= GET NEARBY PRODUCTS =================
    public function getNearbyProducts()
    {
        try {
            $userId = session('id');

            if (!$userId) {
                return $this->response->setJSON([]);
            }

            $lat = (float) $this->request->getGet('lat');
            $lng = (float) $this->request->getGet('lng');

            if (!$lat || !$lng) {
                return $this->response->setJSON([]);
            }

            $productModel = new Products();

            $products = $productModel->getNearby($lat, $lng);

            return $this->response->setJSON($products ?? []);

        } catch (\Exception $e) {
            log_message('error', 'Nearby Products Error: ' . $e->getMessage());

            return $this->response->setJSON([]);
        }
    }
}