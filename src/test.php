<table width="500" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" enctype="multipart/form-data">
    <tr>
        <td>choose file: </td>
        <td width="250"><input type="file" name="upfile"/></td>
        <td width="100"><input type="submit" name="submit" value="upload"/></td>
    </tr>
</form>
</table>
<?php
    include_once "../include/file.php";
    File::Download("/home/tbx/workspace/php.ini");
?>
