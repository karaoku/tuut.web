<?php

$page_url = route(1);

if (!$page_url){
    header('Location:' . site_url('404'));
    exit;
} else {
    $query = $db->from('pages')
        ->where('page_url' , $page_url)
        ->first();
    if (!$query){
        header('Location:' . site_url('404'));
        exit;
    }
}


/* $page_seo = json_decode($row['page_seo'], true);

$meta = [
    'title' => $page_seo['title'] ? ($page_seo['title'] . ' — ' . setting('title')) : ($row['page_title'] . ' — ' . setting('title')),
    'description' => $page_seo['desc'] ? $page_seo['desc'] : cut_text($row['page_content'] , 200),
    'keywords' => setting('keywords'),
];

*/

require view('page');