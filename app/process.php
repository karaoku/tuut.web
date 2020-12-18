<?php

require 'init.php';
require 'config.php';

if (isset($_POST['process'])){
    $islem = $_POST['process'];
    $user_id= $_POST['user_id'];
    $tuut_id= $_POST['tuut_id'];
    if ($islem == "addLike"){
        Like($user_id,$tuut_id);
    } elseif($islem == "removeLike"){
        removeLike($user_id,$tuut_id);
    } elseif ($islem == "addUnlike") {
        Unlike($user_id,$tuut_id);
    } elseif($islem == "removeUnlike"){
        removeUnlike($user_id,$tuut_id);
    }
}

function Like($user_id,$tuut_id){
    global $db;
    $db->insert('likes')
        ->set([
            'user_id' => $user_id,
            'tuut_id' => $tuut_id,
        ]);
}

function removeLike($user_id, $tuut_id){
    global $db;
    $db->delete('likes')
        ->where('user_id' , $user_id)
        ->where('tuut_id' , $tuut_id)
        ->done();
}

function Unlike($user_id,$tuut_id){
    global $db;
    $db->insert('unlikes')
        ->set([
            'user_id' => $user_id,
            'tuut_id' => $tuut_id,
        ]);
}

function removeUnlike($user_id, $tuut_id){
    global $db;
    $db->delete('unlikes')
        ->where('user_id' , $user_id)
        ->where('tuut_id' , $tuut_id)
        ->done();
}

if (isset($_POST['process2'])){
    $islem = $_POST['process2'];
    $user_id= $_POST['user_id'];
    $comment_id= $_POST['comment_id'];
    if ($islem == "comment_addLike"){
        comment_Like($user_id,$comment_id);
    } elseif($islem == "comment_removeLike"){
        comment_removeLike($user_id,$comment_id);
    } elseif ($islem == "comment_addUnlike") {
        comment_Unlike($user_id,$comment_id);
    } elseif($islem == "comment_removeUnlike"){
        comment_removeUnlike($user_id,$comment_id);
    }
}

function comment_Like($user_id,$comment_id){
    global $db;
    $db->insert('comment_likes')
        ->set([
            'user_id' => $user_id,
            'comment_id' => $comment_id,
        ]);
}

function comment_removeLike($user_id, $comment_id){
    global $db;
    $db->delete('comment_likes')
        ->where('user_id' , $user_id)
        ->where('comment_id' , $comment_id)
        ->done();
}

function comment_Unlike($user_id,$comment_id){
    global $db;
    $db->insert('comment_unlikes')
        ->set([
            'user_id' => $user_id,
            'comment_id' => $comment_id,
        ]);
}

function comment_removeUnlike($user_id, $comment_id){
    global $db;
    $db->delete('comment_unlikes')
        ->where('user_id' , $user_id)
        ->where('comment_id' , $comment_id)
        ->done();
}