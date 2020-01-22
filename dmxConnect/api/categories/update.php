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
        "name": "CategoryName"
      },
      {
        "type": "text",
        "name": "CategoryURL"
      },
      {
        "type": "number",
        "name": "CategoryMetaID"
      },
      {
        "type": "number",
        "name": "CategoryID"
      },
      {
        "type": "text",
        "name": "metaPage"
      },
      {
        "type": "text",
        "name": "metaURL"
      },
      {
        "type": "text",
        "name": "metaTitle"
      },
      {
        "type": "text",
        "name": "metaDescription"
      },
      {
        "type": "number",
        "name": "metaID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "upCategory",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "categories",
                "column": "CategoryName",
                "type": "text",
                "value": "{{$_POST.CategoryName}}"
              },
              {
                "table": "categories",
                "column": "CategoryURL",
                "type": "text",
                "value": "{{$_POST.CategoryURL}}"
              },
              {
                "table": "categories",
                "column": "CategoryMetaID",
                "type": "number",
                "value": "{{$_POST.CategoryMetaID}}"
              }
            ],
            "table": "categories",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "CategoryID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.CategoryID}}",
                  "data": {
                    "column": "CategoryID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "UPDATE categories\nSET CategoryName = :P1 /* {{$_POST.CategoryName}} */, CategoryURL = :P2 /* {{$_POST.CategoryURL}} */, CategoryMetaID = :P3 /* {{$_POST.CategoryMetaID}} */\nWHERE CategoryID = :P4 /* {{$_POST.CategoryID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.CategoryName}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.CategoryURL}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.CategoryMetaID}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P4",
                "value": "{{$_POST.CategoryID}}"
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
        "name": "updMetatags",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "metatags",
                "column": "metaPage",
                "type": "text",
                "value": "{{$_POST.metaPage}}"
              },
              {
                "table": "metatags",
                "column": "metaURL",
                "type": "text",
                "value": "{{$_POST.metaURL}}"
              },
              {
                "table": "metatags",
                "column": "metaTitle",
                "type": "text",
                "value": "{{$_POST.metaTitle}}"
              },
              {
                "table": "metatags",
                "column": "metaDescription",
                "type": "text",
                "value": "{{$_POST.metaDescription}}"
              }
            ],
            "table": "metatags",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "metaID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.metaID}}",
                  "data": {
                    "column": "metaID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "UPDATE metatags\nSET metaPage = :P1 /* {{$_POST.metaPage}} */, metaURL = :P2 /* {{$_POST.metaURL}} */, metaTitle = :P3 /* {{$_POST.metaTitle}} */, metaDescription = :P4 /* {{$_POST.metaDescription}} */\nWHERE metaID = :P5 /* {{$_POST.metaID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.metaPage}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.metaURL}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.metaTitle}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.metaDescription}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P5",
                "value": "{{$_POST.metaID}}"
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