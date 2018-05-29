<?php
/**
 * Example how to use DatabaseORM Class
 * User: Ahmed El-Nemr
 * Date: 5/29/2018
 *
 */

require_once "TIGER-ORM.php";
require_once "user.class.php";


/* ********************************************
 * ********************************************
 * ******** insert new user *******************
 * ********************************************
 * ********************************************/
// array key as table attributes & values=> insert to table
$user = new User([
    'username' => "tiger",
    'password' => md5("12345"),
    'full_name' => "Ahmed El-Nemr"
]);
// insert function using array data
$user->insert();

/* ********************************************
 * ********************************************
 * ************ update user *******************
 * ********************************************
 * ********************************************/
// array key as table attributes & values=> insert to table
$user = new User([
    'username' => "elnemr",
    'password' => md5("A12345"),
    'full_name' => "Ahmed El-Nemr"
], 21);
// update function using array data
$user->update();

/* ********************************************
 * ********************************************
 * ************** find user *******************
 * ********************************************
 * ********************************************/
// select user in assoc. array
$user = User::find(21);

/* ********************************************
 * ********************************************
 * ************** get all users ***************
 * ********************************************
 * ********************************************/
// select all users in multidimensional assoc. array
$user = User::all();

/* ********************************************
 * ********************************************
 * ************** delete user ***************
 * ********************************************
 * ********************************************/
// delete user by id
$user = User::delete(21);