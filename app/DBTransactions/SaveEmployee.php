<?php

namespace App\DBTransactions;

use App\Models\Employee;
use App\Classes\DBTransaction;

class SaveEmployee extends DBTransaction
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function process()
    {
        $request = $this->request;
        $employee = new Employee();
        $employee->employee_code =  $request->employee_code;
        $employee->employee_name =  $request->employee_name;
        $employee->nrc_number =  $request->nrc_number;
        $employee->password =  bcrypt($request->password);
        $employee->email =  $request->email;
        $employee->gender =  $request->gender;
        $employee->date_of_birth =  $request->date_of_birth;
        $employee->address =  $request->address;
        $employee->save();

        if (!$employee) {
            return ['status' => false];
        }
        return ['status' => true];
    }
}
