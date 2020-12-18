<?php

$activation_code = route(1);

if (!$activation_code){
    header('Location:' . site_url('404'));
    exit;
} else {
    $row =  $db->from('users')
        ->where('user_token' , $activation_code)
        ->first();
    if ($row){
        $query = $db->update('users')
            ->where('user_token' , $activation_code)
            ->set([
                'user_token' => md5(uniqid()),
                'user_activation' => 1
            ]);
        User::Login($row);
        header('Location:' . site_url());
        exit;
    } else {
        header('Location:' . site_url('404'));
        exit;
    }
}