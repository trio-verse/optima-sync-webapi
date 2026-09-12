<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;


/**
 * @group Employee
 */
class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService)
    {
    }

    /**
     * list
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $employees = $this->employeeService->getAllEmployees();

        return ApiResponse::success($employees, 'Employees retrieved successfully', 200);
    }

    /**
     * store
     * @param StoreEmployeeRequest $request
     * @return JsonResponse
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = $this->employeeService->create($request->validated());

        return ApiResponse::success($employee, 'Employee created successfully', 201);
    }

    /**
     * show
     * @param Employee $employee
     * @return JsonResponse
     */
    public function show(Employee $employee): JsonResponse
    {
        $employee = $this->employeeService->show($employee);

        return ApiResponse::success($employee, 'Employee retrieved successfully', 200);
    }

    /**
     * update
     * @param UpdateEmployeeRequest $request
     * @param Employee $employee
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $employee = $this->employeeService->update($employee, $request->validated());

        return ApiResponse::success($employee, 'Employee updated successfully', 200);
    }

    /**
     * destroy
     * @param Employee $employee
     * @return JsonResponse
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $this->employeeService->delete($employee);

        return ApiResponse::success([], 'Employee deleted successfully', 200);
    }
}
