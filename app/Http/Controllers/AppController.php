<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Exception;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /*==================================================Common=========================== */
    // To check User Status
    public function checkUserStatus(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $result = $app_model->checkUserStatus($userId, $roleId);
        return response()->json($result);
    }

    // To check Mobile Number
    public function checkMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->checkMobileNumber($mobileNumber);
        return response()->json($result);
    }

    // To check login
    public function checkLogin(Request $request)
    {
        $app_model = new AppModel;
        $mobile = $request->mobile;
        $password = $request->password;
        $userDeviceToken = $request->userDeviceToken;
        $result = $app_model->checkLogin($mobile, $password, $userDeviceToken);
        return response()->json($result);
    }

    // To update device token
    public function updateDeviceToken(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $userDeviceToken = $request->userDeviceToken;
        $result = $app_model->updateDeviceToken($userId, $userDeviceToken);
        return response()->json($result);
    }
    // To get city
    public function getCity(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $app_model = new AppModel;
        $app_model->getCity($pageNumber, $itemToLoad, $searchText);
    }

    // To send password
    public function sendPassword(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->sendPassword($mobileNumber);
        return response()->json($result);
    }
// To get area
    public function getArea(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $app_model = new AppModel;
        $app_model->getArea($pageNumber, $itemToLoad, $searchText, $cityId);
    }

    // To get the slider
    public function getSlider(Request $request)
    {
        $app_model = new AppModel;
        $sliderPosition = $request->sliderPosition;
        $areaId = $request->areaId;
        $cityId = $request->cityId;
        $result = $app_model->getSlider($sliderPosition, $areaId, $cityId);
        return response()->json($result);
    }
    // To get Disease Category
    public function getDiseaseCategory(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $app_model = new AppModel;
        $app_model->getDiseaseCategory($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position);
    }

    // To get Health Tips
    public function getHealthTips(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $app_model = new AppModel;
        $app_model->getHealthTips($pageNumber, $itemToLoad, $userId, $roleId);
    }

    // To save health tips like
    public function saveHealthTipsLike(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $healthTipsId = $request->healthTipsId;
        $userFirstName = $request->userFirstName;
        $userLastName = $request->userLastName;
        $userFullName = $request->userFullName;
        $userProfileImage = $request->userProfileImage;
        $result = $app_model->saveHealthTipsLike($userId, $healthTipsId, $userFirstName,
            $userLastName, $userFullName, $userProfileImage);
        return response()->json($result);
    }

    // To delete health tips like
    public function deleteHealthTips(Request $request)
    {
        $app_model = new AppModel;
        $healthTipsId = $request->healthTipsId;
        $healthTipsImage = $request->healthTipsImage;

        $result = $app_model->deleteHealthTips($healthTipsId, $healthTipsImage);
        return response()->json($result);
    }

    //get health tip comment
    public function getHealthTipComment(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $healthTipsId = $request->healthTipsId;
        $app_model = new AppModel;
        $app_model->getHealthTipComment($healthTipsId, $pageNumber, $itemToLoad);
    }

    // To save comment
    public function saveHealthTipcomment(Request $request)
    {
        $app_model = new AppModel;
        $healthTipsId = $request->healthTipsId;
        $userId = $request->userId;
        $userFirstName = $request->userFirstName;
        $userLastName = $request->userLastName;
        $userFullName = $request->userFullName;
        $userProfileImage = $request->userProfileImage;
        $comment = $request->comment;
        $result = $app_model->saveHealthTipcomment($healthTipsId, $userId, $comment, $userFirstName,
            $userLastName, $userFullName, $userProfileImage);
        return response()->json($result);
    }

