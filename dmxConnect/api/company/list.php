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
        "name": "qryCompany",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "company",
                "column": "*"
              }
            ],
            "table": {
              "name": "company"
            },
            "joins": [],
            "query": "SELECT *\nFROM company",
            "params": [],
            "orders": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "CompanyAddress",
            "type": "text"
          },
          {
            "name": "CompanyBusinessID",
            "type": "text"
          },
          {
            "name": "CompanyCity",
            "type": "text"
          },
          {
            "name": "CompanyCountry",
            "type": "text"
          },
          {
            "name": "CompanyEmail",
            "type": "text"
          },
          {
            "name": "CompanyID",
            "type": "number"
          },
          {
            "name": "CompanyLogo",
            "type": "text"
          },
          {
            "name": "CompanyName",
            "type": "text"
          },
          {
            "name": "CompanyPhone",
            "type": "text"
          },
          {
            "name": "CompanyRegistrationDate",
            "type": "date"
          },
          {
            "name": "CompanyState",
            "type": "text"
          },
          {
            "name": "CompanyWebsite",
            "type": "text"
          },
          {
            "name": "CompanyZip",
            "type": "text"
          }
        ],
        "type": "dbconnector_single",
        "outputType": "object"
      }
    ]
  }
}
JSON
);
?>