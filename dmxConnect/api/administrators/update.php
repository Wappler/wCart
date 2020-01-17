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
    "$_POST": [
      {
        "type": "number",
        "name": "UserLevel"
      },
      {
        "type": "text",
        "name": "UserName"
      },
      {
        "type": "text",
        "name": "UserPassword"
      },
      {
        "type": "number",
        "name": "UserID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "updAdministrator",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
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
                "value": "{{$_POST.UserPassword}}"
              }
            ],
            "table": "users",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "UserID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.UserID}}",
                  "data": {
                    "column": "UserID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "UPDATE users\nSET UserLevel = :P1 /* {{$_POST.UserLevel}} */, UserName = :P2 /* {{$_POST.UserName}} */, UserPassword = :P3 /* {{$_POST.UserPassword}} */\nWHERE UserID = :P4 /* {{$_POST.UserID}} */",
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
                "value": "{{$_POST.UserPassword}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P4",
                "value": "{{$_POST.UserID}}"
              }
            ]
          }
        },
        "meta": [
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