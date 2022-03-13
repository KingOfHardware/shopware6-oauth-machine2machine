## Shopware 6 Api von Server zu Server Authentifizierung
Ich war auf der Suche nach einer Lösung für die Anmeldung an die Shopware 6 Api
Schnittstelle da ich diese öfter brauchte und es sich wiederholte habe ich 
mir diese kleine Lösung geschrieben.

Also wenn man sich von Server(Shopware 6 System) zu Server(PHP Client) mit Shopware
verbinden möchte langt es dies auf **client_credentials** basis zu machen da die Lebenszeit der
Shopware Authentifizierung-Token auf 10 Minuten beschränkt ist.  So Schicken wir wenigstens nicht das 
benutzer Password durch die gegend und können im Shopware Backend benutzer mit 
eingeschränkten rechten anlegen.

# Shopware 6 Authentication Machine to Machine

The little authentication for machine to machine for Shopware 6.

# Requirement

PHP >=7.4

# Install

Use composer

```
"repositories": [{
    "type": "github",
    "url": "https://github.com/KingOfHardware/shopware6-oauth-machine2machine.git"
  }],
  "require": {
    "KingOfHardware/shopware6-oauth-machine2machine": "dev-master"
  }
```

Create in the shopware admin a Api user with credentials and rights.  

Add credentials to your own **putenv** **/config/env.php** or over setter from class (**ShopwareAuthentication**).
Use the class with a service or cronjob.

Remove the  **/tests folder** you don't need it is example

## Settings

```
putenv('SHOP_URL=localhost'); // exampleshop.de
putenv('SW_API_CLIENT_ID=XXXXXXXXXXXXXXXXXXXXXXXXXX'); // Set for api user in Shopware
putenv('SW_API_CLIENT_SECRET=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'); // Shapware system genaratet key
putenv('OAUTH_GRAND_TYPE=client_credentials');  // this type you must not change
```

### Usage
`index.php // example`

```
use Kingofhardware\ShopwareAuthentication;

require_once ('../config/config.php');
require_once ('../vendor/autoload.php');

$auth = new ShopwareAuthentication();

print_r($auth->getToken());
```