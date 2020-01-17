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
      "linkedFile": "/admin/index.html",
      "linkedForm": "frmAdministratorInsert"
    },
    "$_POST": [
      {
        "type": "text",
        "fieldName": "UserLevel",
        "options": {
          "rules": {
            "core:required": {
              "param": ""
            }
          }
        },
        "name": "UserLevel"
      },
      {
        "type": "text",
        "fieldName": "UserName",
        "options": {
          "rules": {
            "core:required": {
              "param": ""
            }
          }
        },
        "name": "UserName"
      },
      {
        "type": "text",
        "fieldName": "UserPassword",
        "options": {
          "rules": {
            "core:required": {
              "param": ""
            }
          }
        },
        "name": "UserPassword"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "validate",
        "module": "validator",
        "action": "validate",
        "options": {
          "data": [
            {
              "name": "validate_1",
              "value": "",
              "rules": {
                "db:notexists": {
                  "param": {
                    "connection": "db",
                    "table": "users",
                    "column": "UserName"
                  }
                }
              },
              "fieldName": "UserName"
            }
          ]
        }
      },
      {
        "name": "insAdministrator",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "db",
          "sql": {
            "type": "insert",
            "values": [
              {
                "table": "users",
                "column": "UserLevel",
                "type": "number",
                "value": "{{$_POST.UserLevel}}"
              },
              {
                "table": "users",
                "column": "UserName",
                "type": "text",
                "value": "{{$_POST.UserName}}"
              },
              {
                "table": "users",
                "column": "UserPassword",
                "type": "text",
                "value": "{{$_POST.UserPassword.sha256(\"wcart$\")}}"
              }
            ],
            "table": "users",
            "query": "INSERT INTO users\n(UserLevel, UserName, UserPassword) VALUES (:P1 /* {{$_POST.UserLevel}} */, :P2 /* {{$_POST.UserName}} */, :P3 /* {{$_POST.UserPassword.sha256(\"wcart$\")}} */)",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.UserLevel}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.UserName}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.UserPassword.sha256(\"wcart$\")}}"
              }
            ]
          }
        },
        "meta": [
          {
            "name": "identity",
            "type": "text"
          },
          {
            "name": "affected",
            "type": "number"
          }
        ]
      }
    ]
  }
}
JSON
);
?>