<?php
    function consoleLog($msg) {
        echo "<script>console.log('" . htmlentities($msg) . "');</script>";
    }
?>