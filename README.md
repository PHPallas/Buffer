# Buffer

A Stock to keep variables and function and use them inside a pipiline system. This package is originally created to work alongside various packages by PHPallas Team. However, it is possible to use it anywhere you need a buffer object to keep your variables and functions available across steps of a pipeline.

## How to

1. **Install `phpallas/buffer`**: by using composer you can install it on your package as below:

```
composer require phpallas/buffer
```

This will install latest version of package.

2. **Get an instant**: `buffer` is a singleton so inside and part ot your program get the instant as following method:

```
use PHPallas\Buffer\Stock as Buffer;

$buffer = Buffer::getInstance();
```

3. **Set variable**: you can set a variable as below

```
use PHPallas\Buffer\Stock as Buffer;

$buffer = Buffer::set("namespace.name", "value here");
```

where the name of variable MAY include some namespaces using a dor notation, for example `vars.page.title`, `tables.main.headers`, etc.

4. **Get variable**: you can use a dot notation to get variable value. For example if you set an array as below:

```
$buffer -> set("page.title", ["title" => "great", "subTitle" => "awsome title", "separator" => "|"]);
```

then:

```
$buffer -> get("page.title.title"); // => gerat
$buffer -> get("page.title.subTitle"); // => awsome title
$buffer -> get("page.title"); // => ["title" => "great", "subTitle" => "awsome title", "separator" => "|"]
```

5. **Register Helper Function**: similar to the variables you can also set functions as below:

```
$buffer -> register("awsomeFunction", function ($arg){return $arg;});
```

6. **Call Helper Function**: you can call a helper function using a call method as below:

```
$buffer -> awsomeFunction ($arg); // return $arg as we defined awsomeFunction
```

7. **Unregister Helper Function**: if you don't need a helper function anymore simple unregister it as below:

```
$buffer -> register("awsomeFunction");
```

## Feature Request

If you need a feature that is missing from my package just [create an isset](https://github.com/PHPallas/Buffer/issues). 

## Contribution

All types of contributions (development, test, translation) are welcome! you can contribute on this package and make it better and more usable.

## License

This package is licenced under [MIT](https://github.com/PHPallas/Buffer#MIT-1-ov-file).