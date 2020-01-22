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
        "name": "CategoryID"
      },
      {
        "type": "text",
        "name": "metaID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "delCategory",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
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
            "query": "DELETE\nFROM categories\nWHERE CategoryID = :P1 /* {{$_POST.CategoryID}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
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
        "name": "delMetatags",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
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
            "query": "DELETE\nFROM metatags\nWHERE metaID = :P1 /* {{$_POST.metaID}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
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