<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "settings": {
    "options": {}
  },
  "meta": {
    "options": {}
  },
  "exec": {
    "steps": [
      "SecurityProviders/sitesecurity",
      {
        "name": "",
        "module": "auth",
        "action": "logout",
        "options": {
          "provider": "sitesecurity"
        }
      }
    ]
  }
}
JSON
);
?>