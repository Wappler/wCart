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
        "name": "delImages",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
            "table": "product_images",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "ProductImageProductID",
                  "field": "ProductImageProductID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.ProductID}}",
                  "data": {
                    "column": "ProductImageProductID"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "DELETE\nFROM product_images\nWHERE ProductImageProductID = :P1 /* {{$_POST.ProductID}} */",
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
      },
      {
        "name": "fileExists1",
        "module": "fs",
        "action": "direxists",
        "options": {
          "path": "/assets/images/products/{{$_POST.ProductID}}",
          "then": {
            "steps": {
              "name": "removeFolder",
              "module": "fs",
              "action": "removedir",
              "options": {
                "path": "/assets/images/products/{{$_POST.ProductID}}"
              },
              "outputType": "boolean"
            }
          }
        },
        "outputType": "boolean"
      },
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