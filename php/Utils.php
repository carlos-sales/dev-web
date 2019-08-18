<?php

function JSRequire($module, $file)
{
    echo "<script type=\"text/javascript\" src=\"pages/$module/js/$file\"></script>";
}
