# MSS(Meituan Storage Service) SDK for PHP

This is MSS SDK for PHP.

## Introduction

### MSS服务介绍
	美团云存储服务（Meituan Storage Service, 简称MSS)，是美团云对外提供的云存储服务，其具备高可靠，安全，低成本等特性，并且其API兼容S3。MSS适合存放非结构化的数据，比如图片，视频，文档，备份等。

### MSS基本概念介绍
	MSS的API兼容S3, 其基本概念也和S3相同，主要包括Object, Bucket, Access Key, Secret Key等。
	Object对应一个文件，包括数据和元数据两部分。元数据以key-value的形式构成，它包含一些默认的元数据信息，比如Content-Type, Etag等，用户也可以自定义元数据。
	Bucket是object的容器，每个object都必须包含在一个bucket中。用户可以创建任意多个bucket。
	Access Key和Secret Key: 用户注册MSS时，系统会给用户分配一对Access Key和Secret Key, 用于标识用户，用户在使用API使用MSS服务时，需要使用这两个Key。请在美团云管理控制台查询AccessKey和SecretKey。

### MSS访问域名
mtmss.com

## Installation

	# Requirement
	PHP >= 5.5.0

	# Build the phar and zip, under build/artifacts/
	curl http://getcomposer.org/installer | php
	php composer.phar install
	make package

## Quick Start

```php	
	<?php
	require '/path/to/aws.phar';
	# e.g
	# require __DIR__ . '/mssapi_php/build/artifacts/aws.phar';

	# connect
	$s3 = Aws\S3\S3Client::factory([
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
		'SourceFile' => 'file'
	));

	# delete object
	$s3->deleteObject(array('Bucket' => $bucketName, 'Key' => $key1));
	$s3->deleteObject(array('Bucket' => $bucketName, 'Key' => $key2));

	# delete bucket
	$s3->deleteBucket(array('Bucket' => $bucketName));
```
