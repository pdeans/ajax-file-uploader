<?php

header('Content-type: application/json');

$upload = [];
$allowed = ['jpg', 'png', 'gif', 'txt', 'pdf', 'doc', 'docx', 'rtf'];

$succeeded = [];
$failed = [];

if(!empty($_FILES['file'])) {
    foreach($_FILES['file']['name'] as $key => $name) {
        if($_FILES['file']['error'][$key] === 0) {
            $temp = $_FILES['file']['tmp_name'][$key];

            $ext = explode('.', $name);
            $ext = strtolower(end($ext));

            $file = md5_file($temp) . time() . '.' . $ext;

            if(in_array($ext, $allowed) === true && move_uploaded_file($temp, "uploads/{$file}") === true) {
                $succeeded[] = array(
                    'name'  => $name,
                    'file'  => $file
                );
            } else {
                $failed[] = array(
                    'name' => $name
                );
            }
        }
    }
    if(!empty($_POST['ajax'])) {
        echo json_encode(array(
            'succeeded' => $succeeded,
            'failed'    => $failed
        ));
    }
}





