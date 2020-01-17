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
      },
      {
        "type": "text",
        "name": "filter"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "qryRegions",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "regions",
                "column": "*"
              }
            ],
            "table": {
              "name": "regions"
            },
            "joins": [],
            "orders": [
              {
                "table": "regions",
                "column": "RegionName",
                "direction": "ASC",
                "recid": 1
              }
            ],
            "query": "SELECT *\nFROM regions\nWHERE RegionCountry = :P1 /* {{$_GET.filter}} */\nORDER BY RegionName ASC",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.filter}}"
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "regions.RegionCountry",
                  "field": "regions.RegionCountry",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{$_GET.filter}}",
                  "data": {
                    "table": "regions",
                    "column": "RegionCountry",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            }
          }
        },
        "output": true,
        "meta": [
          {
            "name": "RegionID",
            "type": "number"
          },
          {
            "name": "RegionName",
            "type": "text"
          },
          {
            "name": "RegionCode",
            "type": "text"
          },
          {
            "name": "RegionCountry",
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