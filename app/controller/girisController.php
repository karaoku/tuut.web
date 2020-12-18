<?php

if (post('submit-login')) {
    $usernick = post('user_nick');
    $password = post('user_password');
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
                    header('Location:' .  site_url());
                } else {
                    User::nonLogin($user_data);
                    $error_login = "E-posta adresinizi onaylamamışsınız, lütfen kontrol edin.";
                }
            } else {
                $error_login = "Şifreniz hatalı, lütfen kontrol edin.";
            }
        } else {
            $error_login = "Böyle bir kullanıcı sistemde kayıtlı değil. Lütfen kontrol edin.";
        }
    }
}

require view('login');