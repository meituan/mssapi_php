<?php

require '../build/artifacts/mss.phar';
use Mss\S3\Enum\CannedAcl;

$accessKeyId = "***********";
$accessKeySecret = "***********";
$endpoint = "http://mtmss.com";
$bucket = "form";

$mssClient = Mss\S3\S3Client::factory([
        'endpoint' => $endpoint,
        'key'    => $accessKeyId,
        'secret' => $accessKeySecret,]);

// 设置cors规则
$command = $mssClient->getCommand('PutBucketCors', array(
	'Bucket' => $bucket,
	'CORSRules' => array(
            array(
               'AllowedMethods' => array('GET'),
               'AllowedOrigins' => array('http://abc.com')
            )
         )));
                
$result = $command->execute();
echo $result;

// 获取lifecycle规则
$result = $mssClient->getBucketCors(array('Bucket'=>$bucket));
echo $result;

// 删除lifecycle规则
$result = $mssClient->deleteBucketCors(array('Bucket'=>$bucket));
echo $result;
