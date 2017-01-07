<!DOCTYPE HTML>
<html>
<body>
<?php
    include_once "include/service/discuss_board_service.php";
    include_once "include/module/discuss_board_module.php";
    $m = new DiscussBoardModule(2);
    $m->Display();
?>

<button type = "button" onclick = "test()">Re</button>

<script type = "text/javascript">
    function test() {
        alert("2124");
    }
</script>
</body>
