# WeezBadge
Badge management tools for Weezevent


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