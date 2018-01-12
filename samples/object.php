<?php

require '../build/artifacts/mss.phar';
use Mss\S3\Enum\CannedAcl;

$accessKeyId = "***********";
$accessKeySecret = "***********";
$endpoint = "http://mtmss.com";
$bucket = "form";
$object = "php_sdk_object";
$content = "Hello MSS!";
$LocalFile = "./localfile";

$mssClient = Mss\S3\S3Client::factory([
        'endpoint' => $endpoint,
        'image_endpoint' => 'http://image.mtmss.com', # 可选的
        'key'    => $accessKeyId,
        'secret' => $accessKeySecret,]);


// 简单上传变量内容
$mssClient->putObject(array(
	'Bucket' => $bucket,
	'Key' => $object,
	'Body' => $content));

// 上传本地文件
$result = $mssClient->putObject(array(
	'Bucket' => $bucket,
	'Key'=>$object,
	'SourceFile' => $LocalFile));

echo "etag=" . $result['ETag'] . "\n";
echo "x-amz-request-id=" . $result['RequestId'] . "\n";

// 下载object到本地变量
$result = $mssClient->getObject(array(
	'Bucket' => $bucket,
	'Key' => $object));

$getContent = $result['Body'];
echo "$object content=" . "$getContent" . "\n";

// 下载object到本地文件
$result = $mssClient->getObject(array(
	'Bucket' => $bucket,
	'Key' => $object,
	'SaveAs' => './' . $object . ".copy"));

// 判断object是否存在
$isExist = $mssClient->doesObjectExist($bucket, $object);
if ($isExist) {
	echo "$bucket $object exist\n";
} else {
	echo "$bucket $object not exist\n";
}


// 删除object
try {
	$result = $mssClient->deleteObject(array(
		'Bucket' => $bucket,
		'Key' => $object));
} catch (Mss\S3\Exception\NoSuchKeyException $eNoSuchKey) {
	echo "no such key, $eNoSuchKey\n";
} catch (Exception $e) {
	echo "other exception $e\n";
}


// 拷贝文件
$mssClient->copyObject(array(
	'Bucket' => $bucket,
	'Key' => $object,
	'CopySource' => $bucket . '/' . "pci.cc",
	'MetadataDirective' => 'COPY'));

// 修改文件元信息
$mssClient->copyObject(array(
	'Bucket' => $bucket,
	'Key' => $object,
	'CopySource' => $bucket . '/' . $object,
	'MetadataDirective' => 'REPLACE',
	'Content-Type' => "application/yy",
	'Content-Disposition' => 'attachment; filename="new.d"'));

