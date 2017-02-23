<?php
// redirect to src/show_stat.php
header('Location: http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/src/show_stat.php',true,301);
exit;
?>
