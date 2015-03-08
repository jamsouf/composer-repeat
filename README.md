Repeat
=========

Repeat is a repeater utility for PHP / Composer.  
It makes it easy to repeat calling a function or similar operations.

Installation
-----

#### Via composer
Install the latest version with `composer require jamsouf/repeat`

``` php
require 'vendor/autoload.php';
```

Examples
-----

##### Call a anonymous function 100 times

``` php
$results = Repeat::_function(100, function () {
    // your function code
});
```

##### Call a named function and access in each call the current result

``` php
$calculate = function ($result) {
    // your function code
};

$results = Repeat::_function(20, $calculate);
```

##### Call a named function until a specific condition

``` php
$calculate = function ($result) {
    // your function code
};

$until = function ($result) {
    // return true or false
};

$results = Repeat::_function(50, $calculate, $until);
```

##### Repeat a string with index reference and delimiter until a specific condition

``` php
$result = Repeat::_string(10, 'v1.{j}.{i}', function ($result) {
    return strpos($result, '.4.') !== false ? true : false;
}, ', ');

// => v1.1.0, v1.2.1, v1.3.2, v1.4.3
```

API Documentation
-----

#### **Repeat::_function**($count, $func, $until = _null_)
_Repeat calling a function_
* _integer_ `$count`: How often the function should be called
* _callable_ `$func`: Function to call repeated
* _callable_ `$until` (optional): Repeat calling until this function returns true
* => return _array_: Results from each function call

#### **Repeat::_string**($count, $string, $until = _null_, $delimiter = _null_)
_Repeat a string_
* _integer_ `$count`: How often the string should be repeated
* _string_ `$string`: String to repeat
* _callable_ `$until` (optional): Repeat the string until this function returns true
* _string_ `$delimiter` (optional): Signs to separate the strings
* => return _string_: Repeated string