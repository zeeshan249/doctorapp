<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ClinicSlotController;
use App\Http\Controllers\ClinicSlotDatesController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/viewclear', function () {
    Artisan::call('view:clear');
});
Route::get('/routeclear', function () {
    Artisan::call('route:clear');
});
Route::get('/configcache', function () {
    Artisan::call('config:cache');
});
Route::get('/cacheclear', function () {
    Artisan::call('cache:clear');
});
/*============================= Login ======================================*/

Route::post('webValidateLogin', [UserLoginController::class, 'webValidateLogin']);

/*==========================City=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getCity', [CityController::class, 'Get']);
    Route::post('saveCity', [CityController::class, 'Save']);
    Route::post('updateCity', [CityController::class, 'Update']);
    Route::post('deleteCity', [CityController::class, 'delete']);
    Route::post('changeCityStatus', [CityController::class, 'Status']);
    Route::get('getWithoutPaginationCity', [CityController::class, 'getWithoutPaginationCity']);
    Route::get('getCityActive', [CityController::class, 'ActiveCity']);
});

/*==========================Area=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getArea', [AreaController::class, 'Get']);
    Route::post('saveArea', [AreaController::class, 'Save']);
    Route::post('updateArea', [AreaController::class, 'Update']);
    Route::post('changeAreaStatus', [AreaController::class, 'Status']);
    Route::post('deleteArea', [AreaController::class, 'delete']);
});

/*==========================Clinic=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getClinicDetails', [ClinicController::class, 'Get']);
    Route::get('clinicWiseBooking', [ClinicController::class, 'clinicWiseBooking']);
    Route::get('upcomingBookingDetails', [ClinicController::class, 'upcomingBookingDetails']);
    Route::get('getDoctorDetailsWithoutPagination',[ClinicController::class,'getDoctorDetailsWithoutPagination']);
    Route::get('getDoctorDetails',[ClinicController::class,'getDoctorDetails']);
});

/*==========================Clinic Slot=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getSlotName', [ClinicSlotController::class, 'getSlotName']);
    Route::get('getSlotDates', [ClinicSlotDatesController::class, 'getAllSlotDates']);
    Route::post('changeDateSlotsStatus', [ClinicSlotDatesController::class, 'slotstatus']);
    Route::post('saveInClinicSlot', [ClinicSlotController::class, 'saveInClinicSlot']);
    Route::post('saveDoctorClinicWise', [ClinicSlotController::class, 'saveDoctorClinicWise']);

});

/*================Booking Details ==================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getBookingDetails', [BookingController::class, 'Get']);
    Route::get('clinicActiveDetails', [BookingController::class, 'clinicActiveDetails']);
    Route::get('doctorActiveDetails', [BookingController::class, 'doctorActiveDetails']);


});

/*==================================================Common=========================== */
Route::post('checkUserStatus', [AppController::class, 'checkUserStatus']);
Route::post('checkMobileNumber', [AppController::class, 'checkMobileNumber']);
Route::post('checkLogin', [AppController::class, 'checkLogin']);
Route::post('updateDeviceToken', [AppController::class, 'updateDeviceToken']);
Route::post('getCity', [AppController::class, 'getCity']);
Route::post('sendPassword', [AppController::class, 'sendPassword']);
Route::post('getArea', [AppController::class, 'getArea']);
Route::post('getSlider', [AppController::class, 'getSlider']);
Route::post('getDiseaseCategory', [AppController::class, 'getDiseaseCategory']);

Route::post('getHealthTips', [AppController::class, 'getHealthTips']);
Route::post('saveHealthTipsLike', [AppController::class, 'saveHealthTipsLike']);
Route::post('deleteHealthTips', [AppController::class, 'deleteHealthTips']);

Route::post('getHealthTipComment', [AppController::class, 'getHealthTipComment']);
Route::post('saveHealthTipcomment', [AppController::class, 'saveHealthTipcomment']);

/*==================================================Customer=========================== */
//Customer/patient
Route::get('sendCustomerSignupOTP/{mobile}/{otp}', [AppController::class, 'sendCustomerSignupOTP']);
Route::post('registerCustomer', [AppController::class, 'registerCustomer']);
Route::post('searchDoctorClinicSpeciality', [AppController::class, 'searchDoctorClinicSpeciality']);
Route::post('getClinicList', [AppController::class, 'getClinicList']);
Route::post('getDctorsList', [AppController::class, 'getDctorsList']);

Route::post('changeCustomerPassword', [AppController::class, 'changeCustomerPassword']);


