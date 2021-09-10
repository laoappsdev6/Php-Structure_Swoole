<?php
require_once "jwt.service.php";
require_once "name.service.php";
require_once "method.service.php";
require_once "object.service.php";
require_once "message.service.php";
require_once "../config/config.php";
require_once "../controllers/databasePDO.controller.php";

function getRes(array $data, string $message, int $status): Response
{
    $res = new Response();
    $res->object = $_SESSION[Name::obj];
    $res->method = $_SESSION[Name::method];
    $res->data = $data;
    $res->message = $message;
    $res->status = $status;
    return $res;
}
function JsonValidate(string $message): array
{
    return array(Name::message => $message);
}

function Pagination(int $numRow, array $data, int $limit,  int $page): array
{
    $allPage = ceil($numRow / $limit);
    return array(Name::data => $data, Name::page => $page, Name::pageTotal => $allPage, Name::dataTotal => $numRow);
}

function JwtEncode(array $dataUser): array
{
    return array(Name::token => registerToken($dataUser[0]), Name::data => $dataUser[0]);
}

function ValidateJwt(string $token): bool
{
    if (isset($token) && !empty($token)) {
        $userId = checkToken($token);
        if ($userId) {
            $_SESSION[Name::userId] = $userId;
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function base64_to_jpeg(string $base64_string, string $output_file): string
{
    $ifp = fopen($output_file, "wb");
    fwrite($ifp, base64_decode($base64_string));
    fclose($ifp);
    return $output_file;
}

function dateTime(): string
{
    date_default_timezone_set(timeZone);
    return date(dateTimefmt);
}

function formatDate(string $date): string
{
    date_default_timezone_set(timeZone);
    $date = new DateTime($date);
    return $date->format(dateTimefmt);
}

function myFilter($var)
{
    return $var !== null && $var !== "" && !empty($var);
}

function Filter(array $array): array
{
    return array_filter($array, "myFilter");
}
