<?php
/**
 * Created by PhpStorm.
 * User: jhoward
 * Date: 10/22/15
 * Time: 6:38 PM
 */

function tokenRedeemValue() {
    $gameStart = strtotime('2015-10-22 18:30:00');
    return round((time()-$gameStart)/1000);
}