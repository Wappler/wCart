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
        "name": "qryCountries",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "countries",
                "column": "*"
              }
            ],
            "table": {
              "name": "countries"
            },
            "joins": [],
            "query": "SELECT *\nFROM countries\nORDER BY CountryName ASC",
            "params": [],
            "orders": [
              {
                "table": "countries",
                "column": "CountryName",
                "direction": "ASC"
              }
            ]
          }
        },
        "meta": [
          {
            "name": "CountryID",
            "type": "number"
          },
          {
            "name": "CountryISO",
            "type": "text"
          },
          {
            "name": "CountryName",
            "type": "text"
          },
          {
            "name": "CountryRegionName",
            "type": "text"
          },
          {
            "name": "CountryRegionRequired",
            "type": "number"
          }
        ],
        "outputType": "array",
        "output": true
      }
    ]
  }
}
JSON
);
?>