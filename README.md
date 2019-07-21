# laravel-slack-resources

[![Latest Stable Version](https://poser.pugx.org/richpeers/laravel-slack-resources/v/stable)](https://packagist.org/packages/richpeers/laravel-slack-resources)
[![Total Downloads](https://poser.pugx.org/richpeers/laravel-slack-resources/downloads)](https://packagist.org/packages/richpeers/laravel-slack-resources)
[![Latest Unstable Version](https://poser.pugx.org/richpeers/laravel-slack-resources/v/unstable)](https://packagist.org/packages/richpeers/laravel-slack-resources)
[![License](https://poser.pugx.org/richpeers/laravel-slack-resources/license)](https://packagist.org/packages/richpeers/laravel-slack-resources)

Laravel package for saving url resources from a slack command

This will intercept slack command `/resource https://useful-url tag`, authenticate against a slack signing secret key, record the URL and associated tags. It will then dispatch a queued job to fetch the site's meta data and title.

## Install:
`composer require richpeers/laravel-slack-resources`

Run migrations
`php artisan migrate`

### Setup slack app
1. Create new app
2. Add command
3. point commmand post to your url eg `https:://your-url/api/resources`
4. Install the app to your slack workspace
5.Add the slack app's signing sectet to .env
`SLACK_SIGNING_SECRET=your_slack_app_signing_secret`
