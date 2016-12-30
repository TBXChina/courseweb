<?php
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/easter_egg.php";

    $infoFromPrePage = new PassInfoBetweenPage();
    $str = $infoFromPrePage->GetInfo(EasterEgg::GetEgg());
    if ( !is_null($str) ) {
        Log::RawEcho($str);
        $infoFromPrePage->DestroyInfo(EasterEgg::GetEgg());
    }
?>
