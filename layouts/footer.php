<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.09.2019
 * Time: 16:23
 */

include("../scripts/const.php");

function footer() {
    return "
        <div class='container'>
            <div class='copy'>&copy; ЧТУП &laquo;Аргос-ФМ&raquo;<br />2008 - ".date('Y')."</div>
            <div class='copy' style='margin-left: 40px;'>Республика Беларусь, г. Могилёв, ул. Залуцкого, 21<br /><a href='/contacts/main.php'>Контактная информация</a> | <a href='/sitemap.php'>Карта сайта</a></div>
            <div class='copy' id='footerContacts' style='float: right; margin-top: -6px;'><i class='fa fa-phone' aria-hidden='true'></i> ".SALES_CITY."<br /><i class='fa fa-phone' aria-hidden='true'></i> ".SALES_2_MOBILE."<br /><i class='fa fa-phone' aria-hidden='true'></i> ".SALES_MOBILE."</div>
        </div>
        <div style='clear: both;'></div>
        
        <div onclick='scrollToTop()' id='scroll'><i class='fa fa-chevron-up' aria-hidden='true' style='font-size: 24px;'></i></div>
    ";
}