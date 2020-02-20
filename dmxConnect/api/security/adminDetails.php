<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "settings": {
    "options": {}
  },
  "meta": {
    "options": {},
    "$_GET": [
      {
        "type": "text",
        "name": "sort"
      },
      {
        "type": "text",
        "name": "dir"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      "SecurityProviders/adminsecurity",
      {
        "name": "",
        "module": "auth",
        "action": "restrict",
        "options": {
          "provider": "adminsecurity"
        }
      },
      {
        "name": "qryUsers",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "users",
                "column": "*"
              }
            ],
            "table": {
              "name": "users"
            },
            "joins": [],
            "query": "SELECT *\nFROM users\nWHERE UserID = :P1 /* {{adminsecurity.identity}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{adminsecurity.identity}}"
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "users.UserID",
                  "field": "users.UserID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{adminsecurity.identity}}",
                  "data": {
                    "table": "users",
                    "column": "UserID",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            }
          }
        },
        "output": true,
        "meta": [
          {
            "name": "UserID",
            "type": "number"
          },
          {
            "name": "UserName",
            "type": "text"
          },
          {
            "name": "UserPassword",
            "type": "text"
          },
          {
            "name": "UserLevel",
            "type": "text"
          }
        ],
        "type": "dbconnector_single",
        "outputType": "object"
      }
    ]
  }
}
JSON
);
?>