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
        "name": "CompanyAddress"
      },
      {
        "type": "text",
        "name": "CompanyBusinessID"
      },
      {
        "type": "text",
        "name": "CompanyCity"
      },
      {
        "type": "text",
        "name": "CompanyCountry"
      },
      {
        "type": "text",
        "name": "CompanyEmail"
      },
      {
        "type": "text",
        "name": "CompanyLogo"
      },
      {
        "type": "text",
        "name": "CompanyName"
      },
      {
        "type": "text",
        "name": "CompanyPhone"
      },
      {
        "type": "date",
        "name": "CompanyRegistrationDate"
      },
      {
        "type": "text",
        "name": "CompanyState"
      },
      {
        "type": "text",
        "name": "CompanyWebsite"
      },
      {
        "type": "text",
        "name": "CompanyZip"
      },
      {
        "type": "number",
        "name": "CompanyID"
      }
    ]
  },
  "exec": {
    "steps": [
      "Connections/db",
      "SecurityProviders/adminsecurity",
      {
        "name": "",
        "module": "auth",
        "action": "restrict",
        "options": {
          "provider": "adminsecurity",
          "permissions": [
            "Manager"
          ]
        }
      },
      {
        "name": "updComapny",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "company",
                "column": "CompanyAddress",
                "type": "text",
                "value": "{{$_POST.CompanyAddress}}"
              },
              {
                "table": "company",
                "column": "CompanyBusinessID",
                "type": "text",
                "value": "{{$_POST.CompanyBusinessID}}"
              },
              {
                "table": "company",
                "column": "CompanyCity",
                "type": "text",
                "value": "{{$_POST.CompanyCity}}"
              },
              {
                "table": "company",
                "column": "CompanyCountry",
                "type": "text",
                "value": "{{$_POST.CompanyCountry}}"
              },
              {
                "table": "company",
                "column": "CompanyEmail",
                "type": "text",
                "value": "{{$_POST.CompanyEmail}}"
              },
              {
                "table": "company",
                "column": "CompanyName",
                "type": "text",
                "value": "{{$_POST.CompanyName}}"
              },
              {
                "table": "company",
                "column": "CompanyPhone",
                "type": "text",
                "value": "{{$_POST.CompanyPhone}}"
              },
              {
                "table": "company",
                "column": "CompanyRegistrationDate",
                "type": "date",
                "value": "{{$_POST.CompanyRegistrationDate}}"
              },
              {
                "table": "company",
                "column": "CompanyState",
                "type": "text",
                "value": "{{$_POST.CompanyState}}"
              },
              {
                "table": "company",
                "column": "CompanyWebsite",
                "type": "text",
                "value": "{{$_POST.CompanyWebsite}}"
              },
              {
                "table": "company",
                "column": "CompanyZip",
                "type": "text",
                "value": "{{$_POST.CompanyZip}}"
              }
            ],
            "table": "company",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "CompanyID",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.CompanyID}}",
                  "data": {
                    "column": "CompanyID"
                  },
                  "operation": "="
                }
              ]
            },
            "query": "UPDATE company\nSET CompanyAddress = :P1 /* {{$_POST.CompanyAddress}} */, CompanyBusinessID = :P2 /* {{$_POST.CompanyBusinessID}} */, CompanyCity = :P3 /* {{$_POST.CompanyCity}} */, CompanyCountry = :P4 /* {{$_POST.CompanyCountry}} */, CompanyEmail = :P5 /* {{$_POST.CompanyEmail}} */, CompanyName = :P6 /* {{$_POST.CompanyName}} */, CompanyPhone = :P7 /* {{$_POST.CompanyPhone}} */, CompanyRegistrationDate = :P8 /* {{$_POST.CompanyRegistrationDate}} */, CompanyState = :P9 /* {{$_POST.CompanyState}} */, CompanyWebsite = :P10 /* {{$_POST.CompanyWebsite}} */, CompanyZip = :P11 /* {{$_POST.CompanyZip}} */\nWHERE CompanyID = :P12 /* {{$_POST.CompanyID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{$_POST.CompanyAddress}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.CompanyBusinessID}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{$_POST.CompanyCity}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.CompanyCountry}}"
              },
              {
                "name": ":P5",
                "type": "expression",
                "value": "{{$_POST.CompanyEmail}}"
              },
              {
                "name": ":P6",
                "type": "expression",
                "value": "{{$_POST.CompanyName}}"
              },
              {
                "name": ":P7",
                "type": "expression",
                "value": "{{$_POST.CompanyPhone}}"
              },
              {
                "name": ":P8",
                "type": "expression",
                "value": "{{$_POST.CompanyRegistrationDate}}"
              },
              {
                "name": ":P9",
                "type": "expression",
                "value": "{{$_POST.CompanyState}}"
              },
              {
                "name": ":P10",
                "type": "expression",
                "value": "{{$_POST.CompanyWebsite}}"
              },
              {
                "name": ":P11",
                "type": "expression",
                "value": "{{$_POST.CompanyZip}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P12",
                "value": "{{$_POST.CompanyID}}"
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