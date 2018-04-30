<?php

    // kode ini berfungsi untuk membuat return response dan merubahnya menjadi
    // bentuk json

    function error($code, $name, $message = null, $details = null){
        $allowed_http_status_code = [200, 201, 202, 400, 401, 403, 422, 500, 503];
        $error = [
            "status_code" => $code,
            "name" => $name,
        ];

        if ($message){
            $error["message"] = $message;
        }

        if($details){
            $error["data"] = $details;
        }

        if(!in_array($code, $allowed_http_status_code)){
            $code = 400;
        }

        header("HTTP/1.1 " . $code . " Internal Server Error");
        echo json_encode($error, $code);
        die();
    }

    function successResponse($code, $data, $message, $name) {
        $success = [
            "status_code" => $code,
        ];

        if($name) {
            $success["name"] = $name;
        }

        if($message) {
            $success["message"] = $message;
        }

        if($data) {
            $success["data"] = $data;
        }

        echo json_encode($success, $code);
        die();
    }

    function errorResponse($code = 500, $name = 'InternalServerError',  $message = 'Internal Server Error') {
        header("HTTP/1.1 500 Internal Server Error");
        echo error($code, $name, $message);
    }