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
        "name": "OrderShipped"
      },
      {
        "type": "number",
        "name": "OrderID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "updOrder",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "orders",
                "column": "OrderShipped",
                "type": "number",
                "value": "{{$_POST.OrderShipped}}"
              }
            ],
            "table": "orders",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "OrderID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.OrderID}}",
                  "data": {
                    "column": "OrderID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "UPDATE orders\nSET OrderShipped = :P1 /* {{$_POST.OrderShipped}} */\nWHERE OrderID = :P2 /* {{$_POST.OrderID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.OrderShipped}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P2",
                "value": "{{$_POST.OrderID}}"
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