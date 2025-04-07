# Buffer

A stock to keep variables and functions and use them inside a pipeline system. This package was originally created to work alongside various packages by the PHPallas Team. However, it can be used anywhere you need a buffer object to keep your variables and functions available across steps of a pipeline.

## How to Use

1. **Install `phpallas/buffer`**: You can install it in your project using Composer as follows:

   ```
   composer require phpallas/buffer
   ```

   This will install the latest version of the package.

2. **Get an Instance**: `Buffer` is a singleton, so to get the instance in any part of your program, use the following method:

   ```php
   use PHPallas\Buffer\Stock as Buffer;

   $buffer = Buffer::getInstance();
   ```

3. **Set a Variable**: You can set a variable as shown below:

   ```php
   use PHPallas\Buffer\Stock as Buffer;

   $buffer->set("namespace.name", "value here");
   ```

   The name of the variable may include namespaces using dot notation, for example, `vars.page.title`, `tables.main.headers`, etc.

4. **Get a Variable**: You can use dot notation to get the variable value. For example, if you set an array as follows:

   ```php
   $buffer->set("page.title", ["title" => "great", "subTitle" => "awesome title", "separator" => "|"]);
   ```

   Then:

   ```php
   $buffer->get("page.title.title"); // => great
   $buffer->get("page.title.subTitle"); // => awesome title
   $buffer->get("page.title"); // => ["title" => "great", "subTitle" => "awesome title", "separator" => "|"]
   ```

5. **Unset a Variable**: You can use dot notation to unset variables. For example:

   ```php
   $buffer->unset("page.title");
   ```

6. **Attach an Observer**: It is possible to attach observers to watch buffer elements and get notified if a change occurs.

For example:

   ```php
   $buffer->attach("page.title", $observer, "main");
   ```
Now, by any changes in `page.title`, `$observer` will be notified throughout `notify($scope, $name, $oldValue, $value)` method of `$observer`.


## Feature Request

If you need a feature that is missing from this package, just [create an issue](https://github.com/PHPallas/Buffer/issues).

## Contribution

All types of contributions (development, testing, translation) are welcome! You can contribute to this package to make it better and more usable.

## License

This package is licensed under the [MIT License](https://github.com/PHPallas/Buffer#MIT-1-ov-file).
