<?php

use App\Http\Controllers\Api\V1\ProjectManagment\ProjectController;
use App\Http\Controllers\Api\V1\ProjectManagment\ProjectCostController;
use App\Http\Controllers\Api\V1\ProjectManagment\ProjectEmployeesController;
use App\Http\Controllers\Api\V1\ProjectManagment\ProjectFeatureController;
use App\Http\Controllers\Api\V1\ProjectManagment\ProjectMeetingController;
use App\Http\Controllers\Api\V1\ProjectManagment\ProjectQueryController;
use App\Http\Controllers\Api\V1\ProjectManagment\ProjectVersionController;
use App\Http\Controllers\Api\V1\ProjectManagment\QuotationController;
use Illuminate\Support\Facades\Route;

/**
 * =====================================
 *      Project Management Module
 * =====================================
 */

// Query Builder & Analytics
Route::get('projects/query-builder', [ProjectQueryController::class, 'getQueryStructure'])->name('projects.query-builder');
Route::post('projects/query', [ProjectQueryController::class, 'executeQuery'])->name('projects.query');
Route::post('projects/analytics', [ProjectQueryController::class, 'analytics'])->name('projects.analytics');

// Projects
Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::patch('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
Route::patch('projects/{project}/status', [ProjectController::class, 'changeStatus'])->name('projects.status');

// Project Employees — read routes (no version gating)
Route::get('projects/{project}/employees', [ProjectEmployeesController::class, 'index'])->name('projects.employees.index');
Route::get('projects/{project}/employees/points-summary', [ProjectEmployeesController::class, 'pointsSummary'])->name('projects.employees.points-summary');
Route::get('projects/{project}/employees/{employee}', [ProjectEmployeesController::class, 'show'])->name('projects.employees.show');

// Project Employees — mutating routes (auto-branch if version is frozen)
Route::middleware('active_version')->group(function () {
    Route::post('projects/{project}/employees', [ProjectEmployeesController::class, 'store'])->name('projects.employees.store');
    Route::patch('projects/{project}/employees/{employee}', [ProjectEmployeesController::class, 'update'])->name('projects.employees.update');
    Route::delete('projects/{project}/employees/{employee}', [ProjectEmployeesController::class, 'destroy'])->name('projects.employees.destroy');
});

// Project Versions (version management itself is never gated by active_version)
Route::get('projects/{project}/versions', [ProjectVersionController::class, 'index'])->name('project.versions.index');
Route::get('projects/{project}/versions/{version}', [ProjectVersionController::class, 'show'])->name('project.versions.show');
Route::patch('projects/{project}/versions/{version}', [ProjectVersionController::class, 'update'])->name('project.versions.update');
Route::delete('projects/{project}/versions/{version}', [ProjectVersionController::class, 'destroy'])->name('project.versions.destroy');

// Project Features — read routes
Route::get('projects/{project}/features', [ProjectFeatureController::class, 'index'])->name('project.features.index');
Route::get('projects/{project}/features/{feature}', [ProjectFeatureController::class, 'show'])->name('project.features.show');

// Project Features — mutating routes (auto-branch if version is frozen)
Route::middleware('active_version')->group(function () {
    Route::post('projects/{project}/features', [ProjectFeatureController::class, 'store'])->name('project.features.store');
    Route::patch('projects/{project}/features/{feature}', [ProjectFeatureController::class, 'update'])->name('project.features.update');
    Route::delete('projects/{project}/features/{feature}', [ProjectFeatureController::class, 'destroy'])->name('project.features.destroy');
    Route::patch('projects/{project}/features/{feature}/status', [ProjectFeatureController::class, 'changeStatus'])->name('project.features.status');
});

// Project Costs — read routes
Route::get('projects/{project}/costs', [ProjectCostController::class, 'index'])->name('project.costs.index');
Route::get('projects/{project}/costs/total-budget', [ProjectCostController::class, 'totalBudget'])->name('project.costs.total-budget');
Route::get('projects/{project}/costs/{cost}', [ProjectCostController::class, 'show'])->name('project.costs.show');

// Project Costs — mutating routes (auto-branch if version is frozen)
Route::middleware('active_version')->group(function () {
    Route::post('projects/{project}/costs', [ProjectCostController::class, 'store'])->name('project.costs.store');
    Route::patch('projects/{project}/costs/{cost}', [ProjectCostController::class, 'update'])->name('project.costs.update');
    Route::delete('projects/{project}/costs/{cost}', [ProjectCostController::class, 'destroy'])->name('project.costs.destroy');
});

// Project Meetings — not versioned, no active_version gate needed
Route::get('projects/{project}/meetings', [ProjectMeetingController::class, 'index'])->name('project.meetings.index');
Route::post('projects/{project}/meetings', [ProjectMeetingController::class, 'store'])->name('project.meetings.store');
Route::get('projects/{project}/meetings/{meeting}', [ProjectMeetingController::class, 'show'])->name('project.meetings.show');
Route::patch('projects/{project}/meetings/{meeting}', [ProjectMeetingController::class, 'update'])->name('project.meetings.update');
Route::delete('projects/{project}/meetings/{meeting}', [ProjectMeetingController::class, 'destroy'])->name('project.meetings.destroy');

// Quotations
Route::get('/projects/{project}/versions/{version}/quotations/preview', [QuotationController::class, 'preview'])
    ->name('project.quotations.preview');

Route::post('/projects/{project}/versions/{version}/quotations/generate-pdf', [QuotationController::class, 'generatePdf'])
    ->name('project.quotations.generate-pdf');

Route::get('/projects/{project}/versions/{version}/quotations/download', [QuotationController::class, 'downloadPdf'])
    ->name('project.quotations.download-pdf');