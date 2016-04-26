<?php
require __DIR__ . '/artifacts/mss.phar';

$client = Mss\S3\S3Client::factory([
    'endpoint' => 'http://mtmss.com',
    'ssl.certificate_authority' => false,
    'key'    => '*',
    'secret' => '*',
]);

echo 'Version=' . Mss\Common\Mss::VERSION;

# $client->createBucket(array('Bucket' => 'mybucket-php1'));

