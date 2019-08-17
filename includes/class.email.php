<?php

require 'aws.phar';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

Class Email {
    protected $aws = ['key' => null, 'secret' => null, 'region' => null];

    /**
     * From
     *
     * @var string
     */
    protected $_from = null;

    /**
     * Recipients
     *
     * @var array
     */
    protected $_recipients = [];

    /**
     * Message
     *
     * @var string
     */
    protected $_message = null;

    /**
     * Subject
     *
     * @var string
     */
    protected $_subject = null;

    /**
     * Constructor
     * @param array $credentials
     */
    public function __construct($credentials = []) {
        $this->aws = $credentials;
    }

    /**
     * From
     *
     * @param string
     */
    public function from($from = null) {
        $this->_from = $from;
    }

    /**
     * Recipients
     *
     * @param array
     */
    public function recipients($recipients = []) {
        $this->_recipients = $recipients;
    }

    /**
     * Subject
     *
     * @param string
     */
    public function subject($subject = null) {
        $this->_subject = $subject;
    }

    /**
     * Message
     *
     * @param string
     */
    public function message($message = null) {
        $this->_message = $message;
    }

    public function send() {
        if (empty($this->_to)) {
            // Throw / return an error
        }

        if (empty($this->_message)) {
            // Throw / return an error
        }

        $client = new SesClient([
            'profile' => 'default',
            'version' => '2010-12-01',
            'region'  => $this->aws['region']
        ]);

        $charset = 'UTF-8';

        try {
            $result = $client->sendEmail([
                'Destination' => [
                    'ToAddresses' => $this->_recipients,
                ],
                'ReplyToAddresses' => [$this->_from],
                'Source' => $this->_from,
                'Message' => [
                    'Body' => [
                        'Html' => [
                            'Charset' => $charset,
                            'Data' => $this->_message
                        ]
                    ],
                    'Subject' => [
                        'Charset' => $charset,
                        'Data' => $this->_subject
                    ],
                ]
            ]);

            if ($message_id = $result['MessageId']) {
                return true;
            } else {
                return false;
            }
        } catch (AwsException $e) {
            return false;
        }
    }
}