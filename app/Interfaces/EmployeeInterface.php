<?php

namespace App\Interfaces;

interface EmployeeInterface
{

    public function getAllEmployees();

    public function getEmployeeById($id);
}
