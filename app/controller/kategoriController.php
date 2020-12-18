<?php

$category_url = route(1);

if (!$category_url){
    header('Location:' . site_url('404'));
    exit;
} else {
    $query = $db->from('tuuts')
        ->join('users', '%s.user_id = %s.user_id')
        ->join('categories', '%s.category_id = %s.category_id')
        ->all();
    if (!$query){
        header('Location:' . site_url('404'));
        exit;
    }
}


require view('category');