<?php

require '../build/artifacts/mss.phar';
use Mss\S3\Enum\CannedAcl;

$accessKeyId = "***********";
$accessKeySecret = "***********";
$endpoint = "http://mtmss.com";
$bucket = "form";

$mssClient = Mss\S3\S3Client::factory([
        'endpoint' => $endpoint,
        'image_endpoint' => 'http://image.mtmss.com', # 可选的
        'key'    => $accessKeyId,
        'secret' => $accessKeySecret,]);

// 设置lifecycle规则
$command = $mssClient->getCommand('PutBucketLifecycle', array(
	'Bucket' => $bucket,
	'Rules' => array(
            array(
                'ID' => 'foo-rule',
                'Status' => 'Enabled',
		'Prefix' => 'a',
                'Expiration' => array(
                    'Days' => 30
		)
            )
         )));
$result = $command->execute();
echo $result;

// 获取lifecycle规则
$result = $mssClient->getBucketLifecycle(array('Bucket'=>$bucket));
echo $result;

// 删除lifecycle规则
$result = $mssClient->deleteBucketLifecycle(array('Bucket'=>$bucket));
echo $result;
