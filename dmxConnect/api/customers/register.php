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
    ],
    "$_POST": [
      {
        "type": "text",
        "name": "CustomerAddress"
      },
      {
        "type": "text",
        "name": "CustomerCity"
      },
      {
        "type": "text",
        "name": "CustomerCountry"
      },
      {
        "type": "text",
        "name": "CustomerEmail"
      },
      {
        "type": "number",
        "name": "CustomerEmailVerified"
      },
      {
        "type": "text",
        "name": "CustomerFirstName"
      },
      {
        "type": "text",
        "name": "CustomerIP"
      },
      {
        "type": "text",
        "name": "CustomerLastName"
      },
      {
        "type": "text",
        "name": "CustomerPassword"
      },
      {
        "type": "text",
        "name": "CustomerPhone"
      },
      {
        "type": "datetime",
        "name": "CustomerRegistrationDate"
      },
      {
        "type": "text",
        "name": "CustomerState"
      },
      {
        "type": "text",
        "name": "CustomerVerificationCode"
      },
      {
        "type": "text",
        "name": "CustomerZip"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "validate1",
        "module": "validator",
        "action": "validate",
        "options": {
          "data": [
            {
              "name": "validate_1",
              "value": "{{$_POST.CustomerEmail}}",
              "rules": {
                "db:notexists": {
                  "param": {
                    "connection": "db",
                    "table": "customers",
                    "column": "CustomerEmail"
                  },
                  "message": "This email is already registered. Please log in or use another email address."
                }
              },
              "fieldName": "CustomerEmail"
            }
          ]
        }
      },
      {
        "name": "insCustomer",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "db",
          "sql": {
            "type": "insert",
            "values": [
              {
                "table": "customers",
                "column": "CustomerAddress",
                "type": "text",
                "value": "{{$_POST.CustomerAddress}}"
              },
              {
                "table": "customers",
                "column": "CustomerCity",
                "type": "text",
                "value": "{{$_POST.CustomerCity}}"
              },
              {
                "table": "customers",
                "column": "CustomerCountry",
                "type": "text",
                "value": "{{$_POST.CustomerCountry}}"
              },
              {
                "table": "customers",
                "column": "CustomerEmail",
                "type": "text",
                "value": "{{$_POST.CustomerEmail}}"
              },
              {
                "table": "customers",
                "column": "CustomerEmailVerified",
                "type": "number",
                "value": "{{$_POST.CustomerEmailVerified}}"
              },
              {
                "table": "customers",
                "column": "CustomerFirstName",
                "type": "text",
                "value": "{{$_POST.CustomerFirstName}}"
              },
              {
                "table": "customers",
                "column": "CustomerIP",
                "type": "text",
                "value": "{{$_POST.CustomerIP}}"
              },
              {
                "table": "customers",
                "column": "CustomerLastName",
                "type": "text",
                "value": "{{$_POST.CustomerLastName}}"
              },
              {
                "table": "customers",
                "column": "CustomerPassword",
                "type": "text",
                "value": "{{$_POST.CustomerPassword.sha256(\"wcart$\")}}"
              },
              {
                "table": "customers",
                "column": "CustomerPhone",
                "type": "text",
                "value": "{{$_POST.CustomerPhone}}"
              },
              {
                "table": "customers",
                "column": "CustomerRegistrationDate",
                "type": "datetime",
                "value": "{{$_POST.CustomerRegistrationDate}}"
              },
              {
                "table": "customers",
                "column": "CustomerState",
                "type": "text",
                "value": "{{$_POST.CustomerState}}"
              },
              {
                "table": "customers",
                "column": "CustomerVerificationCode",
                "type": "text",
                "value": "{{$_POST.CustomerVerificationCode}}"
              },
              {
                "table": "customers",
                "column": "CustomerZip",
                "type": "text",
                "value": "{{$_POST.CustomerZip}}"
              }
            ],
            "table": "customers",
            "query": "INSERT INTO customers\n(CustomerAddress, CustomerCity, CustomerCountry, CustomerEmail, CustomerEmailVerified, CustomerFirstName, CustomerIP, CustomerLastName, CustomerPassword, CustomerPhone, CustomerRegistrationDate, CustomerState, CustomerVerificationCode, CustomerZip) VALUES (:P1 /* {{$_POST.CustomerAddress}} */, :P2 /* {{$_POST.CustomerCity}} */, :P3 /* {{$_POST.CustomerCountry}} */, :P4 /* {{$_POST.CustomerEmail}} */, :P5 /* {{$_POST.CustomerEmailVerified}} */, :P6 /* {{$_POST.CustomerFirstName}} */, :P7 /* {{$_POST.CustomerIP}} */, :P8 /* {{$_POST.CustomerLastName}} */, :P9 /* {{$_POST.CustomerPassword.sha256(\"wcart$\")}} */, :P10 /* {{$_POST.CustomerPhone}} */, :P11 /* {{$_POST.CustomerRegistrationDate}} */, :P12 /* {{$_POST.CustomerState}} */, :P13 /* {{$_POST.CustomerVerificationCode}} */, :P14 /* {{$_POST.CustomerZip}} */)",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.CustomerAddress}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.CustomerCity}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.CustomerCountry}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.CustomerEmail}}"
              },
              {
                "name": ":P5",
                "type": "expression",
                "value": "{{$_POST.CustomerEmailVerified}}"
              },
              {
                "name": ":P6",
                "type": "expression",
                "value": "{{$_POST.CustomerFirstName}}"
              },
              {
                "name": ":P7",
                "type": "expression",
                "value": "{{$_POST.CustomerIP}}"
              },
              {
                "name": ":P8",
                "type": "expression",
                "value": "{{$_POST.CustomerLastName}}"
              },
              {
                "name": ":P9",
                "type": "expression",
                "value": "{{$_POST.CustomerPassword.sha256(\"wcart$\")}}"
              },
              {
                "name": ":P10",
                "type": "expression",
                "value": "{{$_POST.CustomerPhone}}"
              },
              {
                "name": ":P11",
                "type": "expression",
                "value": "{{$_POST.CustomerRegistrationDate}}"
              },
              {
                "name": ":P12",
                "type": "expression",
                "value": "{{$_POST.CustomerState}}"
              },
              {
                "name": ":P13",
                "type": "expression",
                "value": "{{$_POST.CustomerVerificationCode}}"
              },
              {
                "name": ":P14",
                "type": "expression",
                "value": "{{$_POST.CustomerZip}}"
              }
            ]
          }
        },
        "meta": [
          {
            "name": "identity",
            "type": "text"
          },
          {
            "name": "affected",
            "type": "number"
          }
        ]
      },
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
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "customers.CustomerID",
                  "field": "customers.CustomerID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{insCustomer.identity}}",
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
            "query": "SELECT *\nFROM customers\nWHERE CustomerID = :P1 /* {{insCustomer.identity}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{insCustomer.identity}}"
              }
            ]
          }
        },
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
      },
      {
        "name": "rptCustomers",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{qryCustomers}}",
          "outputFields": [
            "CustomerEmail",
            "CustomerPassword"
          ],
          "exec": {
            "steps": [
              "SecurityProviders/sitesecurity",
              {
                "name": "identity",
                "module": "auth",
                "action": "login",
                "options": {
                  "provider": "sitesecurity",
                  "username": "{{CustomerEmail}}",
                  "password": "{{CustomerPassword}}",
                  "remember": ""
                },
                "output": true,
                "meta": []
              }
            ]
          }
        },
        "output": true,
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
          },
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