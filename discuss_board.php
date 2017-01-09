<?php
    include_once "include/common/log.php";
    include_once "include/service/discuss_board_service.php";
    include_once "include/module/discuss_board_module.php";
    include_once "include/common/user.php";

    $user = UserFactory::Query("2");
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

    var url = "/courseweb/ajax_discuss_board.php";
    function <?php Log::RawEcho(DiscussBoardModule::GetFirstPageButtonFun()); ?>() {
        LoadAjaxDoc(url,
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
        LoadAjaxDoc(url,
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
        LoadAjaxDoc(url,
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
        LoadAjaxDoc(url,
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
        LoadAjaxDoc(url,
                    "<?php Log::RawEcho(DiscussBoardModule::GetLastPageButton()) ?>",
                   function() {
            if ( ajaxhttp.readyState == 4 &&
                 ajaxhttp.status == 200 ) {
                document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetDivId()) ?>").innerHTML =
                ajaxhttp.responseText;
            }
        });
    }

    function <?php Log::RawEcho(DiscussBoardModule::GetSubmitButtonFun()); ?>() {
        var textarea = document.getElementById("<?php Log::RawEcho(DiscussBoardModule::GetTextareaId()); ?>");
        //alert(textarea.value);
        var content = textarea.value;
        var postStr = "<?php Log::RawEcho(DiscussBoardModule::GetSubmitButton()); ?>"
                      <?php 
                           if ( !is_null($user) ) {
                               Log::RawEcho("+\"&".DiscussBoardModule::GetUserIdTag()."=".$user->GetId()."\"");
                            }
                       ?> +
                      "&<?php Log::RawEcho(DiscussBoardModule::GetTextareaContent()); ?>=" + content;
        LoadAjaxDoc(url,
                    postStr,
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
    $m = new DiscussBoardModule(2, $user);
    $m->Display();
    $info2NextPage = new PassInfoBetweenPage();
    $info2NextPage->SetInfo(DiscussBoardModule::GetUser2NextPage(),
                            $m->GetUser());
?>
</body>
