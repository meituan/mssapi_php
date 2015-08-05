<?php
require __DIR__ . '/artifacts/aws.phar';

$client = Aws\S3\S3Client::factory([
    'endpoint' => 'http://mtmss.com',
    'ssl.certificate_authority' => false,
    'key'    => '*',
    'secret' => '*',
]);

echo 'Version=' . Aws\Common\Aws::VERSION;

# $client->createBucket(array('Bucket' => 'mybucket-php1'));

