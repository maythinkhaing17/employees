<?php

namespace App\DBTransactions;

use App\Classes\DBTransaction;
use App\Models\Employee;

class DeleteEmployee extends DBTransaction
{
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function process()
    {
        $id = $this->id;

        $affected = Employee::where('id', $id)->delete();

        if (!$affected) {
            return ['status' => false];
        }
        return ['status' => true];
    }
}
