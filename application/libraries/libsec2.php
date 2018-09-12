<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include '/../third_party/aws-sdk/vendor/autoload.php';

use Aws\Ec2\Ec2Client;

class libsec2 {

    private static $CI;
    public $client;

    public function __construct() {
        if (empty(self::$CI))
            self::$CI = &get_instance();

        $this->client = Ec2Client::factory(array(
                    'credentials' => array(
                        'key' => self::$CI->config->item('aws_ec2_access_key'), 'secret' => self::$CI->config->item('aws_ec2_secret_key')
                    ), 'region' => 'us-east-1'
        ));
    }

    public function createSnapshot($volumeId, $description) {
        $result = $this->client->createSnapshot(array(
            'DryRun' => false, 'VolumeId' => $volumeId, 'Description' => $description, 'Name' => $description
        ));
        return $result;
    }

    public function deleteSnapshot($snapshot_id) {
        $result = $this->client->deleteSnapshot(array(
            'DryRun' => false, 'SnapshotId' => $snapshot_id
        ));

        return $result;
    }

}
