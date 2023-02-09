<?php

require_once('User.php');
require_once('Users.php');
require_once('Database.php');


/*
$new_user = new User(first_name: 'Firstname', last_name: 'Lastname', birth_date: '1983-09-15', gender: 1, birth_city: 'Minsk');
print_r($new_user);

$new_user = new User(first_name: 'Firstname One', last_name: 'Lastname One', birth_date: '1980-12-31', gender: 0, birth_city: 'Grodno');
print_r($new_user);

$age = User::getFullAge('14-09-1983');
print_r($age);

$gender = User::getGenderString(1);
print_r($gender);

$formatted = $new_user->formatUser($new_user);
print_r($formatted);

$formatted = $new_user->formatUser($new_user, full_age: true, gender: true);
print_r($formatted);

$edit_user = new User(1);
$edit_user->setFirstName('Firstname Two');
$edit_user->setBirthDate('1981-01-01');
$edit_user->setGender(1);
$edit_user->saveUser();
print_r($edit_user);

$user = new User(1);
$user->delete();

$users = new Users('first_name', 'LIKE', '%name');
$users_list = $users->getUsersList();
print_r($users);
print_r($users_list);

$users = new Users('gender', '<>', '0');
$users_list = $users->getUsersList();
$users->deleteUsers();

*/






