<?php
require __DIR__ . '/artifacts/aws.phar';

$client = Aws\S3\S3Client::factory([
    'endpoint' => 'http://192.168.12.221:6008',
    'ssl.certificate_authority' => false,
    'key'    => '9b9eff4480f344acb34b81daf3a42e8d',
    'secret' => '10a1854470a642ed889b558ae689872c',
]);

echo 'Version=' . Aws\Common\Aws::VERSION;

$client->createBucket(array('Bucket' => 'mybucket-php1'));

