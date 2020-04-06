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
        "name": "metaID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "delMetatag",
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