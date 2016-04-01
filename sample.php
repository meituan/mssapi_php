<?php
require './build/artifacts/mss.phar';
# e.g
# require __DIR__ . '/mssapi_php/build/artifacts/aws.phar';

# connect
$s3 = Mss\S3\S3Client::factory([
    'endpoint' => 'http://mtmss.com',
    'key'    => '*',
    'secret' => '*',
]);

$bucketName = 'testphp';
$localFile = 'file';

# create bucket
$s3->createBucket(array('Bucket' => $bucketName));

# list buckets
echo "S3::listBuckets(): ".print_r($s3->listBuckets(), 1)."\n";

# get bucket
$contents = $s3->getBucket(array('Bucket' => $bucketName));

# put object
# make sure bucket exist
$key1 = 'file1';
$s3->putObject(array(
    'Bucket' => $bucketName,
    'Key' => $key1,
    'Body' => 'hello'
));

# put object, upload local file
$key2 = 'file2';
$s3->putObject(array(
    'Bucket' => $bucketName,
    'Key' => $key2,
    'SourceFile' => 'README.md'
));

# delete object
$s3->deleteObject(array('Bucket' => $bucketName, 'Key' => $key1));
$s3->deleteObject(array('Bucket' => $bucketName, 'Key' => $key2));

# delete bucket
$s3->deleteBucket(array('Bucket' => $bucketName));