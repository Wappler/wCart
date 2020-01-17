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
      },
      {
        "type": "number",
        "name": "ProductID"
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
                "column": "ProductCartDesc",
                "type": "text",
                "value": "{{$_POST.ProductCartDesc}}"
              },
              {
                "table": "products",
                "column": "ProductCategoryID",
                "type": "number",
                "value": "{{$_POST.ProductCategoryID}}"
              },
              {
                "table": "products",
                "column": "ProductImage",
                "type": "text",
                "value": "{{$_POST.ProductImage}}"
              },
              {
                "table": "products",
                "column": "ProductLive",
                "type": "number",
                "value": "{{$_POST.ProductLive}}"
              },
              {
                "table": "products",
                "column": "ProductLocation",
                "type": "text",
                "value": "{{$_POST.ProductLocation}}"
              },
              {
                "table": "products",
                "column": "ProductLongDesc",
                "type": "text",
                "value": "{{$_POST.ProductLongDesc}}"
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
                "column": "ProductSKU",
                "type": "text",
                "value": "{{$_POST.ProductSKU}}"
              },
              {
                "table": "products",
                "column": "ProductStock",
                "type": "number",
                "value": "{{$_POST.ProductStock}}"
              },
              {
                "table": "products",
                "column": "ProductThumb",
                "type": "text",
                "value": "{{$_POST.ProductThumb}}"
              },
              {
                "table": "products",
                "column": "ProductUnlimited",
                "type": "number",
                "value": "{{$_POST.ProductUnlimited}}"
              },
              {
                "table": "products",
                "column": "ProductUpdateDate",
                "type": "datetime",
                "value": "{{$_POST.ProductUpdateDate}}"
              },
              {
                "table": "products",
                "column": "ProductWeight",
                "type": "number",
                "value": "{{$_POST.ProductWeight}}"
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
            "query": "UPDATE products\nSET ProductCartDesc = :P1 /* {{$_POST.ProductCartDesc}} */, ProductCategoryID = :P2 /* {{$_POST.ProductCategoryID}} */, ProductImage = :P3 /* {{$_POST.ProductImage}} */, ProductLive = :P4 /* {{$_POST.ProductLive}} */, ProductLocation = :P5 /* {{$_POST.ProductLocation}} */, ProductLongDesc = :P6 /* {{$_POST.ProductLongDesc}} */, ProductName = :P7 /* {{$_POST.ProductName}} */, ProductPrice = :P8 /* {{$_POST.ProductPrice}} */, ProductShortDesc = :P9 /* {{$_POST.ProductShortDesc}} */, ProductSKU = :P10 /* {{$_POST.ProductSKU}} */, ProductStock = :P11 /* {{$_POST.ProductStock}} */, ProductThumb = :P12 /* {{$_POST.ProductThumb}} */, ProductUnlimited = :P13 /* {{$_POST.ProductUnlimited}} */, ProductUpdateDate = :P14 /* {{$_POST.ProductUpdateDate}} */, ProductWeight = :P15 /* {{$_POST.ProductWeight}} */\nWHERE ProductID = :P16 /* {{$_POST.ProductID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.ProductCartDesc}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.ProductCategoryID}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.ProductImage}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.ProductLive}}"
              },
              {
                "name": ":P5",
                "type": "expression",
                "value": "{{$_POST.ProductLocation}}"
              },
              {
                "name": ":P6",
                "type": "expression",
                "value": "{{$_POST.ProductLongDesc}}"
              },
              {
                "name": ":P7",
                "type": "expression",
                "value": "{{$_POST.ProductName}}"
              },
              {
                "name": ":P8",
                "type": "expression",
                "value": "{{$_POST.ProductPrice}}"
              },
              {
                "name": ":P9",
                "type": "expression",
                "value": "{{$_POST.ProductShortDesc}}"
              },
              {
                "name": ":P10",
                "type": "expression",
                "value": "{{$_POST.ProductSKU}}"
              },
              {
                "name": ":P11",
                "type": "expression",
                "value": "{{$_POST.ProductStock}}"
              },
              {
                "name": ":P12",
                "type": "expression",
                "value": "{{$_POST.ProductThumb}}"
              },
              {
                "name": ":P13",
                "type": "expression",
                "value": "{{$_POST.ProductUnlimited}}"
              },
              {
                "name": ":P14",
                "type": "expression",
                "value": "{{$_POST.ProductUpdateDate}}"
              },
              {
                "name": ":P15",
                "type": "expression",
                "value": "{{$_POST.ProductWeight}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P16",
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