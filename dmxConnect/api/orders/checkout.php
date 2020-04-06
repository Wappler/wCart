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
      "linkedFile": "/checkout.php",
      "linkedForm": "frmPay"
    },
    "$_POST": [
      {
        "type": "text",
        "fieldName": "customerid",
        "name": "customerid"
      },
      {
        "type": "text",
        "fieldName": "customername",
        "name": "customername"
      },
      {
        "type": "text",
        "fieldName": "customeremail",
        "name": "customeremail"
      },
      {
        "type": "text",
        "fieldName": "subtotal",
        "name": "subtotal"
      },
      {
        "type": "array",
        "name": "record",
        "sub": [
          {
            "type": "text",
            "fieldName": "record[{{$index}}][productname]",
            "name": "productname"
          },
          {
            "type": "text",
            "fieldName": "record[{{$index}}][price]",
            "name": "price"
          },
          {
            "type": "text",
            "fieldName": "record[{{$index}}][qty]",
            "name": "qty"
          },
          {
            "type": "number",
            "name": "$parent.insOrder.identity"
          }
        ]
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{$_POST.subtotal > 0}}",
          "then": {
            "steps": [
              {
                "name": "insOrder",
                "module": "dbupdater",
                "action": "insert",
                "options": {
                  "connection": "db",
                  "sql": {
                    "type": "insert",
                    "values": [
                      {
                        "table": "orders",
                        "column": "OrderAmount",
                        "type": "number",
                        "value": "{{$_POST.subtotal}}"
                      },
                      {
                        "table": "orders",
                        "column": "OrderCustomerID",
                        "type": "number",
                        "value": "{{$_POST.customerid}}"
                      }
                    ],
                    "table": "orders",
                    "query": "INSERT INTO orders\n(OrderAmount, OrderCustomerID) VALUES (:P1 /* {{$_POST.subtotal}} */, :P2 /* {{$_POST.customerid}} */)",
                    "params": [
                      {
                        "name": ":P1",
                        "type": "expression",
                        "value": "{{$_POST.subtotal}}"
                      },
                      {
                        "name": ":P2",
                        "type": "expression",
                        "value": "{{$_POST.customerid}}"
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
              },
              {
                "name": "lastinvoice",
                "module": "core",
                "action": "setvalue",
                "options": {
                  "value": "{{insOrder.identity}}"
                },
                "outputType": "text",
                "output": true
              },
              {
                "name": "rptOrderDetails",
                "module": "core",
                "action": "repeat",
                "options": {
                  "repeat": "{{$_POST.record}}",
                  "outputFields": [
                    "productname",
                    "price",
                    "qty",
                    "$parent.insOrder.identity"
                  ],
                  "exec": {
                    "steps": {
                      "name": "insOrderDetail",
                      "module": "dbupdater",
                      "action": "insert",
                      "options": {
                        "connection": "db",
                        "sql": {
                          "type": "insert",
                          "values": [
                            {
                              "table": "orderdetails",
                              "column": "DetailName",
                              "type": "text",
                              "value": "{{productname}}"
                            },
                            {
                              "table": "orderdetails",
                              "column": "DetailOrderID",
                              "type": "number",
                              "value": "{{$parent.insOrder.identity}}"
                            },
                            {
                              "table": "orderdetails",
                              "column": "DetailPrice",
                              "type": "number",
                              "value": "{{price}}"
                            },
                            {
                              "table": "orderdetails",
                              "column": "DetailQuantity",
                              "type": "number",
                              "value": "{{qty}}"
                            }
                          ],
                          "table": "orderdetails",
                          "query": "INSERT INTO orderdetails\n(DetailName, DetailOrderID, DetailPrice, DetailQuantity) VALUES (:P1 /* {{productname}} */, :P2 /* {{$parent.insOrder.identity}} */, :P3 /* {{price}} */, :P4 /* {{qty}} */)",
                          "params": [
                            {
                              "name": ":P1",
                              "type": "expression",
                              "value": "{{productname}}"
                            },
                            {
                              "name": ":P2",
                              "type": "expression",
                              "value": "{{$parent.insOrder.identity}}"
                            },
                            {
                              "name": ":P3",
                              "type": "expression",
                              "value": "{{price}}"
                            },
                            {
                              "name": ":P4",
                              "type": "expression",
                              "value": "{{qty}}"
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
                  },
                  {
                    "name": "productname",
                    "type": "text"
                  },
                  {
                    "name": "price",
                    "type": "text"
                  },
                  {
                    "name": "qty",
                    "type": "text"
                  },
                  {
                    "name": "$parent.insOrder.identity",
                    "type": "number"
                  }
                ],
                "outputType": "array"
              }
            ]
          },
          "else": {
            "steps": {
              "name": "",
              "module": "core",
              "action": "redirect",
              "options": {
                "url": "https://bunchoblokes.org/"
              }
            }
          }
        }
      }
    ]
  }
}
JSON
);
?>