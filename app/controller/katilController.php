<?php

if (post('submit-register')) {
    $username = ucwords(post('user_name'));
    $usernick = strtolower(post('user_nick'));
    $email = post('user_email');
    $password = post('user_password');
    $password_again = post('user_password_again');
    if (!$username) {
        $error_register = "Lütfen adınızı ve soyadınızı giriniz.";
    } elseif (!$usernick) {
        $error_register = "Lütfen kullanıcı adınızı giriniz.";
    } elseif (strlen($usernick) > 50) {
        $error_register = "Lütfen kullanıcı adınızı daha kısa giriniz.";
    } elseif (!$email) {
        $error_register = "Lütfen e-posta adresinizi giriniz.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_register = "Lütfen geçerli bir e-posta adresi giriniz.";
    } elseif (!$password || !$password_again) {
        $error_register = "Lütfen şifrenizi giriniz.";
    } elseif ($password != $password_again) {
        $error_register = "Girdiğiniz şifreler birbiriyle uyuşmuyor.";
    } else {
        //nick var mı kontrol et
        $row = User::userExistsNick($usernick);
        if ($row) {
            $error_register = "Bu kullanıcı adı kullanılıyor. Lütfen başka bir tane deneyiniz.";
        } else {
            //email var mı kontrol et
            $row2 = User::userExistsEmail($email);
            if ($row2) {
                $error_register = "Bu e-posta adresi kullanılıyor. Lütfen başka bir tane deneyiniz.";
            } else {
                //üyeyi ekle
                $result = User::Register([
                    'usernick' => permalink($usernick),
                    'username' => $username,
                    'url' => permalink($usernick),
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'token' => md5(uniqid()),
                    'rank' => 3,
                    'user_activation' => 0,
                    'login_date' => date('Y-m-d H:i:s'),
                    'mail_date' => date('Y-m-d H:i:s'),
                ]);
                if ($result) {
                    $row3 = User::UserInfo($usernick);
                    $send_mail = User::SendMail($row3['user_name'], $row3['user_email'], $row3['user_token']);
                    if ($send_mail){
                        $success_sign_up = "Üyeliğiniz başarı ile oluşturuldu. Lütfen e-posta adresinizi onaylayınız.";
                    } else {
                        $error_register = "Üyeliğiniz oluşturuldu fakat e-posta adresinize aktivasyon e-postası gönderemedik. Lütfen iletişime geçiniz.";
                    }
                } else {
                    $error_register = "Bir sorun oluştu. Lütfen tekrar deneyiniz.";
                }
            }
        }
    }
}

require view('register');