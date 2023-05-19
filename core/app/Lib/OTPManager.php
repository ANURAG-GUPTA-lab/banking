<?php

namespace App\Lib;

use App\Models\OtpVerification;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

/**
 * Generate One Time Password (OTP)
 * Send the otp to users
 * Verify the user for further action
 */

class OTPManager {

    /** @var Object $parent
     * Contains the instance of otp_verifiable_type model
     */
    public $parent;

    /** @var String $sendVia
     * How the code will be sent to the user
     * The value will be email or sms
     */
    public $sendVia;

    /** @var String $notifyTemplate
     * Which notification template will be used to send the OTP
     */
    public $notifyTemplate;

    /** @var Object $verification
     * contains the row inserted for OTP verification in database
     */
    public $verification;

    /**
     * Insert a new row in database including the otp code
     * Send the otp code to user's email or mobile
     * @param Object $parent the instance of verifiable type
     * @param String $sendVia how the otp will send to the user
     * @param String $notifyTemplate which notification template will be used to send the OTP
     * @param Array $additionalData contains if any additional data needed after verified
     *
     * @return object
     **/
    public function newOTP($parent, $sendVia, $notifyTemplate, $additionalData) {

        $isOtpEnable = checkIsOtpEnable();

        $this->parent         = $parent;
        $this->sendVia        = $sendVia;
        $this->notifyTemplate = $notifyTemplate;
        $this->additionalData = $additionalData;

        $otpVerification                  = new OtpVerification();
        $otpVerification->user_id         = auth()->id();
        $otpVerification->send_via        = $sendVia;
        $otpVerification->notify_template = $notifyTemplate;
        $otpVerification->additional_data = $additionalData;
        $otpVerification->send_at         = now();

        if ($this->sendVia != '2fa' && $isOtpEnable) {
            $otpVerification->otp         = verificationCode(6);
            $otpVerification->expired_at  = now()->addSeconds(gs()->otp_time);
        }

        $this->parent->verifications()->save($otpVerification);
        $this->verification = $otpVerification;


        session()->put('otp_id', $otpVerification->id);

        if (!$isOtpEnable) return to_route($additionalData['after_verified']);

        $this->sendOtp();
        return to_route('user.otp.verify');
    }

    /**
     * Renew the otp code if user request for resend OTP
     *
     * Send the otp code to user's email or mobile
     * @throws ValidationException
     * @return object
     **/
    public function renewOTP() {
        $otpTime    = gs()->otp_time;
        $targetTime = $this->verification->send_at->addSeconds($otpTime);

        if ($targetTime >= now()) {
            throw ValidationException::withMessages(['resend' => 'Please Try after ' . $targetTime->timestamp - time() . ' Seconds']);
        }

        $this->verification->send_at    = now();
        $this->verification->expired_at = now()->addSeconds($otpTime);
        $this->verification->otp        = verificationCode(6);
        $this->verification->save();
        $this->sendOtp();
        return $this->verification;
    }

    /**
     * Send the otp code to user's email or mobile
     *
     * @return void
     **/
    public function sendOtp() {
        if ($this->sendVia != '2fa') {
            $verification = $this->verification;
            $shortCodes   = ['otp' => $this->verification->otp];
            notify($verification->user, $verification->notify_template, $shortCodes, [$verification->send_via], false);
        }
    }

    /**
     * Check the otp code to submitted by the user
     *
     * @throws ValidationException
     * @return boolean
     **/

    public function checkOTP($otp) {
        $verification = $this->verification;

        if ($verification->send_via == '2fa' && (!verifyG2fa(auth()->user(), $otp))) {
            throw ValidationException::withMessages(['error' => 'Invalid session data']);
        }

        if ($verification->user_id != auth()->id()) {
            throw ValidationException::withMessages(['error' => 'Unauthorized action']);
        }

        if ($verification->send_via != '2fa' && $verification->otp != $otp) {
            throw ValidationException::withMessages(['error' => 'Invalid OTP provided']);
        }

        if ($verification->used_at) {
            throw ValidationException::withMessages(['error' => 'This OTP has already been used']);
        }

        if (now() > Carbon::parse($verification->expired_at)) {
            throw ValidationException::withMessages(['error' => 'This OTP has already been expired']);
        }

        return true;
    }

    /**
     * Check if the verification data belongs to the authenticated user
     * Check if the verification data is for the exact verifiable type
     * Check if the user verified with the valid otp code
     * @return boolean
     **/
    public static function checkVerificationData($verification, $verifiableType) {

        if ($verification->user_id != auth()->id()) {
            throw ValidationException::withMessages(['error' => 'Unauthorized action']);
        }

        if ($verifiableType != $verification->verifiable_type) {

            throw ValidationException::withMessages(['error' => 'Invalid session data']);
        }

        if (!$verification->used_at && checkIsOtpEnable()) {
            throw ValidationException::withMessages(['error' => 'The user is not verified by a valid OTP code for this action']);
        }

        return true;
    }
}
