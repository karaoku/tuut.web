<?php

if (post('submit-sign-up')) {
    $username = post('username');
    $usernick = post('usernick');
    $email = post('email');
    $profile_img = post('profile_img');
    $password = post('password');
    $password_again = post('password_again');
    if (!$username) {
        $error_sign_up = "Lütfen adınızı ve soyadınızı giriniz.";
    } elseif (!$usernick) {
        $error_sign_up = "Lütfen kullanıcı adınızı giriniz.";
    } elseif (!$email) {
        $error_sign_up = "Lütfen e-posta adresinizi giriniz.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_sign_up = "Lütfen geçerli bir e-posta adresi giriniz.";
    } elseif (!$password || !$password_again) {
        $error_sign_up = "Lütfen şifrenizi giriniz.";
    } elseif ($password != $password_again) {
        $error_sign_up = "Girdiğiniz şifreler birbiriyle uyuşmuyor.";
    } else {
        //nick var mı kontrol et
        $row = User::userExistsNick($usernick);
        if ($row) {
            $error_sign_up = "Bu kullanıcı adı kullanılıyor. Lütfen başka bir tane deneyiniz.";
        } else {
            //email var mı kontrol et
            $row2 = User::userExistsEmail($email);
            if ($row2) {
                $error_sign_up = "Bu e-posta adresi kullanılıyor. Lütfen başka bir tane deneyiniz.";
            } else {
                //üyeyi ekle
                $result = User::Register([
                    'usernick' => $usernick,
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
                        $error_sign_up = "Üyeliğiniz oluşturuldu fakat e-posta adresinize aktivasyon e-postası gönderemedik. Lütfen iletişime geçiniz.";
                    }
                } else {
                    $error_sign_up = "Bir sorun oluştu. Lütfen tekrar deneyiniz.";
                }
            }
        }
    }
}
if (post('submit-login')) {
    $usernick = post('usernick');
    $password = post('password');
    if (!$usernick) {
        $error_login = "Lütfen kullanıcı adınızı giriniz.";
    } elseif (!$password) {
        $error_login = "Lütfen şifrenizi giriniz.";
    } else {
        //üye var mı kontrol et
        $row = User::userExistsNick($usernick);
        if ($row) {
            //parola kontrolü yap
            $password_verify = password_verify($password, $row['user_password']);
            if ($password_verify) {
                $user_activation = $row['user_activation'];
                $user_data = $db->from('users')
                    ->where('user_id' , $row['user_id'])
                    ->first();
                if ($row['user_activation']){
                    //kullanıcı giriş zamanı veritabanına eklendi
                    $db->update('users')
                        ->where('user_id' , $row['user_id'] )
                        ->set([
                            'user_login_date' => date('Y-m-d H:i:s')
                        ]);
                    //kullanıcı giriş yaptı
                    User::Login($user_data);
                    header('Location:' . site_url());
                } else {
                    User::nonLogin($user_data);
                    $error_activation = "E-posta adresinizi onaylamamışsınız, lütfen kontrol edin.";
                }
            } else {
                $error_login = "Şifreniz hatalı, lütfen kontrol edin.";
            }
        } else {
            $error_login = "Böyle bir kullanıcı sistemde kayıtlı değil. Lütfen kontrol edin.";
        }
    }
}

if (post('forget-password')){
    $forget_email = post('forget-pass-email');
    if (!$forget_email){
        $error_forget_pass = "Lütfen e-posta adresinizi giriniz.";
    } else {
        $user = $db->from('users')
            ->where('user_email' , $forget_email)
            ->first();
        if (!$user){
            $error_forget_pass = "Sistemde böyle bir e-posta bulunmuyor.";
        } else {
            $date = strtotime("-15 minutes");
            $mail_date = date('Y-m-d H:i:s',$date);
            if ($user['user_mail_date'] <= $mail_date){
                $send = User::SendForgetPassMail($user);
                $row2 = $db->update('users')
                    ->where('user_email' , $forget_email)
                    ->set([
                        'user_mail_date' => date('Y-m-d H:i:s'),
                    ]);
                if ($send){
                    $success_forget_pass = "E-posta adresinize şifre sıfırlama bağlantısı gönderildi.";
                } else {
                    $error_forget_pass = "Bir sorun oluştu. E-posta'yı gönderemedik.";
                }
            } else {
                $error_forget_pass = "Tekrar sıfırlama e-posta'sı almak için 15 dakika beklemeniz gerekiyor.";
            }
        }
    }
}
