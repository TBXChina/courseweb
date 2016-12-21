<?php
    include_once "include/module/module.php";
    include_once "include/configure.php";
    include_once "include/common/fun.php";
    include_once "include/common/log.php";
    include_once "include/common/user.php";

    //user console
    class UserConsoleModule implements Module {
        private $spaceNum;
        private $user;
        static private $signOut     = "UserConsole_SignOut";
        static private $changePWD   = "UserConsole_ChangePWD";
        static private $newPassword = "UserConsole_NewPassword";

        public function __construct($spaceNum, $user) {
            $this->spaceNum = $spaceNum;
            $this->user     = $user;
        }

        static public function GetSignOutButton() {
            return self::$signOut;
        }

        static public function GetChangePWDButton() {
            return self::$changePWD;
        }

        public function Display() {
            $user   = $this->user;
            $prefix = Fun::NSpaceStr($this->spaceNum);
            $str    = $prefix."<h1>Hello, ".
                      $user->GetName()."</h1>\n";
            $str   .= $prefix."<h3>Your Identity is ".
                      $user->GetRole()."</h3>\n";
            $str   .= $prefix."<form action = \"".
                      htmlspecialchars($_SERVER["PHP_SELF"]).
                      "\" method = \"post\">\n";
            $str   .= $prefix."    <input type = \"submit\" name = \"".
                      self::$signOut."\" value = \"Sign out\">\n";
            $str   .= $prefix."</form>\n";
            $str   .= $prefix."<h3>Change your password</h3>\n";
            $str   .= $prefix."<form action = \"".
                      htmlspecialchars($_SERVER["PHP_SELF"]).
                      "\" method = \"post\">\n";
            $str   .= $prefix."    <input type = \"password\" name = \"".
                      self::$newPassword."\" placeholder = \"New Password\" required>\n";
            $str   .= $prefix."    <input type = \"submit\" name = \"".
                      self::$changePWD."\" value = \"Change\">\n";
            $str   .= $prefix."</form>\n";
            Log::RawEcho($str);
        }
    }
?>
