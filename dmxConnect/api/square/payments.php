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
    "steps": {
      "name": "apiPayments",
      "module": "api",
      "action": "send",
      "options": {
        "url": "https://connect.squareupsandbox.com/v2/payments",
        "headers": {
          "Authorization": "Bearer EAAAEAQ1NSr_EBvQvlrK2PEjASp1OFL67md8EV1rQHWMt4KcRB7_2_9b83EfQWHM"
        },
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
              "name": "payments",
              "sub": [
                {
                  "type": "text",
                  "name": "id"
                },
                {
                  "type": "text",
                  "name": "created_at"
                },
                {
                  "type": "text",
                  "name": "updated_at"
                },
                {
                  "type": "object",
                  "name": "amount_money",
                  "sub": [
                    {
                      "type": "number",
                      "name": "amount"
                    },
                    {
                      "type": "text",
                      "name": "currency"
                    }
                  ]
                },
                {
                  "type": "text",
                  "name": "status"
                },
                {
                  "type": "text",
                  "name": "source_type"
                },
                {
                  "type": "object",
                  "name": "card_details",
                  "sub": [
                    {
                      "type": "text",
                      "name": "status"
                    },
                    {
                      "type": "object",
                      "name": "card",
                      "sub": [
                        {
                          "type": "text",
                          "name": "card_brand"
                        },
                        {
                          "type": "text",
                          "name": "last_4"
                        },
                        {
                          "type": "number",
                          "name": "exp_month"
                        },
                        {
                          "type": "number",
                          "name": "exp_year"
                        },
                        {
                          "type": "text",
                          "name": "fingerprint"
                        },
                        {
                          "type": "text",
                          "name": "card_type"
                        },
                        {
                          "type": "text",
                          "name": "prepaid_type"
                        },
                        {
                          "type": "text",
                          "name": "bin"
                        }
                      ]
                    },
                    {
                      "type": "text",
                      "name": "entry_method"
                    },
                    {
                      "type": "text",
                      "name": "cvv_status"
                    },
                    {
                      "type": "text",
                      "name": "avs_status"
                    },
                    {
                      "type": "text",
                      "name": "statement_description"
                    }
                  ]
                },
                {
                  "type": "text",
                  "name": "location_id"
                },
                {
                  "type": "text",
                  "name": "order_id"
                },
                {
                  "type": "array",
                  "name": "processing_fee",
                  "sub": [
                    {
                      "type": "text",
                      "name": "effective_at"
                    },
                    {
                      "type": "text",
                      "name": "type"
                    },
                    {
                      "type": "object",
                      "name": "amount_money",
                      "sub": [
                        {
                          "type": "number",
                          "name": "amount"
                        },
                        {
                          "type": "text",
                          "name": "currency"
                        }
                      ]
                    }
                  ]
                },
                {
                  "type": "object",
                  "name": "total_money",
                  "sub": [
                    {
                      "type": "number",
                      "name": "amount"
                    },
                    {
                      "type": "text",
                      "name": "currency"
                    }
                  ]
                },
                {
                  "type": "text",
                  "name": "receipt_number"
                },
                {
                  "type": "text",
                  "name": "receipt_url"
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
              "name": "frame-options"
            },
            {
              "type": "text",
              "name": "square-version"
            },
            {
              "type": "text",
              "name": "squareup--connect--v2--common--versionmetadata-bin"
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
              "name": "x-frame-options"
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
  }
}
JSON
);
?>