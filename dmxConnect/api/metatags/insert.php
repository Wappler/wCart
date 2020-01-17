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
        "name": "metaPage"
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
        "type": "text",
        "name": "metaURL"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "insMetatag",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "db",
          "sql": {
            "type": "insert",
            "values": [
              {
                "table": "metatags",
                "column": "metaDescription",
                "type": "text",
                "value": "{{$_POST.metaDescription}}"
              },
              {
                "table": "metatags",
                "column": "metaPage",
                "type": "text",
                "value": "{{$_POST.metaPage}}"
              },
              {
                "table": "metatags",
                "column": "metaTitle",
                "type": "text",
                "value": "{{$_POST.metaTitle}}"
              },
              {
                "table": "metatags",
                "column": "metaURL",
                "type": "text",
                "value": "{{$_POST.metaURL}}"
              }
            ],
            "table": "metatags",
            "query": "INSERT INTO metatags\n(metaDescription, metaPage, metaTitle, metaURL) VALUES (:P1 /* {{$_POST.metaDescription}} */, :P2 /* {{$_POST.metaPage}} */, :P3 /* {{$_POST.metaTitle}} */, :P4 /* {{$_POST.metaURL}} */)",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.metaDescription}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.metaPage}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.metaTitle}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.metaURL}}"
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