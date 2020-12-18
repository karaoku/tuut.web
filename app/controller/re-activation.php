<?php

if (!session('user_nick')){
    header('Location:' . site_url('404'));
    exit;
} else {
    $row = $db->from('users')
        ->where('user_nick' , session('user_nick'))
        ->first();

    if ($row['user_activation'] == 0 ){

        $date = strtotime("-15 minutes");
        $mail_date = date('Y-m-d H:i:s',$date);

        if ($row['user_mail_date'] <= $mail_date){

            $send_mail = User::SendMail($row['user_name'], $row['user_email'], $row['user_token']);

            $row2 = $db->update('users')
                ->where('user_nick' , session('user_nick'))
                ->set([
                    'user_mail_date' => date('Y-m-d H:i:s'),
                ]);

            if ($send_mail){
                $error_login = "Aktivasyon kodu tekrar gönderildi.";
            } else {
                $error_login = "Bir sorun oluştu, e-posta'yı gönderemedik.";
            }
        } else {
            $error_login = "Tekrar aktivasyon e-posta'sı almak için 15 dakika beklemeniz gerekiyor.";
        }

    }
}

require controller('index');



