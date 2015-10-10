# DB Helper

Add this package to your Laravel installation and visit /dbhelper in your browser to see suggested table schema changes. It can show you columns that are too big, but also columns that are coming up to their limit.  
FOR LOCAL USE ONLY. DO NOT USE THIS IN PRODUCTION. There is no protection on the root, so people would be able to spy on your database structure.  
This package does not support signed integers yet.
Please use GitHub to raise any issues and suggest any improvements.

## Install

Via Composer

``` bash
$ composer require-dev votemike/dbhelper
```

## Usage

Visit /dbhelper in your browser to see a list of suggested improvements

## Future Improvements

* Support signed integers
* Suggest missing indexes/foreign keys

## Credits

- [Michael Gwynne](http://www.votemike.co.uk)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/votemike
