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
      "SecurityProviders/sitesecurity",
      {
        "name": "",
        "module": "auth",
        "action": "restrict",
        "options": {
          "provider": "sitesecurity"
        }
      },
      {
        "name": "qryOrders",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "orders",
                "column": "*"
              }
            ],
            "table": {
              "name": "orders"
            },
            "joins": [],
            "query": "SELECT *\nFROM orders\nWHERE OrderCustomerID = :P1 /* {{sitesecurity.identity}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{sitesecurity.identity}}"
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "orders.OrderCustomerID",
                  "field": "orders.OrderCustomerID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{sitesecurity.identity}}",
                  "data": {
                    "table": "orders",
                    "column": "OrderCustomerID",
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
        "meta": [
          {
            "name": "OrderID",
            "type": "number"
          },
          {
            "name": "OrderCustomerID",
            "type": "number"
          },
          {
            "name": "OrderAmount",
            "type": "number"
          },
          {
            "name": "OrderShipName",
            "type": "text"
          },
          {
            "name": "OrderShipAddress",
            "type": "text"
          },
          {
            "name": "OrderShipAddress2",
            "type": "text"
          },
          {
            "name": "OrderCity",
            "type": "text"
          },
          {
            "name": "OrderState",
            "type": "text"
          },
          {
            "name": "OrderZip",
            "type": "text"
          },
          {
            "name": "OrderCountry",
            "type": "text"
          },
          {
            "name": "OrderPhone",
            "type": "text"
          },
          {
            "name": "OrderPostage",
            "type": "number"
          },
          {
            "name": "OrderTax",
            "type": "number"
          },
          {
            "name": "OrderEmail",
            "type": "text"
          },
          {
            "name": "OrderDate",
            "type": "datetime"
          },
          {
            "name": "OrderShipped",
            "type": "number"
          },
          {
            "name": "OrderTrackingNumber",
            "type": "text"
          }
        ],
        "outputType": "array",
        "output": true
      }
    ]
  }
}
JSON
);
?>