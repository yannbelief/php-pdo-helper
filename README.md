PDO Helper
==========================================

This is a wrapper class of built-in PDO. It aims to provide comman method calls which are convenient and friendly to programmers while they are working with PDO.

Usage
---

Put the following lines in your config or setting file, e.g. mydbXXX.php

	require("php-pdo-helper/db.php");
	DB::$dsn = "mysql:host=[your host address];dbname=[your db]";
	DB::$account = "[user name]";
	DB::$passowrd = "[password]";
	$db = DB::instance();

And include it whatever pages needed.
	
	require("mydbXXX.php");

Then you can start to use some db operations like fetch, insert, update as following:

	$rows = $db->fetch("SELECT * FROM my_table");
	$insertedId = $db->insert("INSERT INTO my_table (col1,col2) VALUES(?,?)",["val1","val2"]);
	$result = $db->execute("UPDATE my_table SET col1 = ?, col2 = ? WHERE id = ?",["val1","val2",3]);

