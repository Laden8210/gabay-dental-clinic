<?php
class SMS{

    public function sendSMS($phoneNumber, $message)
    {

        $url = 'https://nasa-ph.com/api/send-sms';
        $data = [
            'phone_number' => $phoneNumber,
            'message' => $message,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

}


?>