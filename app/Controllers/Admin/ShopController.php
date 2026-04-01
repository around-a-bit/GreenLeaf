<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ShopOwners;
use App\Models\Shops;
use Exception;

class ShopController extends BaseController
{
    public function index()
    {
        try {
            $model = new ShopOwners();
            $data['owners'] = $model->findAll();

            log_message('info', 'Admin accessed shop list');

            return view('admin/shops/index', $data);

        } catch (Exception $e) {
            log_message('error', 'Shop list error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Unable to load shops');
        }
    }

    // public function updateStatus()
    // {
    //     try {
    //         $model = new Shops();

    //         $id     = $this->request->getPost('id');
    //         $status = $this->request->getPost('status');
    //         $reason = $this->request->getPost('reason');

    //         if (empty($id) || empty($status)) {
    //             log_message('warning', 'Shop status update failed: missing data');
    //             return redirect()->back()->with('error', 'Invalid request');
    //         }

    //         $updateData = [
    //             'status' => $status
    //         ];

    //         if ($status === 'rejected') {
    //             $updateData['rejection_reason'] = $reason ?? 'No reason provided';
    //         } else {
    //             $updateData['rejection_reason'] = null;
    //         }

    //         $model->update($id, $updateData);

    //         log_message('info', 'Shop ID ' . $id . ' updated to ' . $status);

    //         return redirect()->back()->with('success', 'Shop status updated');

    //     } catch (Exception $e) {
    //         log_message('error', 'Shop update error: ' . $e->getMessage());

    //         return redirect()->back()->with('error', 'Something went wrong');
    //     }
    // }


    public function updateStatus()
    {
        try {
            $model = new ShopOwners();

            $id     = $this->request->getPost('id');
            $status = $this->request->getPost('status');
            $reason = $this->request->getPost('reason');

            if (empty($id) || $status === null) {
                log_message('warning', 'Owner status update failed: missing data');
                return redirect()->back()->with('error', 'Invalid request');
            }

            $updateData = [
                'status' => $status
            ];

            // ⚠️ Only if you add rejection_reason column later
            if ($status == 2) {
                $updateData['rejection_reason'] = $reason ?? 'No reason provided';
            }

            $model->update($id, $updateData);

            log_message('info', 'Owner ID ' . $id . ' updated to status ' . $status);

            return redirect()->back()->with('success', 'Owner status updated');

        } catch (Exception $e) {
            log_message('error', 'Owner update error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
