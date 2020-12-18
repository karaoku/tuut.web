<?php

$user_url = route(1);

if (!$user_url){
    header('Location:' . site_url('404'));
    exit;
} else {
    $query = $db->from('users')
        ->where('user_url' , $user_url)
        ->first();
    if (!$query){
        header('Location:' . site_url('404'));
        exit;
    }
}

/*$user_comment = $db->from('ratings')
    ->where('user_id' , $query['user_id'])
    ->select('count(rating_id) as total')
    ->total();

$user_like = $db->from('likes')
    ->where('user_id' , $query['user_id'])
    ->select('count(like_id) as total')
    ->total();

if (post('submit_personal')){
    $username = post('user_name');
    $usernick = post('user_nick');
    $email = post('user_email');
    if (!$username) {
        $error_personal = "Lütfen adınızı ve soyadınızı giriniz.";
    } elseif (!$usernick) {
        $error_personal = "Lütfen kullanıcı adınızı giriniz.";
    } elseif (!$email) {
        $error_personal = "Lütfen e-posta adresinizi giriniz.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_personal = "Lütfen geçerli bir e-posta adresi giriniz.";
    } else {
        //nick var mı kontrol et
        $row = User::userExistsNick($usernick);
        if ($row && ($usernick != $query['user_nick'])) {
            $error_personal = "Bu kullanıcı adı kullanılıyor. Lütfen başka bir tane deneyiniz.";
        } else {
            //email var mı kontrol et
            $row2 = User::userExistsEmail($email);
            if ($row2 && ($email != $query['user_email'])) {
                $error_personal = "Bu e-posta adresi kullanılıyor. Lütfen başka bir tane deneyiniz.";
            } else {
                //üyeyi ekle
                $result = $db->update('users')
                    ->where('user_id' , $query['user_id'])
                    ->set([
                        'user_nick' => $usernick,
                        'user_name' => $username,
                        'user_url' => permalink($usernick),
                        'user_email' => $email,
                    ]);
                $user_data = $db->from('users')
                    ->where('user_nick' , $usernick)
                    ->first();
                User::Login($user_data);
                header('Location:' . site_url('uye/'.$user_data['user_url']));
                if ($result) {
                    $success_personal = "Bilgileriniz başarılı bir şekilde güncellendi.";
                } else {
                    $error_personal = "Bilgileriniz güncellenemedi, lütfen daha sonra tekrar deneyiniz.";
                }
            }
        }
    }
}

if (post('submit_password')){
    $password = post('user_password');
    $new_password = post('user_new_password');
    $new_password_again = post('user_new_password_again');
    if (!$password) {
        $error_password = "Lütfen mevcut şifrenizi giriniz.";
    } elseif (!$new_password) {
        $error_password = "Lütfen yeni şifrenizi giriniz.";
    } elseif ($new_password != $new_password_again) {
        $error_sign_up = "Girdiğiniz yeni şifreler birbiriyle uyuşmuyor.";
    } else {
        //şifre doğru mu kontrol et
        $password_verify = password_verify($password, $query['user_password']);
        if (!$password_verify) {
            $error_password = "Mevcut şifrenizi yanlış girdiniz.";
        } else {
            //email var mı kontrol et
            $row2 = User::userExistsEmail($email);
            if ($row2 && ($email != $query['user_email'])) {
                $error_password = "Bu e-posta adresi kullanılıyor. Lütfen başka bir tane deneyiniz.";
            } else {
                //şifreyi değiştir
                $result = $db->update('users')
                    ->where('user_id' , $query['user_id'])
                    ->set([
                        'user_password' => password_hash($password, PASSWORD_DEFAULT),
                    ]);
                $user_data = $db->from('users')
                    ->where('user_nick' , $usernick)
                    ->first();
                User::Login($user_data);
                header('Location:' . site_url('uye/'.$user_data['user_url']));
                if ($result) {
                    $success_password = "Şifreniz başarılı bir şekilde güncellendi.";
                } else {
                    $error_password = "Şifreniz güncellenemedi, lütfen daha sonra tekrar deneyiniz.";
                }
            }
        }
    }
}

if (isset($_FILES["profile_img"])){

    $target_dir = '../cms/upload/files/';
    $target_file = $target_dir .$query['user_url'].'.jpg';
    $img_url = $query['user_url'].'.jpg';
    move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file);

    $query2 = $db->update('users')
        ->where('user_id' , $query['user_id'])
        ->set([
            'user_img' => $img_url
        ]);

}

$meta = [
    'title' => $query['user_name'] ? ($query['user_name'] . ' — ' . setting('title')) : ($query['user_name'] . ' — ' . setting('title')),
    'description' => setting('description'),
    'keywords' => setting('keywords'),
];

// görsel yenilendiği için tekrar çağırıyoruz
$query = $db->from('users')
    ->where('user_nick' , $user_url)
    ->first();

*/

require view('user-single');


