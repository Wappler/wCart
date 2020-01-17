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
            "query": "INSERT INTO products\n(ProductCartDesc, ProductCategoryID, ProductImage, ProductLive, ProductLocation, ProductLongDesc, ProductName, ProductPrice, ProductShortDesc, ProductSKU, ProductStock, ProductThumb, ProductUnlimited, ProductUpdateDate, ProductWeight) VALUES (:P1 /* {{$_POST.ProductCartDesc}} */, :P2 /* {{$_POST.ProductCategoryID}} */, :P3 /* {{$_POST.ProductImage}} */, :P4 /* {{$_POST.ProductLive}} */, :P5 /* {{$_POST.ProductLocation}} */, :P6 /* {{$_POST.ProductLongDesc}} */, :P7 /* {{$_POST.ProductName}} */, :P8 /* {{$_POST.ProductPrice}} */, :P9 /* {{$_POST.ProductShortDesc}} */, :P10 /* {{$_POST.ProductSKU}} */, :P11 /* {{$_POST.ProductStock}} */, :P12 /* {{$_POST.ProductThumb}} */, :P13 /* {{$_POST.ProductUnlimited}} */, :P14 /* {{$_POST.ProductUpdateDate}} */, :P15 /* {{$_POST.ProductWeight}} */)",
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
        "name": "LastProduct",
        "module": "core",
        "action": "setvalue",
        "options": {
          "value": "{{insProduct.identity}}"
        },
        "outputType": "text",
        "output": true
      }
    ]
  }
}
JSON
);
?>