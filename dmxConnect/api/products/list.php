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
              },
              {
                "table": "categories",
                "column": "*"
              }
            ],
            "table": {
              "name": "products"
            },
            "joins": [
              {
                "table": "categories",
                "column": "*",
                "type": "INNER",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "categories",
                      "column": "CategoryID",
                      "operator": "equal",
                      "value": {
                        "table": "products",
                        "column": "ProductCategoryID"
                      },
                      "operation": "="
                    }
                  ]
                }
              }
            ],
            "query": "SELECT products.*, categories.*\nFROM products\nINNER JOIN categories ON (categories.CategoryID = products.ProductCategoryID)",
            "params": [],
            "orders": []
          }
        },
        "output": false,
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
          },
          {
            "name": "CategoryID",
            "type": "number"
          },
          {
            "name": "CategoryName",
            "type": "text"
          },
          {
            "name": "CategoryURL",
            "type": "text"
          },
          {
            "name": "CategoryMetaID",
            "type": "number"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "rptProducts",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{qryProducts}}",
          "outputFields": [
            "ProductID",
            "ProductSKU",
            "ProductName",
            "ProductPrice",
            "ProductShortDesc",
            "ProductLongDesc",
            "ProductCategoryID",
            "ProductLive",
            "CategoryID",
            "CategoryName",
            "CategoryURL",
            "CategoryMetaID"
          ],
          "exec": {
            "steps": {
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
                  "query": "SELECT *\nFROM product_images\nWHERE ProductImageProductID = :P1 /* {{ProductID}} */\nORDER BY ProductImageDisplayOrder ASC",
                  "params": [
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P1",
                      "value": "{{ProductID}}"
                    }
                  ],
                  "wheres": {
                    "condition": "AND",
                    "rules": [
                      {
                        "id": "product_images.ProductImageProductID",
                        "field": "product_images.ProductImageProductID",
                        "type": "double",
                        "operator": "equal",
                        "value": "{{ProductID}}",
                        "data": {
                          "table": "product_images",
                          "column": "ProductImageProductID",
                          "type": "number"
                        },
                        "operation": "="
                      }
                    ],
                    "conditional": null,
                    "valid": true
                  },
                  "orders": [
                    {
                      "table": "product_images",
                      "column": "ProductImageDisplayOrder",
                      "direction": "ASC"
                    }
                  ]
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
          },
          {
            "name": "CategoryID",
            "type": "number"
          },
          {
            "name": "CategoryName",
            "type": "text"
          },
          {
            "name": "CategoryURL",
            "type": "text"
          },
          {
            "name": "CategoryMetaID",
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