Route::post('customerProfileImageUpload', [AppController::class, 'customerProfileImageUpload']);
Route::post('updateCustomerProfileImage', [AppController::class, 'updateCustomerProfileImage']);
Route::post('removeCustomerProfileImage', [AppController::class, 'removeCustomerProfileImage']);
Route::post('updateCustomerFirstName', [AppController::class, 'updateCustomerFirstName']);
Route::post('updateCustomerLastName', [AppController::class, 'updateCustomerLastName']);
Route::post('updateCustomerMobileNumber', [AppController::class, 'updateCustomerMobileNumber']);
Route::post('getCustomerPersonalProfileDetails', [AppController::class, 'getCustomerPersonalProfileDetails']);
Route::post('updateCustomerPersonalProfileDetails', [AppController::class, 'updateCustomerPersonalProfileDetails']);

Route::post('getClinicImages', [AppController::class, 'getClinicImages']);
Route::post('getClinicDetails', [AppController::class, 'getClinicDetails']);
Route::post('getClinicTiming', [AppController::class, 'getClinicTiming']);
Route::post('getClinicService', [AppController::class, 'getClinicService']);

Route::post('getDoctorsListClinicWise', [AppController::class, 'getDoctorsListClinicWise']);
Route::post('getDoctorDetails', [AppController::class, 'getDoctorDetails']);
Route::post('getDoctorAssociatedClinic', [AppController::class, 'getDoctorAssociatedClinic']);
Route::post('getDoctorOtherDetails', [AppController::class, 'getDoctorOtherDetails']);
Route::post('getInClinicBookingSlotDates', [AppController::class, 'getInClinicBookingSlotDates']);
Route::post('getInClinicSlotIdPositionDateWise', [AppController::class, 'getInClinicSlotIdPositionDateWise']);
Route::post('getInClinicSlotIdPositionDateWiseForMyBooking', [AppController::class, 'getInClinicSlotIdPositionDateWiseForMyBooking']);

Route::post('getInClinicBookingSlotPosition', [AppController::class, 'getInClinicBookingSlotPosition']);
Route::post('saveUpdateFamilyMember', [AppController::class, 'saveUpdateFamilyMember']);

Route::post('getFamilyMemberList', [AppController::class, 'getFamilyMemberList']);

Route::post('saveInClinicBooking', [AppController::class, 'saveInClinicBooking']);
Route::post('getInClinicBookingList', [AppController::class, 'getInClinicBookingList']);

Route::post('cancelInClinicBooking', [AppController::class, 'cancelInClinicBooking']);

Route::post('getPrivacyPolicy', [AppController::class, 'getPrivacyPolicy']);



// Clinic
Route::post('clinicProfileImageUpload', [AppController::class, 'clinicProfileImageUpload']);
Route::post('updateClinicProfileImage', [AppController::class, 'updateClinicProfileImage']);
Route::post('removeClinicProfileImage', [AppController::class, 'removeClinicProfileImage']);
Route::post('updateClinicFirstName', [AppController::class, 'updateClinicFirstName']);
Route::post('updateClinicLastName', [AppController::class, 'updateClinicLastName']);
Route::post('updateClinicMobileNumber', [AppController::class, 'updateClinicMobileNumber']);
Route::post('saveInClinicBookingByClinic', [AppController::class, 'saveInClinicBookingByClinic']);
Route::post('getInClinicBookingListByClinic', [AppController::class, 'getInClinicBookingListByClinic']);

Route::post('getInClinicBookingSlotDateByClinic', [AppController::class, 'getInClinicBookingSlotDateByClinic']);
Route::post('getDoctorListDateSlotClinicWise', [AppController::class, 'getDoctorListDateSlotClinicWise']);

Route::post('getInClinicBookingByClinicDoctorSlotDate', [AppController::class, 'getInClinicBookingByClinicDoctorSlotDate']);
Route::post('completeInClinicBooking', [AppController::class, 'completeInClinicBooking']);

Route::post('cancelAllInClinicBooking', [AppController::class, 'cancelAllInClinicBooking']);


Route::get('sendAllTypeSMS', [AppController::class, 'sendAllTypeSMS']);
Route::get('getSMSStatus', [AppController::class, 'getSMSStatus']);

Route::post('notifyCustomerAboutDoctorDateSlot', [AppController::class, 'notifyCustomerAboutDoctorDateSlot']);
Route::post('searchDoctor', [AppController::class, 'searchDoctor']);


Route::post('autoCancelInClinicBooking', [AppController::class, 'autoCancelInClinicBooking']);


Route::post('getApolloDoctor', [AppController::class, 'getApolloDoctor']);
Route::post('markDoctorIn', [AppController::class, 'markDoctorIn']);

// dummy function to insert slot date
Route::get('insertSlotDate', [AppController::class, 'insertSlotDate']);
