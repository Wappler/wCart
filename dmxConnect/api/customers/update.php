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
        "type": "text",
        "name": "CustomerEmail"
      },
      {
        "type": "text",
        "name": "CustomerPassword"
      },
      {
        "type": "text",
        "name": "CustomerFirstName"
      },
      {
        "type": "text",
        "name": "CustomerLastName"
      },
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
        "name": "CustomerState"
      },
      {
        "type": "text",
        "name": "CustomerZip"
      },
      {
        "type": "text",
        "name": "CustomerCountry"
      },
      {
        "type": "text",
        "name": "CustomerPhone"
      },
      {
        "type": "number",
        "name": "CustomerEmailVerified"
      },
      {
        "type": "datetime",
        "name": "CustomerRegistrationDate"
      },
      {
        "type": "text",
        "name": "CustomerVerificationCode"
      },
      {
        "type": "text",
        "name": "CustomerIP"
      },
      {
        "type": "number",
        "name": "CustomerID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      {
        "name": "updCustomer",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "customers",
                "column": "CustomerEmail",
                "type": "text",
                "value": "{{$_POST.CustomerEmail}}"
              },
              {
                "table": "customers",
                "column": "CustomerFirstName",
                "type": "text",
                "value": "{{$_POST.CustomerFirstName}}"
              },
              {
                "table": "customers",
                "column": "CustomerLastName",
                "type": "text",
                "value": "{{$_POST.CustomerLastName}}"
              },
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
                "column": "CustomerState",
                "type": "text",
                "value": "{{$_POST.CustomerState}}"
              },
              {
                "table": "customers",
                "column": "CustomerZip",
                "type": "text",
                "value": "{{$_POST.CustomerZip}}"
              },
              {
                "table": "customers",
                "column": "CustomerCountry",
                "type": "text",
                "value": "{{$_POST.CustomerCountry}}"
              }
            ],
            "table": "customers",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "CustomerID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.CustomerID}}",
                  "data": {
                    "column": "CustomerID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "UPDATE customers\nSET CustomerEmail = :P1 /* {{$_POST.CustomerEmail}} */, CustomerFirstName = :P2 /* {{$_POST.CustomerFirstName}} */, CustomerLastName = :P3 /* {{$_POST.CustomerLastName}} */, CustomerAddress = :P4 /* {{$_POST.CustomerAddress}} */, CustomerCity = :P5 /* {{$_POST.CustomerCity}} */, CustomerState = :P6 /* {{$_POST.CustomerState}} */, CustomerZip = :P7 /* {{$_POST.CustomerZip}} */, CustomerCountry = :P8 /* {{$_POST.CustomerCountry}} */\nWHERE CustomerID = :P9 /* {{$_POST.CustomerID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.CustomerEmail}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.CustomerFirstName}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.CustomerLastName}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.CustomerAddress}}"
              },
              {
                "name": ":P5",
                "type": "expression",
                "value": "{{$_POST.CustomerCity}}"
              },
              {
                "name": ":P6",
                "type": "expression",
                "value": "{{$_POST.CustomerState}}"
              },
              {
                "name": ":P7",
                "type": "expression",
                "value": "{{$_POST.CustomerZip}}"
              },
              {
                "name": ":P8",
                "type": "expression",
                "value": "{{$_POST.CustomerCountry}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P9",
                "value": "{{$_POST.CustomerID}}"
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
    ]
  }
}
JSON
);
?>