<?php

define("ROOT", __DIR__);
$count = 1;
$uri = str_replace("/resaweb", "", $_SERVER['REQUEST_URI'], $count);

$page = explode("?", ltrim($uri, "/"), 2);   //remove "/" and $_GET values to isolate the page's name
$path =  $page[0];      //example : "/page1?=val1abc" --> "page1" = $page[0]
if ($path === "") {
    $path = "index";
}

$allowedPages = [
    "index" => "view:index",
    "velo" => "view:velo",
    "panier" => "view:panier",
    "check_availability" => "controller:check_availability",
    "catalogue" => "view:catalogue",
    "reservation" => "view:reservation",
    "propos" => "view:propos",
    "termes" => "view:termes"
];

function showView($view)
{
    require(ROOT . "/views/$view.php");
}

function showController($control)
{
    require(ROOT . "/controllers/$control.php");
}

//check if the requested URI is allowed
if (!array_key_exists($path, $allowedPages)) {
    showView("error_404");
    exit;
}

$target = $allowedPages[$path];
$explodedTarget = explode(":", $target);
if ($explodedTarget[0] === "view")
    showView($explodedTarget[1]);
else
    showController($explodedTarget[1]);


?>