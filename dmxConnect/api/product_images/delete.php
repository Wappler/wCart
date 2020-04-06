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
        "name": "ProductImageID"
      },
      {
        "type": "text",
        "name": "ProductImageProductID"
      },
      {
        "type": "text",
        "name": "ProductImageFile"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "remLargeImage",
        "module": "fs",
        "action": "remove",
        "options": {
          "path": "/assets/images/products/{{$_POST.ProductImageProductID}}/{{$_POST.ProductImageFile}}"
        },
        "outputType": "boolean"
      },
      {
        "name": "remThumbnail",
        "module": "fs",
        "action": "remove",
        "options": {
          "path": "/assets/images/products/{{$_POST.ProductImageProductID}}/thumbs/{{$_POST.ProductImageFile}}"
        },
        "outputType": "boolean"
      },
      {
        "name": "delImage",
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
                  "id": "ProductImageID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.ProductImageID}}",
                  "data": {
                    "column": "ProductImageID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "DELETE\nFROM product_images\nWHERE ProductImageID = :P1 /* {{$_POST.ProductImageID}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.ProductImageID}}"
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