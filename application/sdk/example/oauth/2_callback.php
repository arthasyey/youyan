<?php
require_once '../../requires.php';

$code = $_GET['code'];
echo $code, '<br/><br/>';
?>
<a href="3_accesstoken.php?code=<?php echo $code; ?>">Access Token</a>