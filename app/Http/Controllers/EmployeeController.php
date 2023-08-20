<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Interfaces\EmployeeInterface;
use App\DBTransactions\DeleteEmployee;
use App\DBTransactions\UpdateEmployee;
use App\Http\Requests\EmployeeUpdateValidation;

/**
 * Manage employee data(CRUD)
 *
 * @author  MayThinKhaing
 * @create  2023/08/19
 */
class EmployeeController extends Controller
{
    protected $employeeInterface;

    public function __construct(EmployeeInterface $employeeInterface) 
    {
        $this->employeeInterface = $employeeInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @author  MayThinKhaing
     * @create  2023/08/19
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $employeeData = $this->employeeInterface->getAllEmployees();

            if (empty($employeeData)) {
                return response()->json(['status' => 'NG', 'message' => 'No Employee Data'], 200);
            } else {
                return response()->json(['status' => 'OK', 'employees' => $employeeData], 200);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage(). 'in file '.__FILE__.' on line '.__LINE__);
            return response()->json(['status' => 'NG', 'message' => 'Internal server error! Please contact with developer.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @author  MayThinKhaing
     * @create  2023/08/19
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->employeeInterface->getEmployeeById($id);
        // check employee is exists or not in system
        if (empty($employee)) {
            return response()->json(['status' => 'NG', 'message' => 'Employee is no longer exist'], 200);
        } else {
            return response()->json(['status' => 'OK', 'employee' => $employee], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @author  MayThinKhaing
     * @create  2023/08/19
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateValidation $request, $id)
    {
        $employee = $this->employeeInterface->getEmployeeById($id);
        // check employee is exists or not in system
        if (empty($employee)) {
            return response()->json(['status' => 'NG', 'message' => 'Employee is no longer exist'], 200);
        } else {
            $updateEmployee = new UpdateEmployee($request, $id);
            $updateResult = $updateEmployee->executeProcess();

            if ($updateResult) {
                return response()->json(['status' => 'OK', 'message' => 'Employee updated successfully'], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => 'Failed to update employee'], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author  MayThinKhaing
     * @create  2023/08/19
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $employee = $this->employeeInterface->getEmployeeById($id);
            // check employee is exists or not in system
            if (empty($employee)) {
                return response()->json(['status' => 'NG', 'message' => 'Employee is no longer exist'], 200);
            } else {
                $delete = new DeleteEmployee($id);
                $delete = $delete->executeProcess();

                if ($delete) {
                    return response()->json(['status' => 'OK', 'message' => 'Employee deleted Successfully'], 200);
                } else {
                    return response()->json(['status' => 'NG', 'message' => 'Failed to delete employee'], 200);
                }
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . 'in file ' . __FILE__ . ' on line ' . __LINE__);
            return response()->json(['status' => 'NG', 'message' => 'Internal server error! Please contact with developer.'], 500);
        }
    }
}
