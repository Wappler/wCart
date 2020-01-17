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
        "name": "ProductID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "delProduct",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
            "table": "products",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "ProductID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.ProductID}}",
                  "data": {
                    "column": "ProductID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "DELETE\nFROM products\nWHERE ProductID = :P1 /* {{$_POST.ProductID}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.ProductID}}"
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