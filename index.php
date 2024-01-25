<?php
//BY：云猫
//QQ：3522934828
//blog：lwcat.cn
// 引入阿里云 OSS SDK
 require_once 'oss-sdk-php.phar';

use OSS\OssClient;
use OSS\Core\OssException;

// 替换为你的阿里云 OSS 访问凭据
$accessKeyId = '';
$accessKeySecret = '';
$endpoint = ''; // OSS外网节点或内网节点，例如：oss-cn-hangzhou.aliyuncs.com

// 替换为你的 OSS Bucket 名称
$bucketName = '';

// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // 初始化OSS客户端
    try {
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    } catch (OssException $e) {
        die('OSS客户端初始化失败');
    }

    // 生成唯一文件名
    $object = 'uploads/' . uniqid() . '-' . $file['name'];

    // 上传文件到OSS
    try {
        $ossClient->uploadFile($bucketName, $object, $file['tmp_name']);
    } catch (OssException $e) {
        die('文件上传失败');
    }

    echo '文件上传成功';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文件上传到阿里云 OSS</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="file">选择文件：</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">上传文件</button>
    </form>
</body>
</html>