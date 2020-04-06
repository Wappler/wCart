<?php
$exports = <<<'JSON'
{
  "name": "adminsecurity",
  "module": "auth",
  "action": "provider",
  "options": {
    "secret": "u788f1jTAucHMhF",
    "provider": "Database",
    "connection": "db",
    "users": {
      "table": "users",
      "identity": "UserID",
      "username": "UserName",
      "password": "UserPassword"
    },
    "permissions": {
      "Manager": {
        "table": "users",
        "identity": "UserID",
        "conditions": [
          {
            "column": "UserLevel",
            "operator": "=",
            "value": "Manager"
          }
        ]
      },
      "Supervisor": {
        "table": "users",
        "identity": "UserID",
        "conditions": [
          {
            "column": "UserLevel",
            "operator": "=",
            "value": "Supervisor"
          }
        ]
      },
      "Sales Manager": {
        "table": "users",
        "identity": "UserID",
        "conditions": [
          {
            "column": "UserLevel",
            "operator": "=",
            "value": "Sales Manager"
          }
        ]
      },
      "Products Manager": {
        "table": "users",
        "identity": "UserID",
        "conditions": [
          {
            "column": "UserLevel",
            "operator": "=",
            "value": "Products Manager"
          }
        ]
      }
    },
    "path": "/admin"
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