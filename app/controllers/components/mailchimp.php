<?php

class MailchimpComponent extends Object {

   function add_subscriber($email = null, $firstname = null, $lastname = null, $gender = null, $language = 'en', $status = 'subscribed') 
   {
        // https://www.codexworld.com/add-subscriber-to-list-mailchimp-api-php/ v3.0

        if ($gender == 'f') 
            $gender = 'female';
        else if ($gender == 'm')
            $gender = 'male';
        else
            $gender = 'other';
        
        // MailChimp API credentials
        $apiKey = MAILCHIMP_APIKEY;

        if ( $language == 'deu' ) {
            $listID = '9e6182eb6e';
        } else {
            $listID = 'b99533c86e';
        }
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
            
        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => $status,
            'merge_fields'  => [
                'FNAME'     => $firstname,
                'LNAME'     => $lastname,
                'GENDER'    => $gender,
                'LANGUAGE'  => $language
            ]
        ]);
            
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
            
        // store the status message based on response code
        if ($httpCode == 200) {
            // success
        } else {
            switch ($httpCode) {
                case 214:
                    // already subscribed
                    break;
                default:
                    // some error
                    break;
            }
        }
    }

}

?>