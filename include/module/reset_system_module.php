<?php
    include_once "include/module/module.php";
    include_once "include/common/log.php";
    include_once "include/common/fun.php";
    include_once "include/common/web.php";
    include_once "include/common/user.php";

    class ResetSystemModule implements Module {
        private $spaceNum;
        private $user;

        static private $RESETBUTTON = "ResetSystem_Reset";

        public function __construct($spaceNum, $user) {
            $this->spaceNum = $spaceNum;
            $this->user     = $user;
        }

        static public function GetResetButton() {
            return self::$RESETBUTTON;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //reset sytem
            if ( Admin::GetRole() == $this->user->GetRole() &&
                 "root" == $this->user->GetId() ) {
                $str  = $prefix."<h3>Reset All System<br><span>Waring: It is very dangerous, use very carefully!</span></h3>\n";
                $str .= $prefix."<form action = \"".
                        Web::GetCurrentPage()."\" method = \"post\">\n";
                $str .= $prefix."    <input type = \"submit\" name = \"".
                        self::$RESETBUTTON."\" value = \"Reset System\">\n";
                $str .= $prefix."</form>\n";
                Log::RawEcho($str);
            }
        }
    }
?>
