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
        "name": "metaID"
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
        "name": "updMetatag",
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