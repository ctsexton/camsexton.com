# Website: camsexton.com
## Author: Cam Sexton
###### Read my code in /themes/artistsite

How to set it up (i.e. notes to myself):

1. Do not clone repo first. Use composer to create a new OctoberCMS project, this will be the directory you serve the site from:
```
composer create-project october/october camsexton.com
```
2. Create a database file, use SQLite3 since it's easy and works well for this app. Manually copy over from local or create a new one. Either way name it should be named storage/database.sqlite
3. Follow the instructions at https://octobercms.com/docs/console/commands#console-install but the main command to run is:
```
php artisan october:install
```
4. Then we init this directory and add the github repo as a remote.
```
git init
git remote add origin https://github.com/ctsexton/camsexton.com.git
git pull
git checkout -f origin/master
git submodule update
```
5. Run composer update on the new composer.json and optionally (for dev environment) install node modules with npm:
```
composer update
npm install
```
6. Convert to dotenv mode in order to use the API keys:
```
php artisan october:env
```
7. At this point you should be good to go code-wise. You will need to manually copy over all files in storage/app for images, media etc. Also do not forget to manually copy over all plugins. If it all goes well and you transfer the database file then it should all be configured.
8. You will also need to add an API key (enabled for Google Calendar API) as GCAL_API_KEY to your .env file.
