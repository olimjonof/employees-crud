<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeExportController;

 // Route::get('employees', [EmployeeController::class, 'index']);
 // Route::get('getty', [EmployeeController::class, 'getty']);
 // Route::get('employees/export', [EmployeeController::class, 'export']);
 // Route::post('employees', [EmployeeController::class, 'store']);
 // Route::put('employees/{id}', [EmployeeController::class, 'update']);
 // Route::patch('employees/{id}', [EmployeeController::class, 'update']);
 // Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);


//Route::resource('employees', EmployeeController::class);
Route::get('/', function () {
    return view('welcome');
});


