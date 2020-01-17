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
        "type": "text",
        "name": "UserID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "delAdministrator",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
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
            "query": "DELETE\nFROM users\nWHERE UserID = :P1 /* {{$_POST.UserID}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
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