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
        static private $USER        = "ResetSytem_user";

        public function __construct($spaceNum, $user) {
            $this->spaceNum = $spaceNum;
            $this->user     = $user;
        }

        static public function GetResetButton() {
            return self::$RESETBUTTON;
        }

        static public function GetUser() {
            return self::$USER;
        }

        public function Display() {
            $prefix = Fun::NSpaceStr($this->spaceNum);
            //reset sytem
            if ( Admin::GetRole() == $this->user->GetRole() &&
                 0 == strcmp("root",$this->user->GetId()) ) {
                $str  = $prefix."<h3>Reset All System<br><span>Waring: It is very dangerous, use very carefully!</span></h3>\n";
                $str .= $prefix."<form action = \"".
                        Web::GetInitializationPage()."\" method = \"post\">\n";
                $str .= $prefix."    <input type = \"submit\" name = \"".
                        self::$RESETBUTTON."\" value = \"Reset System\">\n";
                $str .= $prefix."</form>\n";
                Log::RawEcho($str);
                //info 2 next page
                $info2NextPage = new PassInfoBetweenPage();
                $info2NextPage->SetInfo(self::$USER, $this->user);
            }
        }
    }
?>
