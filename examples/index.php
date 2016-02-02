<?php require_once '../vendor/autoload.php';

$m = new \RobbieP\Afterthedeadline\Afterthedeadline(['key' => md5(time())]);

$m->checkDocument('that particular course down as much as I want to #whaterver because. that many people were excused from the rigours of learning English');

?>
<html>
<head></head>
<body>
    <?php echo $m->getFormatted(); ?>


    <?php echo $m->getFormatted()->getStylesAndScript(); ?>


</body>
</html>
