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
        "name": "ProductCartDesc"
      },
      {
        "type": "number",
        "name": "ProductCategoryID"
      },
      {
        "type": "text",
        "name": "ProductImage"
      },
      {
        "type": "number",
        "name": "ProductLive"
      },
      {
        "type": "text",
        "name": "ProductLocation"
      },
      {
        "type": "text",
        "name": "ProductLongDesc"
      },
      {
        "type": "text",
        "name": "ProductName"
      },
      {
        "type": "number",
        "name": "ProductPrice"
      },
      {
        "type": "text",
        "name": "ProductShortDesc"
      },
      {
        "type": "text",
        "name": "ProductSKU"
      },
      {
        "type": "number",
        "name": "ProductStock"
      },
      {
        "type": "text",
        "name": "ProductThumb"
      },
      {
        "type": "number",
        "name": "ProductUnlimited"
      },
      {
        "type": "datetime",
        "name": "ProductUpdateDate"
      },
      {
        "type": "number",
        "name": "ProductWeight"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "insProduct",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "db",
          "sql": {
            "type": "insert",
            "values": [
              {
                "table": "products",
                "column": "ProductName",
                "type": "text",
                "value": "{{$_POST.ProductName}}"
              },
              {
                "table": "products",
                "column": "ProductSKU",
                "type": "text",
                "value": "{{$_POST.ProductSKU}}"
              },
              {
                "table": "products",
                "column": "ProductCategoryID",
                "type": "number",
                "value": "{{$_POST.ProductCategoryID}}"
              }
            ],
            "table": "products",
            "query": "INSERT INTO products\n(ProductName, ProductSKU, ProductCategoryID) VALUES (:P1 /* {{$_POST.ProductName}} */, :P2 /* {{$_POST.ProductSKU}} */, :P3 /* {{$_POST.ProductCategoryID}} */)",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.ProductName}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.ProductSKU}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.ProductCategoryID}}"
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
        ],
        "output": false
      }
    ]
  }
}
JSON
);
?>