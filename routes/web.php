<?php

use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\BuildingController;
use App\Http\Controllers\Catalogs\PermissionController;
use App\Http\Controllers\Catalogs\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DigitalEquipments\AttendanceSystemController;
use App\Http\Controllers\DigitalEquipments\BatteryChargerController;
use App\Http\Controllers\DigitalEquipments\CameraController;
use App\Http\Controllers\DigitalEquipments\CameraHolderController;
use App\Http\Controllers\DigitalEquipments\CctvController;
use App\Http\Controllers\DigitalEquipments\DVBController;
use App\Http\Controllers\DigitalEquipments\ExternalHardDiskController;
use App\Http\Controllers\DigitalEquipments\FlashMemoryController;
use App\Http\Controllers\DigitalEquipments\LaptopController;
use App\Http\Controllers\DigitalEquipments\MicrophoneController;
use App\Http\Controllers\DigitalEquipments\MobileController;
use App\Http\Controllers\DigitalEquipments\PhoneController;
use App\Http\Controllers\DigitalEquipments\RecorderController;
use App\Http\Controllers\DigitalEquipments\SatelliteDishController;
use App\Http\Controllers\DigitalEquipments\SatelliteFinderController;
use App\Http\Controllers\DigitalEquipments\SimcardController;
use App\Http\Controllers\DigitalEquipments\SoundCardController;
use App\Http\Controllers\DigitalEquipments\SpeakerController;
use App\Http\Controllers\DigitalEquipments\TabletController;
use App\Http\Controllers\DigitalEquipments\TelevisionController;
use App\Http\Controllers\DigitalEquipments\CameraLensController;
use App\Http\Controllers\DigitalEquipments\UpsController;
use App\Http\Controllers\DigitalEquipments\VideoProjectorController;
use App\Http\Controllers\DigitalEquipments\VideoProjectorCurtainController;
use App\Http\Controllers\DigitalEquipments\WebcamController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\HardwareEquipments\CaseController;
use App\Http\Controllers\HardwareEquipments\CopyMachineController;
use App\Http\Controllers\HardwareEquipments\CpuController;
use App\Http\Controllers\HardwareEquipments\GraphicCardController;
use App\Http\Controllers\HardwareEquipments\HeadsetController;
use App\Http\Controllers\HardwareEquipments\InternalHardDiskController;
use App\Http\Controllers\HardwareEquipments\KeyboardController;
use App\Http\Controllers\HardwareEquipments\MonitorController;
use App\Http\Controllers\HardwareEquipments\MotherboardController;
use App\Http\Controllers\HardwareEquipments\MouseController;
use App\Http\Controllers\HardwareEquipments\OddController;
use App\Http\Controllers\HardwareEquipments\PowerController;
use App\Http\Controllers\HardwareEquipments\PrinterController;
use App\Http\Controllers\HardwareEquipments\RamController;
use App\Http\Controllers\HardwareEquipments\ScannerController;
use App\Http\Controllers\HardwareEquipments\VoipController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NetworkEquipments\AccessPointController;
use App\Http\Controllers\NetworkEquipments\CableTesterController;
use App\Http\Controllers\NetworkEquipments\DongleController;
use App\Http\Controllers\NetworkEquipments\KvmController;
use App\Http\Controllers\NetworkEquipments\LantvController;
use App\Http\Controllers\NetworkEquipments\ModemController;
use App\Http\Controllers\NetworkEquipments\NetworkCardController;
use App\Http\Controllers\NetworkEquipments\PunchWrenchController;
use App\Http\Controllers\NetworkEquipments\RackControllers;
use App\Http\Controllers\NetworkEquipments\RadioWirelessController;
use App\Http\Controllers\NetworkEquipments\RouterController;
use App\Http\Controllers\NetworkEquipments\SocketWrenchController;
use App\Http\Controllers\NetworkEquipments\StripperWrenchController;
use App\Http\Controllers\NetworkEquipments\SwitchController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\Reports\DatabaseBackupController;
use App\Http\Controllers\Reports\HistoryController;
use App\Http\Controllers\TechnicalFacilities\BlowerController;
use App\Http\Controllers\TechnicalFacilities\ChairController;
use App\Http\Controllers\TechnicalFacilities\DrawerFileCabinetController;
use App\Http\Controllers\TechnicalFacilities\FireExtinguisherController;
use App\Http\Controllers\TechnicalFacilities\KeyBoxController;
use App\Http\Controllers\TechnicalFacilities\RefrigeratorController;
use App\Http\Controllers\TechnicalFacilities\TableController;
use App\Http\Controllers\UserManager;
use App\Http\Middleware\MenuMiddleware;
use App\Http\Middleware\NTCPMiddleware;
use App\Http\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Login Routes
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::middleware(ThrottleRequests::class)->post('/login', [LoginController::class, 'login']);
Route::get('/captcha', [LoginController::class, 'getCaptcha'])->name('captcha');


//Panel Routes
Route::middleware(['auth', MenuMiddleware::class])->group(function () {
    Route::get('/dateandtime', [DashboardController::class, 'jalaliDateAndTime']);
    Route::get('/date', [DashboardController::class, 'jalaliDate']);
    Route::get('/Profile', [DashboardController::class, 'Profile'])->name('Profile');
    Route::post('/ChangePasswordInc', [DashboardController::class, 'ChangePasswordInc']);
    Route::post('/ChangeUserImage', [DashboardController::class, 'ChangeUserImage']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(NTCPMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //User Manager
        Route::get('/UserManager', [UserManager::class, 'index'])->name('UserManager');
        Route::get('/GetUserInfo', [UserManager::class, 'getUserInfo'])->name('GetUserInfo');
        Route::Post('/NewUser', [UserManager::class, 'newUser'])->name('NewUser');
        Route::Post('/EditUser', [UserManager::class, 'editUser'])->name('EditUser');
        Route::Post('/ChangeUserActivationStatus', [UserManager::class, 'changeUserActivationStatus'])->name('ChangeUserActivationStatus');
        Route::Post('/ChangeUserNTCP', [UserManager::class, 'ChangeUserNTCP'])->name('ChangeUserNTCP');
        Route::Post('/ResetPassword', [UserManager::class, 'ResetPassword'])->name('ResetPassword');

        //Role Controller
        Route::resource('/Roles', RoleController::class);
        Route::resource('/Permissions', PermissionController::class);

        //Personnels
        Route::resource('/Personnels', PersonnelController::class);

        //Reports
        Route::prefix('BackupDatabase')->group(function () {
            Route::get('/', [DatabaseBackupController::class, 'index']);
            Route::post('/', [DatabaseBackupController::class, 'createBackup']);
        });
    });
});

