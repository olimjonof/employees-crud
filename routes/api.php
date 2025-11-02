<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);       // GET /api/employees
    Route::post('/', [EmployeeController::class, 'store']);      // POST /api/employees
    Route::get('{id}', [EmployeeController::class, 'show']);     // GET /api/employees/{id}
    Route::put('{id}', [EmployeeController::class, 'update']);  // PUT /api/employees/{id}
    Route::delete('{id}', [EmployeeController::class, 'destroy']); // DELETE /api/employees/{id}
    Route::get('/export', [EmployeeController::class, 'export']);
});

//Route::post('employees', [EmployeeController::class, 'store']);
//Route::apiResource('employees', EmployeeController::class);
// Route::middleware('api')->group(function () {
//     Route::post('/employees', [EmployeeController::class, 'store']);
// });
