<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.09.2019
 * Time: 16:23
 */

function footer() {
    return "
        <div class='container'>
            <div class='copy'>&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - ".date('Y')."</div>
            <div class='copy' style='margin-left: 40px;'>Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href='/contacts/main.php'>Контактная информация</a> | <a href='/sitemap.php'>Карта сайта</a></div>
            <div class='copy' style='float: right;'><i class='fa fa-phone' aria-hidden='true'></i> +375 (222) 747-800<br /><i class='fa fa-phone' aria-hidden='true'></i> +375 (222) 707-707</div>
        </div>
        <div style='clear: both;'></div>
    ";
}