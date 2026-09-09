<?php

use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ProjectCostController;
use App\Http\Controllers\Api\V1\ProjectFeatureController;
use App\Http\Controllers\Api\V1\ProjectVersionController;
use App\Http\Controllers\Api\V1\QuotationController;
use Illuminate\Support\Facades\Route;


/**
 * =====================================
 *      Project Management Module (mock)
 * =====================================
 */

// Projects
Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::patch('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
Route::patch('projects/{project}/status', [ProjectController::class, 'changeStatus'])->name('projects.status');

// Project Members
Route::get('projects/{project}/members', [ProjectController::class, 'members'])->name('projects.members.index');
Route::patch('projects/{project}/members/{member}', [ProjectController::class, 'updateMember'])->name('projects.members.update');
Route::delete('projects/{project}/members/{member}', [ProjectController::class, 'deleteMember'])->name('projects.members.destroy');

// Project Versions
Route::get('projects/{project}/versions', [ProjectVersionController::class, 'index'])->name('project.versions.index');
Route::post('projects/{project}/versions', [ProjectVersionController::class, 'store'])->name('project.versions.store');
Route::get('projects/{project}/versions/{version}', [ProjectVersionController::class, 'show'])->name('project.versions.show');
Route::patch('projects/{project}/versions/{version}', [ProjectVersionController::class, 'update'])->name('project.versions.update');
Route::delete('projects/{project}/versions/{version}', [ProjectVersionController::class, 'destroy'])->name('project.versions.destroy');
Route::patch('projects/{project}/versions/{version}/freeze', [ProjectVersionController::class, 'freeze'])->name('project.versions.freeze');
Route::post('projects/{project}/versions/{version}/clone', [ProjectVersionController::class, 'clone'])->name('project.versions.clone');

// Project Features
Route::get('projects/{project}/versions/{version}/features', [ProjectFeatureController::class, 'index'])->name('project.features.index');
Route::post('projects/{project}/versions/{version}/features', [ProjectFeatureController::class, 'store'])->name('project.features.store');
Route::get('projects/{project}/versions/{version}/features/{feature}', [ProjectFeatureController::class, 'show'])->name('project.features.show');
Route::patch('projects/{project}/versions/{version}/features/{feature}', [ProjectFeatureController::class, 'update'])->name('project.features.update');
Route::delete('projects/{project}/versions/{version}/features/{feature}', [ProjectFeatureController::class, 'destroy'])->name('project.features.destroy');
Route::patch('projects/{project}/versions/{version}/features/{feature}/status', [ProjectFeatureController::class, 'changeStatus'])->name('project.features.status');

// Project Costs
Route::get('projects/{project}/versions/{version}/costs', [ProjectCostController::class, 'index'])->name('project.costs.index');
Route::post('projects/{project}/versions/{version}/costs', [ProjectCostController::class, 'store'])->name('project.costs.store');
Route::get('projects/{project}/versions/{version}/costs/{cost}', [ProjectCostController::class, 'show'])->name('project.costs.show');
Route::patch('projects/{project}/versions/{version}/costs/{cost}', [ProjectCostController::class, 'update'])->name('project.costs.update');
Route::delete('projects/{project}/versions/{version}/costs/{cost}', [ProjectCostController::class, 'destroy'])->name('project.costs.destroy');

// Quotations
Route::get('projects/{project}/versions/{version}/quotations', [QuotationController::class, 'index'])->name('project.quotations.index');
Route::post('projects/{project}/versions/{version}/quotations', [QuotationController::class, 'store'])->name('project.quotations.store');
Route::get('projects/{project}/versions/{version}/quotations/{quotation}', [QuotationController::class, 'show'])->name('project.quotations.show');
Route::patch('projects/{project}/versions/{version}/quotations/{quotation}', [QuotationController::class, 'update'])->name('project.quotations.update');
Route::delete('projects/{project}/versions/{version}/quotations/{quotation}', [QuotationController::class, 'destroy'])->name('project.quotations.destroy');
Route::post('projects/{project}/versions/{version}/quotations/{quotation}/generate-pdf', [QuotationController::class, 'generatePdf'])->name('project.quotations.generate-pdf');
