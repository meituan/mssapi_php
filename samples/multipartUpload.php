<?php

require '../build/artifacts/mss.phar';
use Mss\S3\Enum\CannedAcl;

$accessKeyId = "***********";
$accessKeySecret = "***********";
$endpoint = "http://mtmss.com";
$bucket = "form";
$object = "php_sdk_object";
$content = "Hello MSS!";
$LocalBigFile = "./localBigFile";

$mssClient = Mss\S3\S3Client::factory([
        'endpoint' => $endpoint,
        'image_endpoint' => 'http://image.mtmss.com', # 可选的
        'key'    => $accessKeyId,
        'secret' => $accessKeySecret,]);

// 分片上传本地文件
$mssClient->upload($bucket, $object, fopen($LocalBigFile, 'r'), 'public-read', array());

// 列出当前未完成的分片上传
$iterator = $mssClient->getIterator('ListMultipartUploads', array(
	'Bucket'    => $bucket,
	'Delimiter' => '/'
	), array());
        
$actualUploads = array();

foreach ($iterator as $upload) {
	if (isset($upload['Key'])) {
		$actualUploads[] = "$upload[Key]|$upload[UploadId]";
	} else {
		$actualUploads[] = $upload['Prefix'];
	}
}

foreach ($actualUploads as $upload) {
	echo "$upload\n";
}
*/

// 通过原始接口分片上传
$result = $mssClient->createMultipartUpload(array(
            'Bucket'   => $bucket,
            'Key'      => $object));
$uploadId = $result['UploadId'];

$file = fopen($LocalBigFile, 'r');
$parts = array();
$partNumber = 1;
while (!feof($file)) {
    $result = $mssClient->uploadPart(array(
        'Bucket'     => $bucket,
        'Key'        => $object,
        'UploadId'   => $uploadId,
        'PartNumber' => $partNumber,
        'Body'       => fread($file, 5 * 1024 * 1024),
    ));
    $parts[] = array(
        'PartNumber' => $partNumber++,
        'ETag'       => $result['ETag'],
    );
}

$result = $mssClient->completeMultipartUpload(array(
    'Bucket'   => $bucket,
    'Key'      => $object,
    'UploadId' => $uploadId,
    'Parts'    => $parts,
));
$url = $result['Location'];

fclose($file);

// 查看已上传的分片
$result = $mssClient->listParts(array(
            'Bucket'   => $bucket,
            'Key'      => $object,
            'UploadId' => $uploadId));

echo $result;
