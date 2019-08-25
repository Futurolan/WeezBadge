# WeezBadge
Badge management tools for Weezevent

Requirements
------------
* PHP 7.3
* MariaDB 10.2.7 or MySQL 5.7.8
* [Composer](https://getcomposer.org/)
* A [Google Oauth 2.0 API Key](https://developers.google.com/identity/protocols/OAuth2)
* A Weezevent API Key and Token (contact Weezevent for getting one)

Installation
------------

    $ composer create-project futurolan/weezbadge

Configuration
-------------

Create a file name '.env.local' in project root (weezevent/).

    # Symfony
    APP_ENV=prod
    APP_SECRET=<secret>
    
    # Google API
    OAUTH_GOOGLE_CLIENT_ID=<your google oauth id>
    OAUTH_GOOGLE_CLIENT_SECRET=<your google oauth secret>
    
    # Weezevent
    WEEZEVENT_API_KEY=<weezevent api key>
    WEEZEVENT_API_TOKEN=<weezevent api token>
    
    # MySQL Database
    DATABASE_URL=mysql://user:password@127.0.0.1:3306/database
    
    # Administrator
    SUPER_ADMIN_EMAIL=user@domain.com


Database initialisation
-----------------------

    $ bin/console doctrine:migrations:migrate
    
Webserver configuration
-----------------------

Please refer to Symfony 4 documentation on how to properly configure your web server : https://symfony.com/doc/current/setup/web_server_configuration.html