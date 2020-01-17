<?php
$exports = <<<'JSON'
{
  "name": "sitesecurity",
  "module": "auth",
  "action": "provider",
  "options": {
    "secret": "u788f1jTAucHMhF",
    "provider": "Database",
    "connection": "db",
    "users": {
      "table": "customers",
      "identity": "CustomerID",
      "username": "CustomerEmail",
      "password": "CustomerPassword"
    },
    "permissions": {}
  },
  "meta": [
    {
      "name": "identity",
      "type": "text"
    }
  ]
}
JSON;
?>