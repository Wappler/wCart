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
      "linkedFile": "/admin/_products.html",
      "linkedForm": "frmProductUpdate"
    },
    "$_POST": [
      {
        "type": "text",
        "fieldName": "ProductID",
        "name": "ProductID"
      },
      {
        "type": "text",
        "fieldName": "ProductSKU",
        "name": "ProductSKU"
      },
      {
        "type": "text",
        "fieldName": "ProductName",
        "options": {
          "rules": {}
        },
        "name": "ProductName"
      },
      {
        "type": "text",
        "fieldName": "ProductPrice",
        "options": {
          "rules": {}
        },
        "name": "ProductPrice"
      },
      {
        "type": "text",
        "fieldName": "ProductShortDesc",
        "name": "ProductShortDesc"
      },
      {
        "type": "text",
        "fieldName": "ProductCategoryID",
        "name": "ProductCategoryID"
      },
      {
        "type": "text",
        "fieldName": "ProductLongDesc",
        "name": "ProductLongDesc"
      },
      {
        "type": "datetime",
        "name": "ProductUpdateDate"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "updProduct",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "products",
                "column": "ProductSKU",
                "type": "text",
                "value": "{{$_POST.ProductSKU}}"
              },
              {
                "table": "products",
                "column": "ProductName",
                "type": "text",
                "value": "{{$_POST.ProductName}}"
              },
              {
                "table": "products",
                "column": "ProductPrice",
                "type": "number",
                "value": "{{$_POST.ProductPrice}}"
              },
              {
                "table": "products",
                "column": "ProductShortDesc",
                "type": "text",
                "value": "{{$_POST.ProductShortDesc}}"
              },
              {
                "table": "products",
                "column": "ProductLongDesc",
                "type": "text",
                "value": "{{$_POST.ProductLongDesc}}"
              },
              {
                "table": "products",
                "column": "ProductCategoryID",
                "type": "number",
                "value": "{{$_POST.ProductCategoryID}}"
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
            "query": "UPDATE products\nSET ProductSKU = :P1 /* {{$_POST.ProductSKU}} */, ProductName = :P2 /* {{$_POST.ProductName}} */, ProductPrice = :P3 /* {{$_POST.ProductPrice}} */, ProductShortDesc = :P4 /* {{$_POST.ProductShortDesc}} */, ProductLongDesc = :P5 /* {{$_POST.ProductLongDesc}} */, ProductCategoryID = :P6 /* {{$_POST.ProductCategoryID}} */\nWHERE ProductID = :P7 /* {{$_POST.ProductID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.ProductSKU}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.ProductName}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.ProductPrice}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.ProductShortDesc}}"
              },
              {
                "name": ":P5",
                "type": "expression",
                "value": "{{$_POST.ProductLongDesc}}"
              },
              {
                "name": ":P6",
                "type": "expression",
                "value": "{{$_POST.ProductCategoryID}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P7",
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