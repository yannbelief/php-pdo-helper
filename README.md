PDO Helper
==========================================

This is a wrapper class of built-in PDO. It aims to provide comman methods which are convenient and friendly to programmers while they are working with PDO.

Usage
---

Put the following lines in your config or setting file, e.g. mydbXXX.php

```php
	require("php-pdo-helper/db.php");
	DB::$dsn = "mysql:host=[your host address];dbname=[your db]";
	DB::$account = "[user name]";
	DB::$passowrd = "[password]";
	$db = DB::instance();
```
And include it whatever pages needed.

```php
	require("mydbXXX.php");
```

Then you can start to use some db operations like fetch, insert, update as following:

```php
	// select
	$rows = $db->fetch("SELECT * FROM my_table");
	// insert
	$insertedId = $db->insert("INSERT INTO my_table (col1,col2) VALUES(?,?)",["val1","val2"]);
	// update
	$result = $db->execute("UPDATE my_table SET col1 = ?, col2 = ? WHERE id = ?",["val1","val2",3]);
```

Fetch (select)
---

Operations like fetching records are the main point of this little class.

For example, if we have a table as shown below:

| id     | name               | country  |
| ------ | ------------------ | -------- |
| 1      | CHEN Yen Ting      | Taiwan   |
| 2      | MATSUSHITA Daiki   |  Japan   |
| 3      | Bob DAVIES         |    US    |


And we want to select all records, just use the `fetch` method like this:

```php
	$rows = $db->fetch("SELECT * FROM my_table");
```

The default way to access an attribute (a column) follows object style:

```php
	echo $rows[0]->name; // CHEN Yen Ting
```
If you like the associative array style, you can use `fetchArr` instead:

```php
	$rows = $db->fetchArr("SELECT * FROM my_table");	
	echo $rows[0]["name"]; // CHEN Yen Ting
```

Fetch One Column
---

In some occasions, 
