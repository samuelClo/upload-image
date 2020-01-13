<?php

use App\Models\FileUploader;

if (!empty($_FILES)) {
    $uploader = new FileUploader;
    $uploader->setFileData();
    $uploader->setStoreName();
    $uploader->upload();
}