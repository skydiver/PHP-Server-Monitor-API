<?php

    trait UsersTrait {

        /**
        * Login using Email and Password
        * @param type $email
        * @param type $app_password
        * @return boolean
        */
        public function loginWithPostData($email, $app_password) {

            $user = User::where('email', $email)->first();

            if($user) {
                if(password_verify($app_password, $user->password)) {
                    return $user;
                }
            }

            return false;

        }

        /**
         * Update iPhone Device Token and phone type in the Database
         * @param type $email
         * @param type $devicetoken
         * @param type $phone_type
         * @return boolean
         */
        public function iphoneDeviceToken($email, $devicetoken, $phone_type) {
            return User::where('email', $email)->update([
                'pushover_device' => $phone_type,
                'pushover_key'    => $devicetoken,
            ]);
        }        

    }

?>