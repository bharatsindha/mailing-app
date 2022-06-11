<?php

namespace App\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\Facade;
use Modules\Mail\Entities\Session;

Class General extends Facade
{
    /**
     * Get the date in format
     *
     * @param $date
     * @return string|null
     */
    public static function dateFormat($date)
    {
        if (is_null($date) || empty($date)) return null;

        return Carbon::parse($date)->toDateString();
    }

    /**
     * Encrypt & Decrypt the string
     *
     * @param $action
     * @param $string
     * @return bool|false|string
     */
    public static function encryptDecrypt($action, $string)
    {
        $output = false;
        $encryptMethod = "AES-256-CBC";
        $secretKey = 'This is my secret key';
        $secretIv = 'This is my secret iv';
        $key = hash('sha256', $secretKey);
        $iv = substr(hash('sha256', $secretIv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
        }

        return $output;
    }

    /**
     * Encode the recipient
     *
     * @param $recipient
     * @return string
     */
    public static function encodeRecipients($recipient)
    {
        $recipientsCharset = 'utf-8';
        if (preg_match("/(.*)<(.*)>/", $recipient, $regs)) {
            $recipient = '=?' . $recipientsCharset . '?B?' . base64_encode($regs[1]) . '?= <' . $regs[2] . '>';
        }
        return $recipient;
    }

    public static function getDraftStatus($status)
    {
        if ($status === Session::YET_TO_START) {
            return 'Not Sent';
        } else if ($status === Session::IN_PROCESS) {
            return 'Sending';
        } else if ($status === Session::COMPLETED) {
            return 'Sent';
        } else {
            return 'Not Sent';
        }
    }
    public static function getDraftBadgeClass($status)
    {
        if ($status === Session::YET_TO_START) {
            return 'primary';
        } else if ($status === Session::IN_PROCESS) {
            return 'info';
        } else if ($status === Session::COMPLETED) {
            return 'success';
        } else {
            return 'primary';
        }
    }

    protected static function getFacadeAccessor()
    {
        return 'general';
    }
}
