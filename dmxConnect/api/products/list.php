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
        "name": "qryProducts",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "products",
                "column": "*"
              }
            ],
            "table": {
              "name": "products"
            },
            "joins": [],
            "query": "SELECT *\nFROM products",
            "params": [],
            "orders": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "ProductID",
            "type": "number"
          },
          {
            "name": "ProductSKU",
            "type": "text"
          },
          {
            "name": "ProductName",
            "type": "text"
          },
          {
            "name": "ProductPrice",
            "type": "number"
          },
          {
            "name": "ProductWeight",
            "type": "number"
          },
          {
            "name": "ProductCartDesc",
            "type": "text"
          },
          {
            "name": "ProductShortDesc",
            "type": "text"
          },
          {
            "name": "ProductLongDesc",
            "type": "text"
          },
          {
            "name": "ProductThumb",
            "type": "text"
          },
          {
            "name": "ProductImage",
            "type": "text"
          },
          {
            "name": "ProductCategoryID",
            "type": "number"
          },
          {
            "name": "ProductUpdateDate",
            "type": "datetime"
          },
          {
            "name": "ProductStock",
            "type": "number"
          },
          {
            "name": "ProductLive",
            "type": "number"
          },
          {
            "name": "ProductUnlimited",
            "type": "number"
          },
          {
            "name": "ProductLocation",
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