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
        "name": "CustomerID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "delCustomer",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
            "table": "customers",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "CustomerID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.CustomerID}}",
                  "data": {
                    "column": "CustomerID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "DELETE\nFROM customers\nWHERE CustomerID = :P1 /* {{$_POST.CustomerID}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.CustomerID}}"
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