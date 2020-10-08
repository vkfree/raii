<?php

/**
 * fire base notification
 */
class Firebase {

    // sending push message to single user by firebase reg id
    public function send($to, $message,$notification) {
        $fields = array(
            'to' => $to,
            'notification' => $notification,
             'data' => $message,
            "priority"  => "high"
        );
        return $this->sendPushNotification($fields);
        
    }
    
    
    // sending push message to single IOS user by firebase reg id
    public function sendToios($to, $message) {
        $fields = array(
            'to' => $to,
            'sound' => 'default',            
            'notification' => $message,
            // 'notification' => $message,
        );
        return $this->sendPushNotification($fields);
    }
    // Sending message to a topic by topic name
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
            // 'notification' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
      
            // 'notification' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
        
       

        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            // 'Authorization: key=AAAAe5iTBrw:APA91bGew-koSs3_Z3PxXXYtdYuATdypM0_H8Qkobk2rKuOOn0U56kN0tu8jp92FIw7imePnMLGirrYrS6php2ZtpJQn0R-e_P1u7D_FkLkTo3sVTEFAoZncC1jacXrjmERxLqzFjZOZ',
            // 'Authorization: key=AAAA-bWepgA:APA91bGi8x86qR-3y2KnhyFBq7MDRdKwKl4DkkO5kX6uFQdzhR2fx0auFxV_GZlP2YUaKdPkSQHWdgtTF2EAkChwZLHw-whc16u0fGnXnEPmbz2BExevgVjWJTKJUR5YAno13PaShdD0',
            'Authorization: key=AAAA6E_hGJ0:APA91bEV1jD2OhWIu9NVGzWVb1FiKrjAtzH-x3vV9fZXNHu43YrQ8H7lN5JaGu3SkNkVjMMPsY-X7GYbGdtHZp38lOeItCgNqahgpfS4usD_aKPkjwqjIikuQ5sXzlF_fjzPeutfe3TF700w6c3UFq9TxYfvs1kv1w',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }
}
?>