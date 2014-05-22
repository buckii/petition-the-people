# Petition the People

## Installation

To get started, clone this repository then run `php composer update` to install application dependencies.

### Setting the application environment

In order to avoid hard-coded environment names, bootstrap/start.php has been configured to look in two places for the application environment:

1. A server variable, `APP_ENVIRONMENT` (you can set this in Apache by adding the following to your VirtualHost):
    ```
    SetEnv APP_ENVIRONMENT development
    ```

2. Create a new file at bootstrap/environment.php with the following contents (replacing %environment% with your desired environment name):
    ```
    <?php return '%environment'; ?>
    ```

### Environment-specific configuration

Default settings are within the main app config files, but you'll need to take care of a few yourself (namely the database and mail settings). You can [read up on environment-specific overrides to config files](http://laravel.com/docs/configuration) on the Laravel site.

### Database migrations

Once you've created a database for the application and provided Laravel with the credentials, you'll need to run the following (updating the `--env` flag as appropriate) to get the database structure in place:

```
php artisan migrate --env=development
```

### We The People API key

In order to collect signatures, it's necessary to [acquire an API key from We The People](#). This key will go into your environment-specific app/config/{environment}/wethepeople.php file for the `api_key` key.

### Cron setup

To reduce reliance on the We The People API, local copies of petitions that are being used by the system are stored in the `petitions` table. In order to keep signature counts, statuses, etc. in sync the following command should be set up to run with cron, ideally every 15min or so:

```bash
php /path/to/app/artisan wtp:refresh-petitions --env=your-environment -q
```


## Contributing

We'd be happy to review any pull requests made against the application. This early version of the app is more focused on collecting signatures than spitting out data, but insights on the people signing the petitions would be rad. Translations into other languages (especially Spanish) would also be greatly appreciated, as the app is translation-ready. Read [the Laravel documentation on localization](http://laravel.com/docs/localization) to get started.

## License

Petition the People petition campaign tool
Copyright (C) 2014 Buckeye Interactive

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.