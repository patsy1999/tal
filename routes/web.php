<?php

/**
 * Application Routes File
 *
 * This file defines all web routes for the application, grouped by:
 * - Public routes (accessible to all)
 * - Authenticated routes (protected by auth middleware)
 *
 * Routes are organized by functional areas with clear section headers
 */

// Authentication routes (login, registration, password reset, etc.)
require __DIR__.'/auth.php';

// Import all necessary controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\TookenItemController;
use App\Http\Controllers\TemperatureLogController;
use App\Http\Controllers\CalibrationController;
use App\Http\Controllers\ChlorineControlController;
use App\Http\Controllers\DailyEquipmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\MaintenanceInterventionController;
use App\Http\Controllers\MosquitoCheckController;
use App\Http\Controllers\RatTrapCheckController;
use App\Http\Controllers\MechanicalTrapCheckController;
use App\Http\Controllers\TrapCheckController;
use App\Http\Controllers\DashboardController;




// ==================== PUBLIC ROUTES ==================== //
// These routes are accessible without authentication

/**
 * Welcome/Home Page
 *
 * Displays the public landing page for unauthenticated users
 * Route: GET /
 */
Route::get('/', function () {
    return view('welcome');
});

// ==================== AUTHENTICATED ROUTES ==================== //
// All routes within this group require authentication and email verification
Route::middleware(['auth', 'verified'])->group(function () {

    // ==================== DASHBOARD ROUTES ==================== //

    /**
     * Main Application Dashboard
     *
     * Displays the primary dashboard view after login
     * Route: GET /dashboard
     */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Group all routes under /dashboard prefix for better organization
    Route::prefix('dashboard')->group(function () {

        // ==================== PROFILE MANAGEMENT ==================== //

        /**
         * User Profile Routes
         *
         * Allows users to view/edit their profile information
         */
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // ==================== TEMPERATURE MONITORING ==================== //

        /**
         * Temperature Log System
         *
         * Routes for recording and viewing temperature logs
         */
        Route::prefix('temperature-log')->group(function () {
            Route::get('/create', [TemperatureLogController::class, 'create'])->name('temperature_log.create');
            Route::post('/store', [TemperatureLogController::class, 'store'])->name('temperature_log.store');
            Route::post('/download-pdf', [TemperatureLogController::class, 'downloadPDF'])->name('temperature_log.download-pdf');
            Route::get('/show', [TemperatureLogController::class, 'showByDate'])->name('temperature_log.show');
        });

        // ==================== DASHBOARD NAVIGATION ==================== //

        /**
         * Dashboard Links
         *
         * Displays navigation options for the dashboard
         */
        Route::get('/links', function () {
            return view('options.dashboard_links');
        })->name('dashboard.links');

        // Route::get('/links', function () {
        //     if (!Auth::check() || Auth::user()->role !== 'admin') {
        //         abort(403, 'Accès refusé – réservé à l\'admin.');
        //     }

        //     return view('options.dashboard_links');
        // })->name('dashboard.links');

        // ==================== INVENTORY MANAGEMENT ==================== //

        /**
         * Product Withdrawal System
         *
         * Routes for product checkout and history tracking
         */
        Route::get('/take-product', [TookenItemController::class, 'create'])->name('take-product.create');
        Route::post('/take-product', [TookenItemController::class, 'store'])->name('take-product.store');
        Route::get('/take-product/history', [TookenItemController::class, 'index'])->name('take-product.index');

        /**
         * Product Management
         *
         * Full CRUD operations for product management
         */
        Route::resource('products', ProductController::class);
        Route::get('/user/products', [UserProductController::class, 'index'])->name('user.products.list');
        Route::get('/withdrawals/{id}/download-pdf', [TookenItemController::class, 'downloadPdf'])->name('withdrawals.downloadPdf');

        // ==================== EQUIPMENT CALIBRATION ==================== //

        /**
         * Calibration System
         *
         * Routes for equipment calibration records
         */
        Route::get('/calibrations/create', [CalibrationController::class, 'create'])->name('calibrations.create');
        Route::post('/calibrations/store', [CalibrationController::class, 'store'])->name('calibrations.store');
        Route::get('/calibrations', [CalibrationController::class, 'index'])->name('calibrations.index');
        Route::get('/calibrations/download-pdf', [CalibrationController::class, 'downloadPdf'])->name('calibrations.downloadPdf');

        // ==================== DAILY EQUIPMENT CHECKS ==================== //

        /**
         * Daily Equipment Monitoring
         *
         * Routes for daily equipment checks and reporting
         */
        Route::get('/daily-equipments/create', [DailyEquipmentController::class, 'create'])->name('daily_equipments.create');
        Route::get('/daily-equipments/pdf/month', [DailyEquipmentController::class, 'exportMonthlyPdf'])->name('daily_equipments.pdf.month');
        Route::post('/daily-equipments/generate-month', [DailyEquipmentController::class, 'generateMonth'])->name('daily_equipments.generate_month');
        Route::get('/daily-equipments/pdf', [DailyEquipmentController::class, 'exportPdf'])->name('daily_equipments.pdf');
        Route::get('/daily-equipments/month', [DailyEquipmentController::class, 'showMonth'])->name('daily_equipments.month');
        Route::post('/daily-equipments', [DailyEquipmentController::class, 'store'])->name('daily_equipments.store');
        Route::get('/daily-equipments', [DailyEquipmentController::class, 'index'])->name('daily_equipments.index');
        Route::post('/daily-equipments/generate-range', [DailyEquipmentController::class, 'generateRange'])->name('daily_equipments.generate_range');
        Route::get('/daily-equipments/pdf-month', [DailyEquipmentController::class, 'exportMonthlyPdf'])->name('daily_equipments.pdf_month');



        // ==================== CHLORINE CONTROL SYSTEM ==================== //

        /**
         * Chlorine Monitoring
         *
         * Comprehensive routes for chlorine level management
         */
        Route::get('chlorine-controls/random-month', [ChlorineControlController::class, 'showRandomMonthForm'])
            ->name('chlorine-controls.random-month-form');
        Route::post('chlorine-controls/random-month', [ChlorineControlController::class, 'generateRandomMonth'])
            ->name('chlorine-controls.generate-random-month');
        Route::get('chlorine-controls/pdf-export', [ChlorineControlController::class, 'showPdfForm'])
            ->name('chlorine-controls.pdf-form');
        Route::post('chlorine-controls/pdf-export', [ChlorineControlController::class, 'exportPdf'])
            ->name('chlorine-controls.export-pdf');
        Route::get('chlorine-controls/check-today', [ChlorineControlController::class, 'checkToday'])
            ->name('chlorine-controls.check-today');
        Route::get('chlorine-controls/random-add', [ChlorineControlController::class, 'checkToday'])
            ->name('chlorine-controls.random-add');
        Route::post('chlorine-controls/generate-random', [ChlorineControlController::class, 'generateRandom'])
            ->name('chlorine-controls.generate-random');
        Route::resource('chlorine-controls', ChlorineControlController::class);

        // ==================== STOCK HISTORY ==================== //

        /**
         * Inventory History Tracking
         *
         * Routes for stock movement history
         */
        Route::get('/stock-history', [StockHistoryController::class, 'index'])->name('stock.history');
        Route::post('/stock-history/add', [StockHistoryController::class, 'add'])->name('stock.history.add');
        Route::get('/stock-history/pdf', [StockHistoryController::class, 'downloadPDF'])->name('stock.history.pdf');

        // ==================== MAINTENANCE SYSTEM ==================== //

        /**
         * Equipment Maintenance Tracking
         *
         * Routes for maintenance intervention records
         */
        Route::get('/maintenance-form', [MaintenanceInterventionController::class, 'create'])->name('maintenance.create');
        Route::post('/maintenance-form', [MaintenanceInterventionController::class, 'store'])->name('maintenance.store');
        Route::get('/maintenance-records', [MaintenanceInterventionController::class, 'index'])->name('maintenance.index');
        Route::get('/maintenance-records/pdf', [MaintenanceInterventionController::class, 'downloadPDF'])->name('maintenance.pdf');
        Route::get('/maintenance-records/{id}/pdf', [MaintenanceInterventionController::class, 'downloadSinglePDF'])->name('maintenance.single.pdf');
        Route::get('/maintenance/export', [MaintenanceController::class, 'export'])
            ->name('maintenance.export');
        Route::get('/maintenance/{id}', [MaintenanceInterventionController::class, 'show'])
            ->name('maintenance.show');
        Route::delete('/maintenance/{id}', [MaintenanceInterventionController::class, 'destroy'])
            ->name('maintenance.destroy');
        Route::get('/maintenance/export', [MaintenanceInterventionController::class, 'export'])
            ->name('maintenance.export');

        // ==================== MOSQUITO MONITORING ==================== //

        /**
         * Mosquito Control System
         *
         * Routes for mosquito monitoring and reporting
         */
        Route::prefix('mosquito')->name('mosquito.')->group(function () {
            Route::get('/', [MosquitoCheckController::class, 'index'])->name('index');
            Route::get('/create', [MosquitoCheckController::class, 'create'])->name('create');
            Route::post('/store', [MosquitoCheckController::class, 'store'])->name('store');
            Route::get('/export', [MosquitoCheckController::class, 'exportPDF'])->name('export');
        });
        Route::post('/mosquito/generate', [MosquitoCheckController::class, 'generate'])->name('mosquito.generate');
        Route::delete('/mosquito/{id}', [MosquitoCheckController::class, 'destroy'])->name('mosquito.destroy');
        Route::post('/mosquito/clear', [MosquitoCheckController::class, 'clear'])->name('mosquito.clear');


        // ==================== TRAP LOGGING SYSTEM ==================== //
        Route::get('/rat-traps/create', [RatTrapCheckController::class, 'create'])->name('rat-traps.create');
        Route::post('/rat-traps/store', [RatTrapCheckController::class, 'store'])->name('rat-traps.store');
        Route::get('/rat-traps', [RatTrapCheckController::class, 'index'])->name('rat-traps.index');
        // Show edit form for a single rat trap record by ID
        Route::get('/trap-checks/raticide/{id}/edit', [TrapCheckController::class, 'editRaticide'])->name('trap-checks.raticide.edit');
        Route::put('/trap-checks/raticide/{id}', [TrapCheckController::class, 'updateRaticide'])->name('trap-checks.raticide.update');

        // Similarly for mecanique if needed
        Route::get('/trap-checks/mecanique/{id}/edit', [TrapCheckController::class, 'editMecanique'])->name('trap-checks.mecanique.edit');
        Route::put('/trap-checks/mecanique/{id}', [TrapCheckController::class, 'updateMecanique'])->name('trap-checks.mecanique.update');




        // ==================== MECHANICAL TRAP CHECKS ==================== //

        Route::get('/mechanical-traps/create', [MechanicalTrapCheckController::class, 'create'])->name('mechanical-traps.create');
        Route::post('/mechanical-traps/store', [MechanicalTrapCheckController::class, 'store'])->name('mechanical-traps.store');
        Route::get('/mechanical-traps', [MechanicalTrapCheckController::class, 'index'])->name('mechanical-traps.index');
        // ==================== TRAP CHECKS ==================== //

        Route::get('/trap-checks/create', [TrapCheckController::class, 'create'])->name('trap-checks.create');
        Route::post('/trap-checks/store', [TrapCheckController::class, 'store'])->name('trap-checks.store');
        Route::get('/trap-checks', [TrapCheckController::class, 'index'])->name('trap-checks.index');
        Route::get('/trap-checks/pdf/{date}', [TrapCheckController::class, 'exportPdf'])->name('trap-checks.pdf');
        Route::delete('/trap-checks/{id}', [TrapCheckController::class, 'destroy'])->name('trap-checks.destroy');
        Route::delete('/trap-checks/clear/{date}', [TrapCheckController::class, 'clearDate'])->name('trap-checks.clear');
        Route::post('/send-report-email', [App\Http\Controllers\ReportEmailController::class, 'send'])->name('send.report.email');
        Route::post('/send-weekly-report', [DashboardController::class, 'sendWeeklyWithdrawalReport'])->name('dashboard.send-weekly-report');

        Route::post('/dashboard/send-report-email', [DashboardController::class, 'sendWeeklyWithdrawalReport'])->name('dashboard.send-report-email');
        Route::post('/products/send-stock-report', [ProductController::class, 'sendStockReport'])->name('products.send-stock-report');












    }); // End of dashboard prefix group
}); // End of auth middleware group
