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
        "name": "qryMetaTags",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "metatags",
                "column": "*"
              }
            ],
            "table": {
              "name": "metatags"
            },
            "joins": [],
            "query": "SELECT *\nFROM metatags",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "metaDescription",
            "type": "text"
          },
          {
            "name": "metaID",
            "type": "number"
          },
          {
            "name": "metaPage",
            "type": "text"
          },
          {
            "name": "metaTitle",
            "type": "text"
          },
          {
            "name": "metaURL",
            "type": "text"
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