<?php

namespace App\Admin\Service;

use App\User;

class PortalService {
    public function getListCustomer() {
        $customers = User::whereIsCustomer(User::CUSTOMER)->with('profile')->get();

        $res = [];
        foreach ($customers as $customer) {
            $res[$customer->id] = $customer->profile->company_name;
        }

        return $res;
    }
}
