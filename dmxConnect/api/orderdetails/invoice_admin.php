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
              },
              {
                "table": "customers",
                "column": "CustomerEmail"
              },
              {
                "table": "customers",
                "column": "CustomerFirstName"
              },
              {
                "table": "customers",
                "column": "CustomerLastName"
              },
              {
                "table": "customers",
                "column": "CustomerAddress"
              },
              {
                "table": "customers",
                "column": "CustomerCity"
              },
              {
                "table": "customers",
                "column": "CustomerState"
              },
              {
                "table": "customers",
                "column": "CustomerZip"
              },
              {
                "table": "customers",
                "column": "CustomerCountry"
              }
            ],
            "table": {
              "name": "orders"
            },
            "joins": [
              {
                "table": "customers",
                "column": "*",
                "type": "INNER",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "customers",
                      "column": "CustomerID",
                      "operator": "equal",
                      "value": {
                        "table": "orders",
                        "column": "OrderCustomerID"
                      },
                      "operation": "="
                    }
                  ]
                }
              }
            ],
            "query": "SELECT orders.*, customers.CustomerEmail, customers.CustomerFirstName, customers.CustomerLastName, customers.CustomerAddress, customers.CustomerCity, customers.CustomerState, customers.CustomerZip, customers.CustomerCountry\nFROM orders\nINNER JOIN customers ON (customers.CustomerID = orders.OrderCustomerID)",
            "params": []
          }
        },
        "output": false,
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
          },
          {
            "name": "CustomerEmail",
            "type": "text"
          },
          {
            "name": "CustomerFirstName",
            "type": "text"
          },
          {
            "name": "CustomerLastName",
            "type": "text"
          },
          {
            "name": "CustomerAddress",
            "type": "text"
          },
          {
            "name": "CustomerCity",
            "type": "text"
          },
          {
            "name": "CustomerState",
            "type": "text"
          },
          {
            "name": "CustomerZip",
            "type": "text"
          },
          {
            "name": "CustomerCountry",
            "type": "text"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "rptOrders",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{qryOrders}}",
          "outputFields": [
            "OrderID",
            "OrderAmount",
            "OrderShipped",
            "CustomerEmail",
            "CustomerFirstName",
            "CustomerLastName",
            "CustomerAddress",
            "CustomerCity",
            "CustomerState",
            "CustomerZip",
            "CustomerCountry",
            "OrderDate"
          ],
          "exec": {
            "steps": {
              "name": "qryOrderDetails",
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
                        "value": "{{OrderID}}",
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
                  "query": "SELECT *\nFROM orderdetails\nWHERE DetailOrderID = :P1 /* {{OrderID}} */",
                  "params": [
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P1",
                      "value": "{{OrderID}}"
                    }
                  ]
                }
              },
              "output": true,
              "meta": [],
              "outputType": "array"
            }
          }
        },
        "output": true,
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
          },
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
          },
          {
            "name": "CustomerEmail",
            "type": "text"
          },
          {
            "name": "CustomerFirstName",
            "type": "text"
          },
          {
            "name": "CustomerLastName",
            "type": "text"
          },
          {
            "name": "CustomerAddress",
            "type": "text"
          },
          {
            "name": "CustomerCity",
            "type": "text"
          },
          {
            "name": "CustomerState",
            "type": "text"
          },
          {
            "name": "CustomerZip",
            "type": "text"
          },
          {
            "name": "CustomerCountry",
            "type": "text"
          }
        ],
        "outputType": "array"
      }
    ]
  }
}
JSON
);
?>