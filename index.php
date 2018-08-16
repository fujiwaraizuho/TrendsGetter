<?php

require_once("src/TrendsGetter.php");

$getter = new TrendsGetter();
$data = $getter->getTrends(1);

?>
<html>
    <pre>
        <code>
            <?php var_dump($data); ?>
        </code>
    </pre>
</html>