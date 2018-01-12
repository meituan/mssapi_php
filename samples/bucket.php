<?php

require '../build/artifacts/mss.phar';
use Mss\S3\Enum\CannedAcl;

$accessKeyId = "***********";
$accessKeySecret = "***********";
$endpoint = "http://mtmss.com";
$bucket = "example";

$mssClient = Mss\S3\S3Client::factory([
        'endpoint' => $endpoint,
        'image_endpoint' => 'http://image.mtmss.com', # 可选的
        'key'    => $accessKeyId,
        'secret' => $accessKeySecret,]);


// 创建bucket
$mssClient->createBucket(array(
	'Bucket' => $bucket,
	'ACL' => CannedAcl::PRIVATE_ACCESS));

// 判断bucket是否存在
$isExist = $mssClient->doesBucketExist($bucket);
if ($isExist) {
	echo "Bucket $bucket exist";
} else {
	echo "Bucket $bucket not exist";
}
        
// 获取bucket列表
$iteratorBuckets = $mssClient->getIterator('ListBuckets', array());

foreach ($iteratorBuckets as $ibucket) {
	echo $ibucket['Name'] . "\n";
}

// 设置bucket的ACL
$mssClient->PutBucketAcl(array(
	'Bucket' => $bucket,
	'ACL' => CannedAcl::PUBLIC_READ));

// 获取bucket的ACL
$acl = $mssClient->GetBucketAcl(array('Bucket' => $bucket));
echo $acl;

