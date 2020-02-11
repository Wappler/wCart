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
        "type": "array",
        "name": "record",
        "sub": [
          {
            "type": "number",
            "name": "ProductImageDisplayOrder"
          },
          {
            "type": "number",
            "name": "ProductImageID"
          }
        ]
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "record_repeat",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{$_POST.record}}",
          "exec": {
            "steps": {
              "name": "updImages",
              "module": "dbupdater",
              "action": "update",
              "options": {
                "connection": "db",
                "sql": {
                  "type": "update",
                  "values": [
                    {
                      "table": "product_images",
                      "column": "ProductImageDisplayOrder",
                      "type": "number",
                      "value": "{{ProductImageDisplayOrder}}"
                    }
                  ],
                  "table": "product_images",
                  "wheres": {
                    "condition": "AND",
                    "rules": [
                      {
                        "id": "ProductImageID",
                        "type": "double",
                        "operator": "equal",
                        "value": "{{ProductImageID}}",
                        "data": {
                          "column": "ProductImageID"
                        },
                        "operation": "="
                      }
                    ]
                  },
                  "query": "UPDATE product_images\nSET ProductImageDisplayOrder = :P1 /* {{ProductImageDisplayOrder}} */\nWHERE ProductImageID = :P2 /* {{ProductImageID}} */",
                  "params": [
                    {
                      "name": ":P1",
                      "type": "expression",
                      "value": "{{ProductImageDisplayOrder}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P2",
                      "value": "{{ProductImageID}}"
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
          }
        },
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