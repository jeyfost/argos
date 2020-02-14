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
            <div class='copy' style='float: right;'><i class='fa fa-phone' aria-hidden='true'></i> ".SALES_CITY."<br /><i class='fa fa-phone' aria-hidden='true'></i> ".SALES_MOBILE."</div>
        </div>
        <div style='clear: both;'></div>
        
        <div onclick=\"scrollToTop()\" id=\"scroll\"><i class=\"fa fa-chevron-up\" aria-hidden=\"true\"></i></div>
    ";
}