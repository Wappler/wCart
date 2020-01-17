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
        "name": "filter"
      },
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
        "action": "single",
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
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "orders.OrderID",
                  "field": "orders.OrderID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_GET.filter}}",
                  "data": {
                    "table": "orders",
                    "column": "OrderID",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM orders\nWHERE OrderID = :P1 /* {{$_GET.filter}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.filter}}"
              }
            ]
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
        "outputType": "object",
        "type": "dbconnector_single",
        "output": true
      },
      {
        "name": "rptOrder",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{qryOrders}}",
          "outputFields": [
            "OrderID",
            "OrderAmount",
            "OrderDate"
          ],
          "exec": {
            "steps": {
              "name": "qryOrderDetail",
              "module": "dbconnector",
              "action": "select",
              "options": {
                "connection": "db",
                "sql": {
                  "type": "SELECT",
                  "columns": [
                    {
                      "table": "orderdetails",
                      "column": "*"
                    }
                  ],
                  "table": {
                    "name": "orderdetails"
                  },
                  "joins": [],
                  "wheres": {
                    "condition": "AND",
                    "rules": [
                      {
                        "id": "orderdetails.DetailOrderID",
                        "field": "orderdetails.DetailOrderID",
                        "type": "double",
                        "operator": "equal",
                        "value": "{{$parent.qryOrders.OrderID}}",
                        "data": {
                          "table": "orderdetails",
                          "column": "DetailOrderID",
                          "type": "number"
                        },
                        "operation": "="
                      }
                    ],
                    "conditional": null,
                    "valid": true
                  },
                  "query": "SELECT *\nFROM orderdetails\nWHERE DetailOrderID = :P1 /* {{$parent.qryOrders.OrderID}} */",
                  "params": [
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P1",
                      "value": "{{$parent.qryOrders.OrderID}}"
                    }
                  ]
                }
              },
              "output": true,
              "meta": [
                {
                  "name": "DetailID",
                  "type": "number"
                },
                {
                  "name": "DetailOrderID",
                  "type": "number"
                },
                {
                  "name": "DetailProductID",
                  "type": "number"
                },
                {
                  "name": "DetailName",
                  "type": "text"
                },
                {
                  "name": "DetailPrice",
                  "type": "number"
                },
                {
                  "name": "DetailSKU",
                  "type": "text"
                },
                {
                  "name": "DetailQuantity",
                  "type": "number"
                }
              ],
              "outputType": "array"
            }
          }
        },
        "meta": [
          {
            "name": "$index",
            "type": "number"
          },
          {
            "name": "$number",
            "type": "number"
          },
          {
            "name": "$name",
            "type": "text"
          },
          {
            "name": "$value",
            "type": "object"
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