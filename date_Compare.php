<?php
    $yesterday="2023-07-09";
    $NowHaveS=date("Y-m-d h:i:s");
    echo $NowHaveS;
    echo "<br>";
    $NowNoHaveS=date("Y-m-d",strtotime($NowHaveS));
    echo $NowNoHaveS;
    echo "<br>";
    if(date("Y-m-d",strtotime($NowHaveS))==$yesterday){
        echo "只要是今天就運行。";
    }else if(date("Y-m-d",strtotime($NowHaveS))!=$yesterday){
        echo "只要不是今天就運行。";
    }
