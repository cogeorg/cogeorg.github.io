<?php
// redirect to src/index.php
header('Location: http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/src/index.php',true,301);
exit;
?>
