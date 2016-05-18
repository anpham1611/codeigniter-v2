<?php

class Lses
{
    public function __construct()
    {
        require __DIR__ . '/aws/aws.phar';
    }

    /**
     * @param $name
     * @param $from
     * @param $toArr: array('user1@apptitude.sg', 'user2@apptitude.sg')
     * @param $ccArr: array('user1@apptitude.sg', 'user2@apptitude.sg')
     * @param $bccArr: array('user1@apptitude.sg', 'user2@apptitude.sg')
     * @param $subject
     * @param $body
     * @return bool
     */
    public function sendEmail($name, $from, $toArr, $ccArr, $bccArr, $subject, $body)
    {
        try {

            $toArr = array_map('trim', $toArr);
            $ccArr = array_map('trim', $ccArr);
            $bccArr = array_map('trim', $bccArr);

            // Create a new Amazon SES client
            $sesClient = Aws\Ses\SesClient::factory(array(
                'key'    => AWS_ACCESS_KEY,
                'secret' => AWS_SECRET_KEY,
                'region' => 'us-east-1'
            ));

            $result = $sesClient->sendEmail(array(
                // Source is required
                'Source' => utf8_encode($name) . ' <'.$from.'>',
                // Destination is required
                'Destination' => array(
                    'ToAddresses' => $toArr,
                    'CcAddresses' => $ccArr,
                    'BccAddresses' => $bccArr,
                ),
                // Message is required
                'Message' => array(
                    // Subject is required
                    'Subject' => array(
                        // Data is required
                        'Data' => $subject,
                        'Charset' => 'UTF-8',
                    ),
                    // Body is required
                    'Body' => array(
                        'Text' => array(
                            // Data is required
                            'Data' => '',
                            'Charset' => 'UTF-8',
                        ),
                        'Html' => array(
                            // Data is required
                            'Data' => $body,
                            'Charset' => 'UTF-8',
                        ),
                    ),
                ),
                'ReplyToAddresses' => array(),
                'ReturnPath' => $from,
            ));
//
//            echo '<pre>';
//            print_r($result);
//            echo '</pre>';

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
//            echo "<strong>Error:</strong> " . $e->getMessage() . "<br/>";
            $log = ''
                . 'Name: ' . $name . PHP_EOL
                . 'From: ' . $from . PHP_EOL
                . 'To: ' . implode(',', $toArr) . PHP_EOL
                . 'Subject: ' . $subject . PHP_EOL
                . 'Message: ' . $e->getMessage() . PHP_EOL;
            file_put_contents('./assets/logs/send_email_ses'.date("__Y_m_d_H_i_s").'.txt', $log, FILE_APPEND);
        }

        return false;
    }
}