/*==================================================Customer=========================== */

    // Customer/Patient
    // Send Sign up OTP
    public function sendCustomerSignupOTP($mobile, $otp)
    {
        try
        {
           $smstext = rawurlencode("<#>  Your mobile verification code is: " . $otp . " , Please don't share this code with anyone.Regards, P Maiti xAbhSkGTbQr");
             $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=256dda14-3d85-4e46-83aa-1d12103bc1e2&senderid=PRIMAI&channel=2&DCS=0&flashsms=0&number=$mobile&text=%3C%23%3E%20Your%20mobile%20verification%20code%20is:%20" . $otp . ",%20Please%20don%27t%20share%20this%20code%20with%20anyone.%20Regards,%20P%20Maiti%20B9lNg9PPw1b&route=31&EntityId=1301162038261824606&dlttemplateid=1307162100179461666");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

// To register  user
    public function registerCustomer(Request $request)
    {
        $app_model = new AppModel;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobile = $request->mobile;
        $password = $request->password;
        $deviceToken = $request->deviceToken;
        $result = $app_model->registerCustomer($firstName, $lastName, $mobile, $password, $deviceToken);
        return response()->json($result);
    }

    // search doctor clinic speciality
    public function searchDoctorClinicSpeciality(Request $request)
    {
        $app_model = new AppModel;
        $searchText = $request->searchText;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $result = $app_model->searchDoctorClinicSpeciality($searchText, $pageNumber, $itemToLoad
            , $cityId, $areaId);

    }

    // To get clinic list
    public function getClinicList(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $app_model = new AppModel;
        $app_model->getClinicList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position);
    }

    // To get Doctor List
    public function getDctorsList(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $diseaseCategoryId = $request->diseaseCategoryId;
        $app_model = new AppModel;
        $app_model->getDctorsList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position, $diseaseCategoryId);
    }

    // To change password
    public function changeCustomerPassword(Request $request)
    {
        $app_model = new AppModel;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $userId = $request->userId;
        $result = $app_model->changeCustomerPassword($oldPassword, $newPassword, $userId);
        return response()->json($result);
    }

