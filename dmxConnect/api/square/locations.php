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
        "name": "qryPaymentGateway",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "db",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "payment_gateway",
                "column": "*"
              }
            ],
            "table": {
              "name": "payment_gateway"
            },
            "joins": [],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "payment_gateway.PaymentGatewayName",
                  "field": "payment_gateway.PaymentGatewayName",
                  "type": "string",
                  "operator": "equal",
                  "value": "Square",
                  "data": {
                    "table": "payment_gateway",
                    "column": "PaymentGatewayName",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM payment_gateway\nWHERE PaymentGatewayName = 'Square'",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "PaymentGatewayID",
            "type": "number"
          },
          {
            "name": "PaymentGatewayName",
            "type": "text"
          },
          {
            "name": "PaymentGatewayAuthorization",
            "type": "text"
          },
          {
            "name": "PaymentGatewaySandboxHost",
            "type": "text"
          },
          {
            "name": "PaymentGatewayHost",
            "type": "text"
          }
        ],
        "outputType": "object",
        "type": "dbconnector_single"
      },
      {
        "name": "apiLocations",
        "module": "api",
        "action": "send",
        "options": {
          "headers": {
            "Authorization": "Bearer {{qryPaymentGateway.PaymentGatewayAuthorization}}"
          },
          "url": "https://{{qryPaymentGateway.PaymentGatewaySandboxHost}}/v2/locations",
          "schema": []
        },
        "output": true,
        "meta": [
          {
            "type": "object",
            "name": "data",
            "sub": [
              {
                "type": "array",
                "name": "locations",
                "sub": [
                  {
                    "type": "text",
                    "name": "id"
                  },
                  {
                    "type": "text",
                    "name": "name"
                  },
                  {
                    "type": "object",
                    "name": "address",
                    "sub": [
                      {
                        "type": "text",
                        "name": "address_line_1"
                      },
                      {
                        "type": "text",
                        "name": "locality"
                      },
                      {
                        "type": "text",
                        "name": "administrative_district_level_1"
                      },
                      {
                        "type": "text",
                        "name": "postal_code"
                      },
                      {
                        "type": "text",
                        "name": "country"
                      }
                    ]
                  },
                  {
                    "type": "text",
                    "name": "timezone"
                  },
                  {
                    "type": "array",
                    "name": "capabilities",
                    "sub": [
                      {
                        "type": "text",
                        "name": "$value"
                      }
                    ]
                  },
                  {
                    "type": "text",
                    "name": "status"
                  },
                  {
                    "type": "text",
                    "name": "created_at"
                  },
                  {
                    "type": "text",
                    "name": "merchant_id"
                  },
                  {
                    "type": "text",
                    "name": "country"
                  },
                  {
                    "type": "text",
                    "name": "language_code"
                  },
                  {
                    "type": "text",
                    "name": "currency"
                  },
                  {
                    "type": "text",
                    "name": "business_name"
                  },
                  {
                    "type": "text",
                    "name": "type"
                  },
                  {
                    "type": "object",
                    "name": "business_hours"
                  },
                  {
                    "type": "text",
                    "name": "mcc"
                  }
                ]
              }
            ]
          },
          {
            "type": "object",
            "name": "headers",
            "sub": [
              {
                "type": "text",
                "name": "content-encoding"
              },
              {
                "type": "text",
                "name": "content-length"
              },
              {
                "type": "text",
                "name": "content-type"
              },
              {
                "type": "text",
                "name": "date"
              },
              {
                "type": "text",
                "name": "square-version"
              },
              {
                "type": "text",
                "name": "status"
              },
              {
                "type": "text",
                "name": "strict-transport-security"
              },
              {
                "type": "text",
                "name": "vary"
              },
              {
                "type": "text",
                "name": "x-content-type-options"
              },
              {
                "type": "text",
                "name": "x-download-options"
              },
              {
                "type": "text",
                "name": "x-frame-options"
              },
              {
                "type": "text",
                "name": "x-permitted-cross-domain-policies"
              },
              {
                "type": "text",
                "name": "x-xss-protection"
              }
            ]
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