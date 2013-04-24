<?php

//include the user class
include('class.Database.php');
include('class.User.php');

//create a database connection to be used inside class.User
$g_oDatabase = new Database( 'INSERT DB HOST HERE', 'INSERT DB USERNAME HERE', 'INSERT DB PASSWORD HERE', 'INSERT DB NAME HERE' );

/******** SCENARIO 1 - creating a new user and saving values to DB ********/

//create an empty user object
$t_oUser = new User;

//assign values to the instance array, this will enter the __set method inside class.User
$t_oUser->first_name = 'Simon';
$t_oUser->last_name = 'Lait';
$t_oUser->age = 21;
$t_oUser->username = 'admin';
$t_oUser->password = md5( 'password' );

//call the save method will INSERT data into users table
$t_oUser->save();

/******** SCENARIO 2 - getting an existing user and updating their column value ********/

//create a new user object and pass in the id of the row you want to get values for
$t_oUser = new User( 1 );

//the __construct function inside class.User will call the load() function as an id was passed in and assign the columns value to the $t_aTableRow instance array inside class.User

//now update the user age and save
$t_oUser->age = 22;

//this will UPDATE row 1 with your new ages
$t_oUser->save();

/******** SCENARIO 3 - echo a users full name to the page ********/
$t_oUser = new User( 1 );
echo $t_oUser->first_name . ' ' . $t_oUser->last_name;


?>