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
      "linkedFile": "/admin/login.html",
      "linkedForm": "frmLogin"
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
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      "SecurityProviders/adminsecurity",
      {
        "name": "identity",
        "module": "auth",
        "action": "login",
        "options": {
          "provider": "adminsecurity",
          "password": "{{$_POST.password .sha256(\"wcart$\")}}"
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