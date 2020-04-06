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
        "type": "number",
        "name": "ProductImageProductID"
      },
      {
        "type": "file",
        "multiple": true,
        "name": "ProductImageFile",
        "sub": [
          {
            "name": "name",
            "type": "text"
          },
          {
            "name": "type",
            "type": "text"
          },
          {
            "name": "size",
            "type": "number"
          },
          {
            "name": "error",
            "type": "text"
          }
        ],
        "outputType": "array"
      },
      {
        "type": "number",
        "name": "ProductImageDisplayOrder"
      },
      {
        "type": "array",
        "name": "record",
        "sub": [
          {
            "type": "number",
            "name": "$_POST.ProductImageProductID"
          },
          {
            "type": "text",
            "name": "name"
          },
          {
            "type": "number",
            "name": "$_POST.ProductImageDisplayOrder"
          }
        ]
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "uplImages",
        "module": "upload",
        "action": "upload",
        "options": {
          "fields": "{{$_POST.ProductImageFile}}",
          "path": "/assets/images/products/{{$_POST.ProductImageProductID}}",
          "replaceSpace": true,
          "replaceDiacritics": true,
          "asciiOnly": true,
          "overwrite": true
        },
        "meta": [
          {
            "name": "name",
            "type": "text"
          },
          {
            "name": "path",
            "type": "text"
          },
          {
            "name": "url",
            "type": "text"
          },
          {
            "name": "type",
            "type": "text"
          },
          {
            "name": "size",
            "type": "text"
          },
          {
            "name": "error",
            "type": "number"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "repeatImages",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{uplImages}}",
          "exec": {
            "steps": [
              {
                "name": "image",
                "module": "image",
                "action": "load",
                "options": {
                  "path": "{{path}}"
                },
                "outputType": "object",
                "meta": [
                  {
                    "name": "width",
                    "type": "number"
                  },
                  {
                    "name": "height",
                    "type": "number"
                  }
                ]
              },
              {
                "name": "",
                "module": "image",
                "action": "resize",
                "options": {
                  "instance": "image",
                  "width": 960,
                  "upscale": true
                }
              },
              {
                "name": "LargeImage",
                "module": "image",
                "action": "save",
                "options": {
                  "instance": "image",
                  "path": "/assets/images/products/{{$_POST.ProductImageProductID}}",
                  "overwrite": true
                }
              },
              {
                "name": "image",
                "module": "image",
                "action": "load",
                "options": {
                  "path": "{{path}}"
                },
                "outputType": "object",
                "meta": [
                  {
                    "name": "width",
                    "type": "number"
                  },
                  {
                    "name": "height",
                    "type": "number"
                  }
                ]
              },
              {
                "name": "",
                "module": "image",
                "action": "resize",
                "options": {
                  "instance": "image",
                  "width": 150
                }
              },
              {
                "name": "ThumbnailImage",
                "module": "image",
                "action": "save",
                "options": {
                  "instance": "image",
                  "path": "/assets/images/products/{{$_POST.ProductImageProductID}}/thumbs",
                  "overwrite": true
                }
              },
              {
                "name": "insImage",
                "module": "dbupdater",
                "action": "insert",
                "options": {
                  "connection": "db",
                  "sql": {
                    "type": "insert",
                    "values": [
                      {
                        "table": "product_images",
                        "column": "ProductImageProductID",
                        "type": "number",
                        "value": "{{$_POST.ProductImageProductID}}"
                      },
                      {
                        "table": "product_images",
                        "column": "ProductImageFile",
                        "type": "text",
                        "value": "{{name}}"
                      },
                      {
                        "table": "product_images",
                        "column": "ProductImageDisplayOrder",
                        "type": "number",
                        "value": "{{$_POST.ProductImageDisplayOrder}}"
                      }
                    ],
                    "table": "product_images",
                    "query": "INSERT INTO product_images\n(ProductImageProductID, ProductImageFile, ProductImageDisplayOrder) VALUES (:P1 /* {{$_POST.ProductImageProductID}} */, :P2 /* {{name}} */, :P3 /* {{$_POST.ProductImageDisplayOrder}} */)",
                    "params": [
                      {
                        "name": ":P1",
                        "type": "expression",
                        "value": "{{$_POST.ProductImageProductID}}"
                      },
                      {
                        "name": ":P2",
                        "type": "expression",
                        "value": "{{name}}"
                      },
                      {
                        "name": ":P3",
                        "type": "expression",
                        "value": "{{$_POST.ProductImageDisplayOrder}}"
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
            ]
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
            "name": "name",
            "type": "text"
          },
          {
            "name": "path",
            "type": "text"
          },
          {
            "name": "url",
            "type": "text"
          },
          {
            "name": "type",
            "type": "text"
          },
          {
            "name": "size",
            "type": "text"
          },
          {
            "name": "error",
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