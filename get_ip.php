<?php
    echo $_SERVER["HTTP_CLIENT_IP"];
    echo "<br>";
    echo $_SERVER["HTTP_X_FORWARDED_FOR"];
    echo "<br>";
    echo $_SERVER["REMOTE_ADDR"];
    