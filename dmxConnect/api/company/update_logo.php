<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "settings": {
    "options": {}
  },
  "meta": {
    "options": {
      "linkedFile": "/admin/_company.html",
      "linkedForm": "frmLogoUpdate"
    },
    "$_POST": [
      {
        "type": "file",
        "fieldName": "logo",
        "name": "logo",
        "sub": [
          {
            "name": "name",
            "type": "text"
          },
          {
            "name": "type",
            "type": "text"
          },
          {
            "name": "size",
            "type": "number"
          },
          {
            "name": "error",
            "type": "text"
          }
        ],
        "outputType": "file"
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
        "name": "existsCompanyLogo",
        "module": "fs",
        "action": "direxists",
        "options": {
          "path": "/assets/images/company_logo",
          "then": {
            "steps": {
              "name": "removeCompanyLogo",
              "module": "fs",
              "action": "removedir",
              "options": {
                "path": "/assets/images/company_logo"
              },
              "outputType": "boolean"
            }
          }
        },
        "outputType": "boolean"
      },
      {
        "name": "uplLogo",
        "module": "upload",
        "action": "upload",
        "options": {
          "fields": "{{$_POST.logo}}",
          "path": "/assets/images/company_logo",
          "replaceSpace": true,
          "replaceDiacritics": true,
          "asciiOnly": true
        },
        "meta": [
          {
            "name": "name",
            "type": "text"
          },
          {
            "name": "path",
            "type": "text"
          },
          {
            "name": "url",
            "type": "text"
          },
          {
            "name": "type",
            "type": "text"
          },
          {
            "name": "size",
            "type": "text"
          },
          {
            "name": "error",
            "type": "number"
          }
        ],
        "outputType": "file"
      },
      {
        "name": "updCompanyLogo",
        "module": "dbupdater",
        "action": "update",
        "options": {
          "connection": "db",
          "sql": {
            "type": "update",
            "values": [
              {
                "table": "company",
                "column": "CompanyLogo",
                "type": "text",
                "value": "{{uplLogo.name}}"
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
            "query": "UPDATE company\nSET CompanyLogo = :P1 /* {{uplLogo.name}} */\nWHERE CompanyID = :P2 /* {{$_POST.CompanyID}} */",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{uplLogo.name}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P2",
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