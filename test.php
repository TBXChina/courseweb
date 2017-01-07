<?php
    include_once "include/common/log.php";
    include_once "include/service/discuss_board_service.php";
    include_once "include/module/discuss_board_module.php";
?>
<!DOCTYPE HTML>
<html>
<head>
<script type = "text/javascript">
    var ajaxhttp;
    function LoadAjaxDoc(url, postStr, cfunc) {
        if ( window.XMLHttpRequest ) {
            //code for ie7+, firefox, chrome, opera, safari
                ajaxhttp = new XMLHttpRequest();
            } else {
                //code for ie5, ie6
                ajaxhttp = new ActiveXObject();
            }
            ajaxhttp.onreadystatechange = cfunc;
            ajaxhttp.open("POST", url, true);
            ajaxhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajaxhttp.send(postStr);
        }
    function <?php Log::RawEcho(DiscussBoardModule::GetFirstPageButtonFun()); ?>() {
        LoadAjaxDoc("/courseweb/test.php",
                    "<?php Log::RawEcho(DiscussBoardModule::GetFirstPageButton()) ?>",
                   function() {
            if ( ajaxhttp.readyState == 4 &&
                 ajaxhttp.status == 200 ) {
                document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetDivId()) ?>").innerHTML =
                ajaxhttp.responseText;
            }
        });
    }

    function <?php Log::RawEcho(DiscussBoardModule::GetPreviousPageButtonFun()); ?>() {
        LoadAjaxDoc("/courseweb/test.php",
                    "<?php Log::RawEcho(DiscussBoardModule::GetPreviousPageButton()) ?>",
                   function() {
            if ( ajaxhttp.readyState == 4 &&
                 ajaxhttp.status == 200 ) {
                document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetDivId()) ?>").innerHTML =
                ajaxhttp.responseText;
            }
        });
    }

    function <?php Log::RawEcho(DiscussBoardModule::GetRefreshButtonFun()); ?>() {
        LoadAjaxDoc("/courseweb/test.php",
                    "<?php Log::RawEcho(DiscussBoardModule::GetRefreshButton()) ?>",
                   function() {
            if ( ajaxhttp.readyState == 4 &&
                 ajaxhttp.status == 200 ) {
                document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetDivId()) ?>").innerHTML =
                ajaxhttp.responseText;
            }
        });
    }

    function <?php Log::RawEcho(DiscussBoardModule::GetNextPageButtonFun()); ?>() {
        LoadAjaxDoc("/courseweb/test.php",
                    "<?php Log::RawEcho(DiscussBoardModule::GetNextPageButton()) ?>",
                   function() {
            if ( ajaxhttp.readyState == 4 &&
                 ajaxhttp.status == 200 ) {
                document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetDivId()) ?>").innerHTML =
                ajaxhttp.responseText;
            }
        });
    }

    function <?php Log::RawEcho(DiscussBoardModule::GetLastPageButtonFun()); ?>() {
        LoadAjaxDoc("/courseweb/test.php",
                    "<?php Log::RawEcho(DiscussBoardModule::GetLastPageButton()) ?>",
                   function() {
            if ( ajaxhttp.readyState == 4 &&
                 ajaxhttp.status == 200 ) {
                document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetDivId()) ?>").innerHTML =
                ajaxhttp.responseText;
            }
        });
    }

</script>
</head>
<body>
<?php
    $m = new DiscussBoardModule(2);
    $m->Display();
?>
</body>
