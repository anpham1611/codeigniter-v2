<?php

class Lfb
{
    public function __construct()
    {
        require __DIR__ . '/facebook/autoload.php';
    }

    public function login_fb()
    {
        $fb = new Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET,
            'default_graph_version' => FB_VERSION,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['public_profile, user_friends, email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url() . 'fb/login', $permissions);

        return '<a href="' . $loginUrl . '">Đăng nhập với Facebook</a>';
    }

    public function finish_login()
    {
        $fb = new Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET,
            'default_graph_version' => FB_VERSION,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
//            echo 'Graph returned an error: ' . $e->getMessage();
//            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
//            echo 'Facebook SDK returned an error: ' . $e->getMessage();
//            exit;
        }

        $user = null;
        if (!isset($accessToken)) {
//            if ($helper->getError()) {
//                header('HTTP/1.0 401 Unauthorized');
//                echo "Error: " . $helper->getError() . "\n";
//                echo "Error Code: " . $helper->getErrorCode() . "\n";
//                echo "Error Reason: " . $helper->getErrorReason() . "\n";
//                echo "Error Description: " . $helper->getErrorDescription() . "\n";
//            } else {
//                header('HTTP/1.0 400 Bad Request');
//                echo 'Bad request';
//            }
//            exit;

        } else {

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,email,first_name,middle_name,last_name,link,birthday,location,hometown', $accessToken->getValue(), null, FB_VERSION);
                $user = $response->getGraphUser();

            } catch (Facebook\Exceptions\FacebookResponseException $e) {
//                echo 'Graph returned an error: ' . $e->getMessage();
//                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
//                echo 'Facebook SDK returned an error: ' . $e->getMessage();
//                exit;
            }
        }

//        var_dump($user);
        return $user;
    }
}