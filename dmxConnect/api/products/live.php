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
        "name": "ProductLive"
      },
      {
        "type": "number",
        "name": "ProductID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "updProductLive",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "products",
                "column": "ProductLive",
                "type": "number",
                "value": "{{$_POST.ProductLive}}"
              }
            ],
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
            "query": "UPDATE products\nSET ProductLive = :P1 /* {{$_POST.ProductLive}} */\nWHERE ProductID = :P2 /* {{$_POST.ProductID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.ProductLive}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P2",
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