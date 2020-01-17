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
        "name": "qryCustomers",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "customers",
                "column": "*"
              }
            ],
            "table": {
              "name": "customers"
            },
            "joins": [],
            "query": "SELECT *\nFROM customers",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "CustomerAddress",
            "type": "text"
          },
          {
            "name": "CustomerCity",
            "type": "text"
          },
          {
            "name": "CustomerCountry",
            "type": "text"
          },
          {
            "name": "CustomerEmail",
            "type": "text"
          },
          {
            "name": "CustomerEmailVerified",
            "type": "number"
          },
          {
            "name": "CustomerFirstName",
            "type": "text"
          },
          {
            "name": "CustomerID",
            "type": "number"
          },
          {
            "name": "CustomerIP",
            "type": "text"
          },
          {
            "name": "CustomerLastName",
            "type": "text"
          },
          {
            "name": "CustomerPassword",
            "type": "text"
          },
          {
            "name": "CustomerPhone",
            "type": "text"
          },
          {
            "name": "CustomerRegistrationDate",
            "type": "datetime"
          },
          {
            "name": "CustomerState",
            "type": "text"
          },
          {
            "name": "CustomerVerificationCode",
            "type": "text"
          },
          {
            "name": "CustomerZip",
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