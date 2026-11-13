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
        - Taco\Latte\FilterLatteExtension
```


## Usage

```latte
{foreach ($items|filter: fn($x) => strlen($x->name)) as $row}
	...
{/foreach}
```

```latte
{foreach ($items|group: category) as $category => $group}
	{foreach $group as $item}
		...
	{/foreach}
{/foreach}
```

`group` seskupuje souvislé i nesouvislé prvky podle klíče/vlastnosti nebo closure
(`fn($item, $key) => ...`), zachovává klíče a pořadí; chování shodné s Latte 3.


## License

Latte filters is under the MIT license. See the [LICENSE](LICENSE) file for details.
