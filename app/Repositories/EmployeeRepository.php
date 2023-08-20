<?php

namespace App\Repositories;

use App\Interfaces\EmployeeInterface;
use App\Models\Employee;

class EmployeeRepository implements EmployeeInterface
{
    /**
     * Get all employee data
     * @return employee data
     */
    public function getAllEmployees()
    {
        $empData = Employee::all()->toArray();
        return $empData;
    }

    /**
     * Find employee id in system
     * @param $id
     * @return employee id
     */
    public function getEmployeeById($id)
    {
        $findId = Employee::find($id);
        return $findId;
    }
}
