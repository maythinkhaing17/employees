<?php

namespace App\DBTransactions;

use App\Models\Employee;
use App\Classes\DBTransaction;

class UpdateEmployee extends DBTransaction
{
    private $request, $id;

    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }
    public function process()
    {
        $request = $this->request;
        $id = $this->id;

        Employee::where('id', $id)->update([
            'employee_name' => $request['employee_name'],
            'employee_code' => $request['employee_code'],
            'date_of_birth' => $request['date_of_birth'],
            'address' => $request['address']
        ]);
         
        if (!$request) {
            return ['status' => false];
        }
        return ['status' => true];
    }
}
