<?php

class LoginController
{
    public static function authorize(object $obj): Response
    {
        try {
            $sql = "select id,name,username,phonenumber,remark from users where username='$obj->username' and password='$obj->password'";
            $data = PDODBController::query($sql);

            if ($data) {
                return getRes(JwtEncode($data), Message::loginOk, Status::success);
            } else {
                return getRes([], Message::wrongUserOrPass, Status::success);
            }
        } catch (Exception $e) {
            return getRes([], $e->getMessage(), Status::success);
        }
    }
}
