<?php

$tuut_url = route(1);

if (!$tuut_url){
    header('Location:' . site_url('404'));
    exit;
} else {
    $query = $db->from('tuuts')
        ->where('tuut_url' , $tuut_url)
        ->first();
    if (!$query){
        header('Location:' . site_url('404'));
        exit;
    }
}

if (post('submit-comment-tuut')){

    $comment_text = post('comment-text');

    $query2 = $db->insert('comments')
        ->set([
            'user_id' => session('user_id'),
            'comment_text' => $comment_text,
            'tuut_id' => $query['tuut_id']
        ]);
    if ($query2){
        header('Location:' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url()));
    } else {
        $error = "Bir hata oluştu, lütfen tekrar deneyiniz.";
    }

}

/* $meta = [
    'title' => $series_seo['title'] ? ($series_seo['title'] . ' — ' . setting('title')) : ($row['series_title'] . ' — ' . setting('title')),
    'description' => $series_seo['desc'] ? $series_seo['desc'] : cut_text($row['series_synopsis'] , 200),
    'keywords' => $series_seo['keywords'] ? $series_seo['keywords'] : setting('keywords'),
];

 if (post('submit')) {

    $rating_number= post('rating_number');
    $rating_content= post('rating_content');
    $user_id = session('user_id');
    $rating_type = 'series';
    $prod_id = $row['series_id'];

    $query = $db->insert('ratings')
        ->set([
            'user_id' => $user_id,
            'rating_type' => $rating_type,
            'prod_id' => $prod_id,
            'rating_number' => $rating_number,
            'rating_content' => $rating_content,
        ]);
    if ($query){
        header('Location:' . site_url('dizi/') . $row['series_url']);
    } else {
        $error = "Bir hata oluştu, lütfen tekrar deneyiniz.";
    }

}

$ratings = $db->from('ratings')
    ->where('rating_type' , 'series')
    ->where('prod_id' , $row['series_id'])
    ->join('users', '%s.user_id = %s.user_id')
    ->all();
if (!$ratings){
    $error2 = "Yapıma ait yorum bulunmadı.";
}

function SeriesSeasons($series_id)
{
    global $db;
    $query = $db->from('seasons')
        ->where('series_id', $series_id)
        ->all();
    return $query;
}
*/

require view('post-single');