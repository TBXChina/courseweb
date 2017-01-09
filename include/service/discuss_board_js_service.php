<?php
    include_once "include/service/service.php";
    include_once "include/module/discuss_board_module.php";
    include_once "include/common/log.php";
    include_once "include/common/user.php";

    class DiscussBoard_JS_Service implements service {
        private $user;
        private $post2URL;
        private $spaceNum;

        static private $AJAXFUNNAME = "LoadAjaxDoc";

        public function __construct($user, $post2URL, $spaceNum) {
            $this->user = $user;
            $this->post2URL = $post2URL;
            $this->spaceNum = $spaceNum;
        }

        private function FunGenerate($funName, $postStr, $changeDivId) {
            $prefix = Fun::NSpaceStr($this->spaceNum + 4);
            $str  = $prefix."function ".$funName."() {\n";
            $str .= $prefix."    ".self::$AJAXFUNNAME."(".$this->post2URL.",\n";
            $str .= $prefix."    \"".$postStr."\",\n";
            $str .= $prefix."    function() {\n";
            $str .= $prefix."        if ( 4 == ajaxhttp.readyState && 200 == ajaxhttp.status) {\n";
            $str .= $prefix."            document.getElementById(\"".$changeDivId."\").innerHTML = ajaxhttp.responseText;\n";
            $str .= $prefix."        }\n";
            $str .= $prefix."    });\n";
            Log::RawEcho($str);
        }

        public function Run() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str  = $prefix."<script type = \"text/javascript\">\n";
            $str .= $prefix."    var ajaxhttp;\n";
            $str .= $prefix."    function ".self::$AJAXFUNNAME."(url, postStr, cfunc) {\n";
            $str .= $prefix."        if ( window.XMLHttpRequest ) {\n";
            $str .= $prefix."            //code for ie7+, firefox, chrome, opera, safari\n";
            $str .= $prefix."            ajaxhttp = new XMLHttpRequest();\n";
            $str .= $prefix."        } else {\n";
            $str .= $prefix."            //code for ie5, ie6\n";
            $str .= $prefix."            ajaxhttp = new ActiveXObject();\n";
            $str .= $prefix."        }\n";
            $str .= $prefix."        ajaxhttp.onreadystatechange = cfunc;\n";
            $str .= $prefix."        ajaxhttp.open(\"POST\", url, true);\n";
            $str .= $prefix."        ajaxhttp.setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");\n";
            $str .= $prefix."        ajaxhttp.send(postStr);\n";
            $str .= $prefix."    }\n";
            Log::RawEcho($str);

            //first page
            $this->FunGenerate("Funname", "poststr", "divid");

            $str .= $prefix."</script>\n";
        }
    }
?>
