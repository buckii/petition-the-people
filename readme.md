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
    <?php return '%environment%'; ?>
    ```

### Environment-specific configuration

Default settings are within the main app config files, but you'll need to take care of a few yourself (namely the database and mail settings). You can [read up on environment-specific overrides to config files](http://laravel.com/docs/configuration) on the Laravel site.

**A few config options you'll want to make sure you change before deploying:**

* app.debug
* app.url
* app.key
* database.default
* database.connections
* mail.from
* wethepeople.api_key

Additionally, if you're using an environment name besides "development", "staging", or "production" you'll want to make sure your config information isn't being committed to the repository!

### Database migrations

Once you've created a database for the application and provided Laravel with the credentials, you'll need to run the following (updating the `--env` flag as appropriate) to get the database structure in place:

```
php artisan migrate --env=development
```

### We The People API key

In order to collect signatures, it's necessary to [acquire an API key from We The People](#). This key will go into your environment-specific app/config/{environment}/wethepeople.php file for the `api_key` key.

### Google Analytics

If you'd like to use Google Analytics with your copy of the application, simply put your Universal Analytics profile ID in wethepeople.google_analytics_profile_id and it will automatically be loaded on each page.

### Cron setup

There are a few tasks available through Artisan to perform maintenance on the application:

* `wtp:refresh-petitions` - Update any cached petitions that are more than an hour old
* `wtp:resend-signatures` - Attempt to re-submit any signatures that received a response other than "200"

These tasks can be called in a batch via the `wtp:cron` task. To keep the data flowing smoothly, it's recommended that you create a system cron job to execute our cron task runner every 5-10min:

```bash
php /path/to/app/artisan wtp:cron --env=your-environment -q
```

## Contributing

We'd be happy to review any pull requests made against the application. This early version of the app is more focused on collecting signatures than spitting out data, but insights on the people signing the petitions would be rad. Translations into other languages (especially Spanish) would also be greatly appreciated, as the app is translation-ready. Read [the Laravel documentation on localization](http://laravel.com/docs/localization) to get started.

### Roadmap

The following are features that would be nice to implement before (or shortly after) the release of the public write API:

* Insights, reports, and other data to help organizations understand their constituents
* Multiple users per organization
* Better Google Analytics integration, including the ability to add a profile ID per campaign
* The ability for organizations to brand (or at least put their logo on) campaigns
* Integrations with newsletters, CRM tools, etc.
* Email notifications (petition crosses certain threshold, activity summaries, receipt of signed petitions, etc.)

### Special thanks

Special thanks to [Tony Todoroff](http://www.georgetodoroff.com/) for logo design and general support.

## License

Petition the People petition campaign tool
Copyright (C) 2014 Buckeye Interactive

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.