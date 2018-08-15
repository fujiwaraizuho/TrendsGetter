<?php

require_once("src/TrendsGetter.php");

$getter = new TrendsGetter();
$data = $getter->getTrends($getter);

?>
<html>
    <pre>
        <code>
            <?php var_dump($data); ?>
        </code>
    </pre>
</html>