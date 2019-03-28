# Magento Store Configurations 


## Installation

```
composer install alaa/magento2-store-config
php -f bin/magento module:enable Alaa_StoreConfig
php -f bin/magento setup:upgrade
```

## How it works

### Dumping the data
you would first run the following command:

`php -f bin/magento store-config:dump`

The above command will dump the data in the `core_config_data` table to the config files. The data will be broken into the following sections:
* The folder `app/etc/store-config`
* Deploy mode`developer` resulting in paths `app/etc/store-config/developer`
* Scopes which will be resulting into:
    * `app/etc/store-config/developer/default`
    * `app/etc/store-config/developer/stores`
    * `app/etc/store-config/developer/websites`
* Then into default, store-code and website-code such as:
    * `app/etc/store-config/developer/default/default.php`
    * `app/etc/store-config/developer/stores/default.php`
    * `app/etc/store-config/developer/websites/base.php`

Sensitive Data will not be dumped as setting sensitive data should not be done via version control - click [here](https://devdocs.magento.com/guides/v2.3/extension-dev-guide/configuration/sensitive-and-environment-settings.html) to find out more about sensitive configurations.

The command `php -f bin/magento store-config:dump` will dump the data initially so development can start from that point. Then configurations can be added as needed and thus these configurations can be shared among the team to keep the same configuration across local environments.
The breakdown into development and production modes will help keep the configurations separate in case configurations in production vary from the development environment.

You have to be in production mode to generate configs for the production, however you can create them manually to `app/etc/store-config/production`.

Sample configuration file:
`app/etc/store-config/developer/default/default.php`
```php
<?php

declare(strict_types=1);

return [
    [
        'path' => 'web/seo/use_rewrites',
        'value' => '1',
    ],
    [
            'path' => 'general/locale/code',
            'value' => 'en_GB',
    ],
];
```

The configurations for production mode will sit inside `app/etc/store-config/production`.

production configurations need to be manually added if you are in developer mode.

### Checking the data

Once more configurations are added to the files, they can be checked by the following command:

`php -f bin/magento store-config:check`

The above will check the files for any missing arguments which are mainly the `path` and the `value`.

Any sensitive data will be flagged out and will advise to remove them from the configuration files.

Once check is done, add these files to `git`

### Running the configuration

`php -f bin/magento store-config:configure`

The above command will write the configurations from the files to the `core_config_data` table.

The configuration will be written based on the deploy mode.

The above command is safe to run as many times.

### The Recurring Script

The recurring script will write the configurations to the `core_config_data` table.

The configurations are deploy mode based.

### Configurations

The module can be configured from the admin:
* Enable/Disable the module functionality
* Enable/Disable loggers (file and/or console loggers)
* Enable/Disable the Recurring scripts

## Contribution
Feel free to raise issues and contribute.

## License
MIT

