Latte filters
=============

Latte |filter supporting filtering.


## Installation

The best way to install **tacoberu/latte-filters** is using  [Composer](http://getcomposer.org/):

```sh
$ composer require tacoberu/latte-filters
```

Then register the extension in the config file:
```yaml
# app/config/config.neon
latte:
    extensions:
        assetMacro: Webrouse\AssetMacro\DI\Extension
```


## Usage

```latte
{foreach ($items|filter: fn($x) => strlen($x->name)) as $row}
	...
{/foreach}
```


## License

Latte filters is under the MIT license. See the [LICENSE](LICENSE) file for details.
