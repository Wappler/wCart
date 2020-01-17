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
        "name": "qryAdministrators",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "users",
                "column": "*"
              }
            ],
            "table": {
              "name": "users"
            },
            "joins": [],
            "orders": [
              {
                "table": "users",
                "column": "UserName",
                "direction": "ASC",
                "recid": 1
              }
            ],
            "query": "SELECT *\nFROM users\nORDER BY UserName ASC",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "UserID",
            "type": "number"
          },
          {
            "name": "UserLevel",
            "type": "number"
          },
          {
            "name": "UserName",
            "type": "text"
          },
          {
            "name": "UserPassword",
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