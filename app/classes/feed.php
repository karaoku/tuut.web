<?php

class Feed{

    public static function Tuut($tuut_url)
    {
        global $db;
        $query= $db->from('tuuts')
            ->where('tuut_url' , $tuut_url)
            ->join('users', '%s.user_id = %s.user_id')
            ->join('categories', '%s.category_id = %s.category_id')
            ->all();
        return $query;
    }

    public static function Tuuts()
    {
        global $db;
        $query= $db->from('tuuts')
            ->join('users', '%s.user_id = %s.user_id')
            ->join('categories', '%s.category_id = %s.category_id')
            ->all();
        return $query;
    }

    public static function User_Tuuts($user_url)
    {
        global $db;
        $query= $db->from('tuuts')
            ->join('users', '%s.user_id = %s.user_id')
            ->join('categories', '%s.category_id = %s.category_id')
            ->where('user_url' , $user_url)
            ->all();
        return $query;
    }

    public static function Categories()
    {
        global $db;
        $query= $db->from('categories')
            ->orderBy('category_id', 'ASC')
            ->all();
        return $query;
    }

    public static function Movies($tag_name,$count)
    {
        global $db;
        if($tag_name){
            $query= $db->from('movies')
                ->where('movie_tag' , $tag_name)
                ->limit(0, $count)
                ->orderBy('movie_id', 'ASC')
                ->all();
        } else {
            $query= $db->from('movies')
                ->orderBy('movie_id', 'ASC')
                ->limit(0, $count)
                ->all();
        }
        return $query;
    }

    public static function Series($tag_name,$count)
    {
        global $db;
        if($tag_name){
            $query= $db->from('series')
                ->where('series_tag' , $tag_name)
                ->limit(0, $count)
                ->orderBy('series_id', 'ASC')
                ->all();
        } else {
            $query= $db->from('series')
                ->orderBy('series_id', 'ASC')
                ->limit(0, $count)
                ->all();
        }
        return $query;
    }

    public static function Episodes($series_url,$count)
    {
        global $db;
        if($series_url){
            $query= $db->from('episodes')
                ->where('series_url' , $series_url)
                ->join('series', '%s.series_id = %s.series_id')
                ->orderBy('episode_id', 'DESC')
                ->limit(0, $count)
                ->all();
        } else {
            $query= $db->from('episodes')
                ->join('series', '%s.series_id = %s.series_id')
                ->orderBy('episode_id', 'DESC')
                ->limit(0, $count)
                ->all();
        }
        return $query;
    }

    public static function UserListProd($user_id)
    {
        if (!$user_id){
            return false;
        }
        global $db;
        $user_list = $db->from('lists')
            ->where('user_id', $user_id)
            ->first();
        if (!$user_list){
            return false;
        } else {
            $user_list = json_decode($user_list['list_productions'] , true);
            if (!$user_list){
                return false;
            } else {
                foreach ($user_list as $key => $movie) {
                    if ($movie['type'] == "movie") {
                    $query = $db->from('movies')
                        ->where('movie_id', $movie['id'])
                        ->first();
                    $prod_list[] = [
                        'id' => $query['movie_id'],
                        'img' => $query['movie_img'],
                        'title' => $query['movie_title'],
                        'url' => 'film/'.$query['movie_url'],
                        'type' => 'movie',
                    ];
                    }
                    else {
                        $query = $db->from('series')
                            ->where('series_id', $movie['id'])
                            ->first();
                        $prod_list[] = [
                            'id' => $query['series_id'],
                            'img' => $query['series_img'],
                            'title' => $query['series_title'],
                            'url' => 'dizi/'.$query['series_url'],
                            'type' => 'series'
                        ];
                    }
                }
                return $prod_list;
            }
        }
    }
}