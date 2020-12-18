<?php

$forget_password_code = route(1);

if (!$forget_password_code) {
    header('Location:' . site_url('404'));
    exit;
} else {
    $row = $db->from('users')
        ->where('user_token', $forget_password_code)
        ->first();
    if (!$row){
        header('Location:' . site_url('404'));
        exit;
    } else {
        if (post('submit_set_password')){
            $set_password = post('set_password');
            $set_password_again = post('set_password_again');

            if ($set_password =! $set_password_again){
                $error_set_password = "Girdiğiniz şifreler birbiriyle uyuşmuyor.";
            } else {
                $query2 = $db->update('users')
                    ->where('user_token', $forget_password_code)
                    ->set([
                        'user_password' => password_hash($set_password_again, PASSWORD_DEFAULT),
                        'user_token' => md5(uniqid()),
                    ]);
                if ($query2){
                    $success_set_password = "Şifreniz değiştirildi. Yönlendiriliyorsunuz...";
                    header('Refresh:2;' . site_url());
                } else {
                    $error_set_password = "Şifreniz değiştirilemedi. Lütfen daha sonra tekrar deneyiniz.";
                }
            }
        }
    }
}

require view('set-password');
