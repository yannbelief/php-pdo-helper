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
	DB::$password = "[password]";
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

PDO Value Binding
---

you may notice that the example above uses question mark(?) for which real values will be substituted when the SQL statement is executed. I simplify the usage of built-in Statement provided by PDO.
When you work with value binding, you can pass your value array as the 2nd argument to the method which you are going to call.
The optional 2nd argument is supported by all methods in this helper class.


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
	echo $rows[0][1]; // CHEN Yen Ting
```

Fetch Values in One Column As an Array
---

In some occasions, we fetch the values only in one column, like:

	SELECT name FROM my_table

And we would like the return value of this kind of SQL to be a simple array.
Hence, there comes the `fetchColOneArr` method.

```php
	$names = $db->fetchColOneArr("SELECT name FROM my_table");
	echo $names[2]; // Bob DAVIES
```

See. Isn't it simpler to use?


Fetch the First Record As a Single Object or Single Value
---

Sometimes all we need to fetch is a single object or value.
And it's the first record in terms of rational database.
To handle such conditions, the method `fetchOneObj` or `fetchOneVal` is a good choice.

```php
	$taiwanese = $db->fetchOneObj("SELECT * FROM my_table WHERE country = 'Taiwan'");
	echo $taiwanese->name; // CHEN Yen Ting
	echo $taiwanese->country; // Taiwan
	echo $taiwanese->id; // 1
```

```php
	$name = $db->fetchOneVal("SELECT name FROM my_table WHERE country = 'Japan'");
	echo $name; // MATSUSHITA Daiki
```

**Change the Default Object or Default Value Returned**

When the SQL selects no record by `fetchOneObj` or `fetchOneVal`, it returns a NULL value.
If you want to replace the NULL with your default object or value, you just pass it into the method through the 3rd argument.

```php
	$defaulObj->name = "NOT FOUND";
	$defaulObj->country "N/A";

	$nullCase = $db->fetchOneObj("SELECT * FROM my_table WHERE country = 'UK'",[],$deafultObj);
	echo $nullCase->name; // NOT FOUND
	echo $nullCase->country; // N/A
```

```php
	$defaultName = "NOT FOUND";
	$nullName = $db->fetchOneObj("SELECT name FROM my_table WHERE country = 'UK'",[],$defaultName);
	echo $nullName; // NOT FOUND
```

Therefore, you don't have to manually handle the NULL condition and assign the default value to it afterward.
