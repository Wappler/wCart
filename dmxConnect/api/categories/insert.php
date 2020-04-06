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
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "insMetatags",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "db",
          "sql": {
            "type": "insert",
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
            "query": "INSERT INTO metatags\n(metaPage, metaURL, metaTitle, metaDescription) VALUES (:P1 /* {{$_POST.metaPage}} */, :P2 /* {{$_POST.metaURL}} */, :P3 /* {{$_POST.metaTitle}} */, :P4 /* {{$_POST.metaDescription}} */)",
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
        "name": "insCategory",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "db",
          "sql": {
            "type": "insert",
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
                "value": "{{insMetatags.identity}}"
              }
            ],
            "table": "categories",
            "query": "INSERT INTO categories\n(CategoryName, CategoryURL, CategoryMetaID) VALUES (:P1 /* {{$_POST.CategoryName}} */, :P2 /* {{$_POST.CategoryURL}} */, :P3 /* {{insMetatags.identity}} */)",
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
                "value": "{{insMetatags.identity}}"
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
}
JSON
);
?>