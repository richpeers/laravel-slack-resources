# laravel-slack-resources
Laravel package for saving url resources from a slack command

This will intercept slack command `/resource https://useful-url tag`, authenticate against a slack signing secret key, record the urlk and associate tags. It will then dispatch a queued job to fetch the site's meta data and title.

##Install:
`composer require richpeers/laravel-slack-resources`

Run migrations
`php artisan migrate`

Setup slack app
1. Create new app
2. Add command
3. point commmand post to your url eg `https:://your-url/api/resources
4. Install the app to your slack workspace

Add the slack app's signing sectet to .env
`SLACK_SIGNING_SECRET=your_slack_app_signing_secret`
