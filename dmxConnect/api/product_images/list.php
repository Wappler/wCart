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
        "name": "qryImages",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "product_images",
                "column": "*"
              }
            ],
            "table": {
              "name": "product_images"
            },
            "joins": [],
            "orders": [
              {
                "table": "product_images",
                "column": "ProductImageDisplayOrder",
                "direction": "ASC"
              }
            ],
            "query": "SELECT *\nFROM product_images\nORDER BY ProductImageDisplayOrder ASC",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "ProductImageID",
            "type": "number"
          },
          {
            "name": "ProductImageProductID",
            "type": "number"
          },
          {
            "name": "ProductImageFile",
            "type": "text"
          },
          {
            "name": "ProductImageDisplayOrder",
            "type": "number"
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