// Upload profile image
    public function customerProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName));
        }

        $request->file->storeAs('public/user_profile_pic', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }
    //update profile image
    public function updateCustomerProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->updateCustomerProfileImage($userId, $fileName);
        return response()->json($result);
    }
    // Remove profile Image
    public function removeCustomerProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->removeCustomerProfileImage($userId, $fileName);
        return response()->json($result);
    }

    // Update first name
    public function updateCustomerFirstName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $firstName = $request->firstName;
        $fullName = $request->fullName;
        $result = $app_model->updateCustomerFirstName($userId, $firstName, $fullName);
        return response()->json($result);
    }
    // Update last name
    public function updateCustomerLastName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $lastName = $request->lastName;
        $fullName = $request->fullName;
        $result = $app_model->updateCustomerLastName($userId, $lastName, $fullName);
        return response()->json($result);
    }
    //update mobile number
    public function updateCustomerMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->updateCustomerMobileNumber($userId, $mobileNumber);
        return response()->json($result);
    }

    // To get the customer personal profile
    public function getCustomerPersonalProfileDetails(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $result = $app_model->getCustomerPersonalProfileDetails($userId);
        return response()->json($result);
    }
    //update customer personal details
    public function updateCustomerPersonalProfileDetails(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $email = $request->email;
        $dob = $request->dob;
        $gender = $request->gender;
        $bloodGroup = $request->bloodGroup;
        $martitalStatus = $request->martitalStatus;
        $height = $request->height;
        $weight = $request->weight;
        $address = $request->address;
        $result = $app_model->updateCustomerPersonalProfileDetails($userId, $email, $dob, $gender,
            $bloodGroup, $martitalStatus, $height, $weight, $address);
        return response()->json($result);
    }

    // To get the clinic images
    public function getClinicImages(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicImages($clinicId);
        return response()->json($result);
    }

    // To get the individual clinic details
    public function getClinicDetails(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicDetails($clinicId);
        return response()->json($result);
    }

    // To get the clinic timing
    public function getClinicTiming(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicTiming($clinicId);
        return response()->json($result);
    }

    // To get the clinic service
    public function getClinicService(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicService($clinicId);
        return response()->json($result);
    }

    // To get Doctor List clinic wise
    public function getDoctorsListClinicWise(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $clinicId = $request->clinicId;
        $app_model = new AppModel;
        $app_model->getDoctorsListClinicWise($pageNumber, $itemToLoad, $clinicId);
    }

    // To get the doctor details
    public function getDoctorDetails(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getDoctorDetails($doctorId);
        return response()->json($result);
    }

    // To get the doctor associated clinic
    public function getDoctorAssociatedClinic(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $clinicId = $request->clinicId;
        $result = $app_model->getDoctorAssociatedClinic($doctorId, $clinicId);
        return response()->json($result);
    }

    // To get the doctor associated clinic
    public function getDoctorOtherDetails(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getDoctorOtherDetails($doctorId);
        return response()->json($result);
    }

    // To get the booking slot
    public function getInClinicBookingSlotDates(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $result = $app_model->getInClinicBookingSlotDates($clinicId, $doctorId);
        return response()->json($result);
    }

    // To get the in clinic slot id and position date wise
    public function getInClinicSlotIdPositionDateWise(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotBookingDate = $request->inClinicSlotBookingDate;
        $inClinicSlotId = $request->inClinicSlotId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $result = $app_model->getInClinicSlotIdPositionDateWise($inClinicSlotBookingDate, $inClinicSlotId,
            $clinicId, $doctorId);
        return response()->json($result);

    }

    // To get the in clinic slot id and position date wise
    public function getInClinicSlotIdPositionDateWiseForMyBooking(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotBookingDate = $request->inClinicSlotBookingDate;
        $inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->getInClinicSlotIdPositionDateWiseForMyBooking($inClinicSlotBookingDate, $inClinicSlotId);
        return response()->json($result);
    }

    // To get the booking slot position
    public function getInClinicBookingSlotPosition(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotId = $request->inClinicSlotId;
        $inClinicBookingDate = $request->inClinicBookingDate;
        $slotNameId = $request->slotNameId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $inClinicMaxSlotPositionDateWise = $request->inClinicMaxSlotPositionDateWise;
        $result = $app_model->getInClinicBookingSlotPosition($inClinicSlotId,
            $inClinicBookingDate, $slotNameId, $clinicId, $doctorId, $inClinicMaxSlotPositionDateWise);
        return response()->json($result);
    }

    // save update family member
    public function saveUpdateFamilyMember(Request $request)
    {
        $app_model = new AppModel;
        $familyId = $request->familyId;
        $userId = $request->userId;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobileNumber = $request->mobileNumber;
        $profileImage = $request->profileImage;
        $email = $request->email;
        $dob = $request->dob;
        $gender = $request->gender;
        $bloodGroup = $request->bloodGroup;
        $maritalStatus = $request->maritalStatus;
        $height = $request->height;
        $weight = $request->weight;
        $address = $request->address;
        $relation = $request->relation;

        $result = $app_model->saveUpdateFamilyMember($familyId, $userId, $firstName, $lastName, $mobileNumber,
            $profileImage, $email, $dob, $gender, $bloodGroup, $maritalStatus,
            $height, $weight, $address, $relation
        );
        return response()->json($result);
    }

    // To get the family member list
    public function getFamilyMemberList(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $result = $app_model->getFamilyMemberList($userId);
        return response()->json($result);
    }

    // save inclinic booking
    public function saveInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotId = $request->inClinicSlotId;
        $inClinicSlotDateId = $request->inClinicSlotDateId;
        $slotNameId = $request->slotNameId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $bookingMadeByRoleId = $request->bookingMadeByRoleId;
        $bookingMadeByUserId = $request->bookingMadeByUserId;
        $bookingMadeForFamilyId = $request->bookingMadeForFamilyId;
        $isBookingDoneForSelf = $request->isBookingDoneForSelf;
        $bookingSlotPosition = $request->bookingSlotPosition;
        $bookingDate = $request->bookingDate;
        $inClinicPrice = $request->inClinicPrice;
        $paymentMethodId = $request->paymentMethodId;
        $rewardId = $request->rewardId;
        $rewardTransactionId = $request->rewardTransactionId;
        $offerId = $request->offerId;
        $paidAmount = $request->paidAmount;
        $offerPrice = $request->offerPrice;
        $inClinicServiceFee = $request->inClinicServiceFee;
        $inClinicCancellationDays = $request->inClinicCancellationDays;
		 $specialization_disease_mapping_id= $request->specialization_disease_mapping_id;
        $disease_name= $request->disease_name;


        $result = $app_model->saveInClinicBooking($inClinicSlotId, $inClinicSlotDateId,
            $slotNameId, $clinicId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
            $bookingMadeForFamilyId, $isBookingDoneForSelf, $bookingSlotPosition,
            $bookingDate, $inClinicPrice, $paymentMethodId,
            $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice,
            $inClinicServiceFee, $inClinicCancellationDays,$specialization_disease_mapping_id,
              $disease_name
        );
        return response()->json($result);
    }

    // To get the in clinic booking  list
    public function getInClinicBookingList(Request $request)
    {
        $app_model = new AppModel;
        $bookigDoneByUserId = $request->bookigDoneByUserId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getInClinicBookingList($bookigDoneByUserId,
            $bookigStatus, $pageNumber, $itemToLoad);

    }

    // save inclinic booking
    public function cancelInClinicBooking(Request $request)
    {
         $app_model = new AppModel;
        $in_clinic_booking_id = $request->in_clinic_booking_id;
        $familyMobileNumber = $request->familyMobileNumber;
        $doctorName = $request->doctorName;
        $clinicName = $request->clinicName;
        $bookingDate = $request->bookingDate;
        $inClinicSlotDatesId= $request->inClinicSlotDatesId;
        $inClinicSlotId= $request->inClinicSlotId;

        $result = $app_model->cancelInClinicBooking($in_clinic_booking_id, $familyMobileNumber,
            $doctorName, $clinicName, $bookingDate, $inClinicSlotDatesId,  $inClinicSlotId);
        return response()->json($result);
    }

    // To get privacy policy
    public function getPrivacyPolicy(Request $request)
    {
        $app_model = new AppModel;
        $legalId = $request->legalId;
        $result = $app_model->getPrivacyPolicy($legalId);
        return response()->json($result);
    }

    //clinic

    // Upload profile image
    public function clinicProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName));
        }

        $request->file->storeAs('public/user_profile_pic', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }
    //update profile image
    public function updateClinicProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $fileName = $request->fileName;
        $result = $app_model->updateClinicProfileImage($clinicId, $fileName);
        return response()->json($result);
    }
    // Remove profile Image
    public function removeClinicProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $fileName = $request->fileName;
        $result = $app_model->removeClinicProfileImage($clinicId, $fileName);
        return response()->json($result);
    }

    // Update first name
    public function updateClinicFirstName(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $firstName = $request->firstName;
        $fullName = $request->fullName;
        $result = $app_model->updateClinicFirstName($clinicId, $firstName, $fullName);
        return response()->json($result);
    }
    // Update last name
    public function updateClinicLastName(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $lastName = $request->lastName;
        $fullName = $request->fullName;
        $result = $app_model->updateClinicLastName($clinicId, $lastName, $fullName);
        return response()->json($result);
    }
    //update mobile number
    public function updateClinicMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $userId = $request->userId;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->updateClinicMobileNumber($clinicId, $userId, $mobileNumber);
        return response()->json($result);
    }

    // save inclinic booking by clinic
    public function saveInClinicBookingByClinic(Request $request)
    {
        $app_model = new AppModel;
        $familyId = $request->familyId;
        $patientFirstName = $request->patientFirstName;
        $patientLastName = $request->patientLastName;
        $patientMobileNumber = $request->patientMobileNumber;
        $isExistingPatient = $request->isExistingPatient;
        $inClinicSlotId = $request->inClinicSlotId;
        $inClinicSlotDateId = $request->inClinicSlotDateId;
        $slotNameId = $request->slotNameId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $bookingMadeByRoleId = $request->bookingMadeByRoleId;
        $bookingMadeByUserId = $request->bookingMadeByUserId;

        $isBookingDoneForSelf = $request->isBookingDoneForSelf;
        $bookingSlotPosition = $request->bookingSlotPosition;
        $bookingDate = $request->bookingDate;
        $inClinicPrice = $request->inClinicPrice;
        $paymentMethodId = $request->paymentMethodId;
        $rewardId = $request->rewardId;
        $rewardTransactionId = $request->rewardTransactionId;
        $offerId = $request->offerId;
        $paidAmount = $request->paidAmount;
        $offerPrice = $request->offerPrice;
        $inClinicServiceFee = $request->inClinicServiceFee;
        $inClinicCancellationDays = $request->inClinicCancellationDays;
		 $specialization_disease_mapping_id = $request->specialization_disease_mapping_id;
$disease_name = $request->disease_name;

        $result = $app_model->saveInClinicBookingByClinic($familyId, $patientFirstName, $patientLastName, $patientMobileNumber, $isExistingPatient, $inClinicSlotId, $inClinicSlotDateId,
            $slotNameId, $clinicId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
            $isBookingDoneForSelf, $bookingSlotPosition,
            $bookingDate, $inClinicPrice, $paymentMethodId,
            $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice, $inClinicServiceFee, $inClinicCancellationDays, $specialization_disease_mapping_id,$disease_name
        );
        return response()->json($result);
    }

    // To get the in clinic booking  list
    public function getInClinicBookingListByClinic(Request $request)
    {
        $app_model = new AppModel;
        $bookigDoneForClinicId = $request->bookigDoneForClinicId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getInClinicBookingListByClinic($bookigDoneForClinicId,
            $bookigStatus, $pageNumber, $itemToLoad);

    }

    // To get the booking slot date by clinic
    public function getInClinicBookingSlotDateByClinic(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getInClinicBookingSlotDateByClinic($clinicId);
        return response()->json($result);
    }

    // To get the in clinic booking  list date slot clinic wise
    public function getDoctorListDateSlotClinicWise(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $slotNameId = $request->slotNameId;

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getDoctorListDateSlotClinicWise($clinicId,
            $inClinicSlotDatesId, $slotNameId, $pageNumber, $itemToLoad);

    }

    // To get the in clinic booking  list
    public function getInClinicBookingByClinicDoctorSlotDate(Request $request)
    {
        $app_model = new AppModel;
        $bookingStatus = $request->bookingStatus;
        $clinicId = $request->clinicId;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $slotNameId = $request->slotNameId;
        $doctorId = $request->doctorId;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getInClinicBookingByClinicDoctorSlotDate($bookingStatus, $clinicId,
            $inClinicSlotDatesId, $slotNameId, $doctorId, $pageNumber, $itemToLoad);

    }

    // save inclinic booking
       public function completeInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $in_clinic_booking_id = $request->in_clinic_booking_id;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
$inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->completeInClinicBooking($in_clinic_booking_id, $inClinicSlotDatesId ,$inClinicSlotId );
        return response()->json($result);
    }

    // To get the in clinic booking  list date slot clinic wise
    public function cancelAllInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $slotNameId = $request->slotNameId;
        $doctorId = $request->doctorId;

        $result = $app_model->cancelAllInClinicBooking($clinicId,
            $inClinicSlotDatesId, $slotNameId, $doctorId);
        return response()->json($result);
    }

    public function sendAllTypeSMS(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->sendAllTypeSMS();
        return response()->json($result);
    }

    public function getSMSStatus(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->getSMSStatus();
        return response()->json($result);
    }

    // To notify customer about doctor date slot
    public function notifyCustomerAboutDoctorDateSlot(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $userId = $request->userId;
        $result = $app_model->notifyCustomerAboutDoctorDateSlot($clinicId,
            $doctorId, $userId);
        return response()->json($result);
    }

    // search doctor
    public function searchDoctor(Request $request)
    {
        $app_model = new AppModel;
        $searchText = $request->searchText;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->searchDoctor($searchText, $pageNumber,
            $itemToLoad
        );

    }

    public function autoCancelInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->autoCancelInClinicBooking();
        return response()->json($result);
    }




    // To get the doctor associated clinic
    public function getApolloDoctor(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getApolloDoctor($clinicId);
        return response()->json($result);
    }



    // dummy function to insert slot date
    public function insertSlotDate(Request $request)
    {

        $in_clinic_slot_id = $request->in_clinic_slot_id;
        $in_clinic_slot_start_time = $request->in_clinic_slot_start_time;
        $in_clinic_slot_end_time = $request->in_clinic_slot_end_time;

        $getInClinicSlotQuery = DB::table('dm_in_clinic_slot')
            ->where('in_clinic_slot_id', '=', $in_clinic_slot_id)
            ->get();

        if ($getInClinicSlotQuery->count() > 0) {
            $getInClinicSlotResult = $getInClinicSlotQuery->toArray();
            $currentDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+90 days'));

            $oneday = new DateInterval("P1D");

            $currentDate = new DateTime($currentDate);
            $endDate = new DateTime($endDate);

            $days = array();

            $excludedDays = $getInClinicSlotResult[0]->in_clinic_doctor_booking_week_days;
            $excludedDaysinArray = explode(",", $excludedDays);
            if ($excludedDays == 0) {
                foreach (new DatePeriod($currentDate, $oneday, $endDate->add($oneday)) as $day) {
                    array_push($days, $day->format("Y-m-d"));
                }

            } else {
                foreach (new DatePeriod($currentDate, $oneday, $endDate->add($oneday)) as $day) {
                    $day_num = $day->format("N");

                    for ($x = 0; $x < count($excludedDaysinArray); $x++) {

                        if ($excludedDaysinArray[$x] == $day_num) {
                            array_push($days, $day->format("Y-m-d"));
                        }

                    }

                }
            }

        }
        DB::beginTransaction();
        try {

            foreach ($days as $day) {
                $resultData = DB::table('dm_in_clinic_slot_dates')->insertGetId(
                    [
                        'in_clinic_slot_id' => $in_clinic_slot_id,
                        'in_clinic_slot_dates' => $day,
                        'in_clinic_slot_start_time' => $getInClinicSlotResult[0]->in_clinic_slot_start_time,
                        'in_clinic_slot_end_time' => $getInClinicSlotResult[0]->in_clinic_slot_end_time,
                        'in_clinic_max_slot_position_datewise' => $getInClinicSlotResult[0]->in_clinic_max_slot_position,

                    ]
                );
            }
            DB::commit();
            return response()->json(['result' => $resultData]);
        } catch (Exception $ex) {

            DB::rollback();
            $resultData['result'] = "Exception";
            return response()->json($resultData);

        }

    }

  public function markDoctorIn(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $inClinicSlotId = $request->inClinicSlotId;


        $result = $app_model->markDoctorIn($inClinicSlotDatesId,  $inClinicSlotId );
        return response()->json($result);
    }
	// To get disease specialization wise
    public function getSpecializationWiseDisease(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getSpecializationWiseDisease($doctorId );
        return response()->json($result);
    }
	 // mark patient absent
    public function markPatientAbsent(Request $request)
    {
        $app_model = new AppModel;
        $in_clinic_booking_id = $request->in_clinic_booking_id;
        $familyMobileNumber = $request->familyMobileNumber;
        $doctorName = $request->doctorName;
        $clinicName = $request->clinicName;
        $bookingDate = $request->bookingDate;
        $inClinicSlotDatesId= $request->inClinicSlotDatesId;
        $inClinicSlotId= $request->inClinicSlotId;

        $result = $app_model->markPatientAbsent($in_clinic_booking_id, $familyMobileNumber,
            $doctorName, $clinicName, $bookingDate, $inClinicSlotDatesId,  $inClinicSlotId);
        return response()->json($result);
    }

}
