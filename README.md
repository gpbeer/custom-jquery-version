# Custom Google hosted CDN version of Jquery for wordpress
This plugin will de-register and replace the WordPress own copy of JQuery by a Google hosted CDN version.

### Installation ##

- Upload the folder to the `/wp-content/plugins/` directory.
- Activate the plugin through the 'Plugins' menu in WordPress.

### Install using composer

Add to your composer.json

```
"repositories": [
   ...
    {
      "type": "vcs",
      "url": "git@github.com:german-pichardo/custom-jquery-version.git"
    }
],
```

Run 
```bash
composer require gp/custom-jquery-version
```

### Or

Clone project :

```bash
cd wp-content/plugins
git clone git@github.com:german-pichardo/custom-jquery-version.git
cd custom-jquery-version
```

### Development and Coding standards

Check [WordPress-Coding-Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer).

- `composer install` to install PHP dev dependencies
- `composer lint` to lint PHP files with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer).
- `composer lint:fix` to fix the PHP files with [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer).

## Author

**German Pichardo**

* [github/german-pichardo](https://github.com/german-pichardo)
* [http://german-pichardo.com](http://german-pichardo.com)


