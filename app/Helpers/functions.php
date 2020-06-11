<?php

/**
 * Read config files and return config
 * @param $file
 * @return array
 */
function config($file)
{
    /** @var array $array */
    $array = include "./config/{$file}.php";
    return $array;
}


function checkValidNumber($number)
{
    $data = ['status' => false];
    $number = faToEn($number);
    if (is_numeric($number)) {

        if (strlen($number) < 15) {
            // remove + from start
            if (startsWith($number, '+')) {
                $number = ltrim($number, "+");
            }

            // remove 98 from start
            if (startsWith($number, '98')) {
                $number = substr($number, 2);
            }
            // remove all zero from start
            $number = ltrim($number, 0);

            $data['phone_number'] = $number;
            $data['status'] = true;
        } else {
            $data['message'] = 'شماره موبایل معتبر نیست.';
        }

    } else {
        $data['message'] = 'شماره خود را به درستی وارد کنید.';
    }
    return $data;
}

function checkIsNumber($number)
{
    $data = ['status' => false];
    $number = faToEn($number);
    if (is_numeric($number)) {

        $data['number'] = $number;
        $data['status'] = true;
    } else {
        $data['message'] = 'کد اشتباه است.';
    }
    return $data;
}

function send_activation_sms($user, $phone_number, $activation_code)
{
    $result = ['status' => false];
    $date = new \DateTime();
    $date->modify('-2 minutes');
    $formatted_date = $date->format('Y-m-d H:i:s');
    //if (strtotime($user->activation_date) <= strtotime($formatted_date)) {
    if ($user->activation_count == 0) {
        try {
            $api_key = '352B6670324A2F4F6F394556523679343632487334673D3D';
            $api_token = 'mahant';
            $api = new \Kavenegar\KavenegarApi($api_key);
            if ($api->VerifyLookup($phone_number, $activation_code, $activation_code, $activation_code, $api_token)) {
                $result['status'] = true;
            } else {
                $result['status'] = false;
                $result['message'] = 'در ارسال پیامک مشکلی به وجود اومده، لطفا لحظاتی دیگه دوباره امتحان کن.';
            }
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            $result['status'] = false;
            $result['message'] = 'در ارسال پیامک مشکلی به وجود اومده، لطفا لحظاتی دیگه دوباره امتحان کن.';
        }
    } else {
        $result['status'] = false;
        $result['message'] = 'دسترسی شما محدود شده.🔒';
    }
    return $result;
}

function checkValidNationalCode($code)
{
    $data = ['status' => false];
    $code = faToEn($code);
    $code = str_replace("-","",$code);
    if (is_numeric($code)) {
        if (strlen((string)$code) == 10) {
            $data['national_code'] = $code;
            $data['status'] = true;
        } else {
            $data['message'] = 'کد ملی باید ۱۰ رقمی باشه';
        }
    } else {
        $data['message'] = 'کدملیتو به درستی وارد کن.';
    }
    return $data;
}

function faToEn($string)
{
    return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
}

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function randomDigit($digits)
{
    return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}