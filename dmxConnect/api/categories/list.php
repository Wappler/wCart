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
        "name": "qryCategories",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "categories",
                "column": "*"
              },
              {
                "table": "metatags",
                "column": "*"
              }
            ],
            "table": {
              "name": "categories"
            },
            "joins": [
              {
                "table": "metatags",
                "column": "*",
                "type": "INNER",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "metatags",
                      "column": "metaID",
                      "operator": "equal",
                      "value": {
                        "table": "categories",
                        "column": "CategoryMetaID"
                      },
                      "operation": "="
                    }
                  ]
                }
              }
            ],
            "query": "SELECT categories.*, metatags.*\nFROM categories\nINNER JOIN metatags ON (metatags.metaID = categories.CategoryMetaID)",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "CategoryID",
            "type": "number"
          },
          {
            "name": "CategoryName",
            "type": "text"
          },
          {
            "name": "CategoryURL",
            "type": "text"
          },
          {
            "name": "CategoryMetaID",
            "type": "number"
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
            "name": "metaURL",
            "type": "text"
          },
          {
            "name": "metaTitle",
            "type": "text"
          },
          {
            "name": "metaDescription",
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