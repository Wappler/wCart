<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "settings": {
    "options": {}
  },
  "meta": {
    "options": {}
  },
  "exec": {
    "steps": [
      "Connections/db",
      "SecurityProviders/sitesecurity",
      {
        "name": "",
        "module": "auth",
        "action": "restrict",
        "options": {
          "provider": "sitesecurity"
        }
      },
      {
        "name": "qryCustomer",
        "module": "dbconnector",
        "action": "single",
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
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "customers.CustomerID",
                  "field": "customers.CustomerID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{sitesecurity.identity}}",
                  "data": {
                    "table": "customers",
                    "column": "CustomerID",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM customers\nWHERE CustomerID = :P1 /* {{sitesecurity.identity}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{sitesecurity.identity}}"
              }
            ]
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
        "outputType": "object"
      }
    ]
  }
}
JSON
);
?>