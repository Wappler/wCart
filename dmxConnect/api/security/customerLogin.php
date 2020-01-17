<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "settings": {
    "options": {}
  },
  "meta": {
    "options": {
      "linkedFile": "/index.html",
      "linkedForm": "frmLoginCustomer"
    },
    "$_POST": [
      {
        "type": "text",
        "fieldName": "username",
        "name": "username"
      },
      {
        "type": "text",
        "fieldName": "password",
        "name": "password"
      },
      {
        "type": "text",
        "fieldName": "remember",
        "name": "remember"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      "SecurityProviders/sitesecurity",
      {
        "name": "identity",
        "module": "auth",
        "action": "login",
        "options": {
          "provider": "sitesecurity",
          "password": "{{$_POST.password.sha256(\"wcart$\")}}"
        },
        "output": true,
        "meta": []
      }
    ]
  }
}
JSON
);
?>