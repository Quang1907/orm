<?php

include_once 'MySQL.php';
include_once 'User.php';
include_once 'Category.php';

$user = new User();
$first = $user->all()[0];
echo $first->name;

$category = new Category();
$cat = $category->all()[0];
echo $cat->name;
