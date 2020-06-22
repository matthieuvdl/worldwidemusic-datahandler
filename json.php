<?php
require 'utils/functions.php';

//                JSON Micro API            //
//      ---------------------------------   //
//      Simple JSON API which gives         //
//      JSON output with the specified      //
//      decade.                             //

if (isset($_GET['decade']) && isset($_GET['type']))
{
    if ($_GET['type'] == 'object' || $_GET['type'] == 'array')
    {
        parseToJson(getAllGenreDecade($_GET['decade'], $_GET['type']));
    }
    else if ($_GET['type'] == 'multiarray')
    {
        parseToJson(getAllGenreDecadeSorted($_GET['decade']));
    }
}
else
{
    print_r('You must specify a decade and a type');
}

