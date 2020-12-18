<?php

function admin_controller($controllerName)
{
    $controllerName = strtolower($controllerName);
    return PATH . '/admin/controller/' . $controllerName . '.php';
}
function admin_url($url = false)
{
    return URL . '/admin/' . $url;
}

function admin_public_url($url = false)
{
    return URL . '/admin/public/' . $url;
}

function admin_view($viewName)
{
    return PATH . '/admin/view/' . $viewName . '.php';
}

function header_menu_list($menuNumber)
{
    ?> <?php foreach ($menuNumber as $mainUrl => $menu):?>
        <li class="<?= (route(1) == $mainUrl) || isset($menu['submenu'][route(1)]) ? 'mm-active' : null ?>">
            <a href="<?= admin_url($mainUrl) ?>" class="<?= (route(1) == $mainUrl) || isset($menu['submenu'][route(1)]) ? 'mm-active' : null ?>" aria-expanded="<?= (route(1) == $mainUrl) || isset($menu['submenu'][route(1)]) ? 'true' : null ?>">
                <i class="metismenu-icon <?= $menu['icon'];?>"></i>
                <?= $menu['title'];?>
                <?php if(isset($menu['submenu'])): ?>
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                <?php endif ?>
            </a>
            <?php if(isset($menu['submenu'])): ?>
                <ul>
                    <?php foreach ($menu['submenu'] as $url => $title): ?>
                        <li>
                            <a href="<?= admin_url($url) ?>" class="<?= (route(1) == $url) ? 'mm-active' : null ?>">
                                <i class="metismenu-icon"></i>
                                <?= $title?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif ?>
        </li>
    <?php endforeach; ?> <?php
}

function user_ranks($RankID = null)
{
    $ranks = [
        1 => 'Yönetici',
        2 => 'Editör',
        3 => 'Üye',
    ];
    return $RankID ? $ranks[$RankID] : $ranks;
}

function prod_comment_number($prod_id,$type)
{
    global $db;
    $commentRecord = $db->from('ratings')
        ->where('rating_type' , $type)
        ->where('prod_id' , $prod_id)
        ->select('count(rating_id) as total')
        ->total();
    if (!$commentRecord){
        $rating = 'N/A';
        return $rating;
    } else {
        return $commentRecord;
    }
}

function TableColumnCount($item)
{
    global $db;
    if ($item == "series"){
        $count = $db->from('series')
            ->select('count(series_id) as total')
            ->total();
    } else {
        $count = $db->from($item.'s')
            ->select('count('.$item.'_id) as total')
            ->total();
    }

    return $count;
}
