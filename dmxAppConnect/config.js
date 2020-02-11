dmx.config({
  "index": {
    "dvMetaTags": {
      "meta": [
        {
          "name": "metaID",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaDescription",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "ddMetatag": {
      "meta": [
        {
          "name": "metaID",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaDescription",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "ddProduct": {
      "meta": [
        {
          "name": "ProductID",
          "type": "number"
        },
        {
          "name": "ProductSKU",
          "type": "text"
        },
        {
          "name": "ProductName",
          "type": "text"
        },
        {
          "name": "ProductPrice",
          "type": "number"
        },
        {
          "name": "ProductWeight",
          "type": "number"
        },
        {
          "name": "ProductCartDesc",
          "type": "text"
        },
        {
          "name": "ProductShortDesc",
          "type": "text"
        },
        {
          "name": "ProductLongDesc",
          "type": "text"
        },
        {
          "name": "ProductThumb",
          "type": "text"
        },
        {
          "name": "ProductImage",
          "type": "text"
        },
        {
          "name": "ProductCategoryID",
          "type": "number"
        },
        {
          "name": "ProductUpdateDate",
          "type": "datetime"
        },
        {
          "name": "ProductStock",
          "type": "number"
        },
        {
          "name": "ProductLive",
          "type": "number"
        },
        {
          "name": "ProductUnlimited",
          "type": "number"
        },
        {
          "name": "ProductLocation",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "dvOrders": {
      "meta": [
        {
          "name": "OrderAmount",
          "type": "number"
        },
        {
          "name": "OrderCity",
          "type": "text"
        },
        {
          "name": "OrderCountry",
          "type": "text"
        },
        {
          "name": "OrderCustomerID",
          "type": "number"
        },
        {
          "name": "OrderDate",
          "type": "datetime"
        },
        {
          "name": "OrderEmail",
          "type": "text"
        },
        {
          "name": "OrderID",
          "type": "number"
        },
        {
          "name": "OrderPhone",
          "type": "text"
        },
        {
          "name": "OrderPostage",
          "type": "number"
        },
        {
          "name": "OrderShipAddress",
          "type": "text"
        },
        {
          "name": "OrderShipAddress2",
          "type": "text"
        },
        {
          "name": "OrderShipName",
          "type": "text"
        },
        {
          "name": "OrderShipped",
          "type": "number"
        },
        {
          "name": "OrderState",
          "type": "text"
        },
        {
          "name": "OrderTax",
          "type": "number"
        },
        {
          "name": "OrderTrackingNumber",
          "type": "text"
        },
        {
          "name": "OrderZip",
          "type": "text"
        },
        {
          "name": "qryOrderDetail",
          "type": "array",
          "sub": []
        }
      ],
      "outputType": "array"
    },
    "query": [
      {
        "type": "number",
        "name": "id"
      }
    ],
    "tableRepeat1": {
      "meta": [
        {
          "name": "DetailID",
          "type": "number"
        },
        {
          "name": "DetailOrderID",
          "type": "number"
        },
        {
          "name": "DetailProductID",
          "type": "number"
        },
        {
          "name": "DetailName",
          "type": "text"
        },
        {
          "name": "DetailPrice",
          "type": "number"
        },
        {
          "name": "DetailSKU",
          "type": "text"
        },
        {
          "name": "DetailQuantity",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "repeatcountries": {
      "meta": [
        {
          "name": "CountryID",
          "type": "number"
        },
        {
          "name": "CountryISO",
          "type": "text"
        },
        {
          "name": "CountryName",
          "type": "text"
        },
        {
          "name": "CountryRegionName",
          "type": "text"
        },
        {
          "name": "CountryRegionRequired",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "ddCountry": {
      "meta": [
        {
          "name": "CountryID",
          "type": "number"
        },
        {
          "name": "CountryISO",
          "type": "text"
        },
        {
          "name": "CountryName",
          "type": "text"
        },
        {
          "name": "CountryRegionName",
          "type": "text"
        },
        {
          "name": "CountryRegionRequired",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "dvCountryRegistrationFrm": {
      "meta": [
        {
          "name": "CountryID",
          "type": "number"
        },
        {
          "name": "CountryISO",
          "type": "text"
        },
        {
          "name": "CountryName",
          "type": "text"
        },
        {
          "name": "CountryRegionName",
          "type": "text"
        },
        {
          "name": "CountryRegionRequired",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "dvProducts": {
      "meta": [
        {
          "name": "ProductID",
          "type": "number"
        },
        {
          "name": "ProductSKU",
          "type": "text"
        },
        {
          "name": "ProductName",
          "type": "text"
        },
        {
          "name": "ProductPrice",
          "type": "number"
        },
        {
          "name": "ProductWeight",
          "type": "number"
        },
        {
          "name": "ProductCartDesc",
          "type": "text"
        },
        {
          "name": "ProductShortDesc",
          "type": "text"
        },
        {
          "name": "ProductLongDesc",
          "type": "text"
        },
        {
          "name": "ProductThumb",
          "type": "text"
        },
        {
          "name": "ProductImage",
          "type": "text"
        },
        {
          "name": "ProductCategoryID",
          "type": "number"
        },
        {
          "name": "ProductUpdateDate",
          "type": "datetime"
        },
        {
          "name": "ProductStock",
          "type": "number"
        },
        {
          "name": "ProductLive",
          "type": "number"
        },
        {
          "name": "ProductUnlimited",
          "type": "number"
        },
        {
          "name": "ProductLocation",
          "type": "text"
        },
        {
          "name": "CategoryID",
          "type": "number"
        },
        {
          "name": "CategoryName",
          "type": "text"
        },
        {
          "name": "CategoryURL",
          "type": "text"
        },
        {
          "name": "CategoryMetaID",
          "type": "number"
        },
        {
          "name": "qryImages",
          "type": "array",
          "sub": [
            {
              "name": "ProductImageID",
              "type": "number"
            },
            {
              "name": "ProductImageProductID",
              "type": "number"
            },
            {
              "name": "ProductImageFile",
              "type": "text"
            },
            {
              "name": "ProductImageDisplayOrder",
              "type": "number"
            }
          ]
        }
      ],
      "outputType": "array"
    },
    "rptcategories": {
      "meta": [
        {
          "name": "metaDescription",
          "type": "text"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "repeat1": {
      "meta": [
        {
          "name": "CategoryID",
          "type": "number"
        },
        {
          "name": "CategoryName",
          "type": "text"
        },
        {
          "name": "CategoryURL",
          "type": "text"
        },
        {
          "name": "CategoryMetaID",
          "type": "number"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaDescription",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "dvProductImages": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "dvProductsWithImages": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "dsCart": [
      {
        "type": "object",
        "name": "cart",
        "sub": [
          {
            "type": "key_array",
            "name": "cartitems",
            "sub": [
              {
                "type": "text",
                "name": "product"
              },
              {
                "type": "number",
                "name": "price"
              },
              {
                "type": "number",
                "name": "qty"
              }
            ]
          }
        ]
      },
      {
        "type": "object",
        "name": "subtotal"
      },
      {
        "type": "object",
        "name": "pid"
      }
    ]
  },
  "pgMetatags": {
    "ddMetatag": {
      "meta": [
        {
          "name": "metaID",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaDescription",
          "type": "text"
        }
      ],
      "outputType": "array"
    }
  },
  "userhome": {
    "rptOrders": {
      "meta": [],
      "outputType": "array"
    }
  },
  "metatags": {
    "rptMetaTags": {
      "meta": [
        {
          "name": "metaDescription",
          "type": "text"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        }
      ],
      "outputType": "array"
    }
  },
  "admin": {
    "dvAdminLevel": {
      "meta": [
        {
          "name": "UserLevel",
          "type": "text"
        },
        {
          "name": "UserLevelID",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "ddAdministrator": {
      "meta": [
        {
          "name": "UserID",
          "type": "number"
        },
        {
          "name": "UserLevel",
          "type": "number"
        },
        {
          "name": "UserName",
          "type": "text"
        },
        {
          "name": "UserPassword",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "ddCustomer": {
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
    "dvMetatags": {
      "meta": [
        {
          "name": "metaDescription",
          "type": "text"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "ddMetatag": {
      "meta": [
        {
          "name": "metaDescription",
          "type": "text"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "ddCategory": {
      "meta": [
        {
          "name": "CategoryID",
          "type": "number"
        },
        {
          "name": "CategoryName",
          "type": "text"
        },
        {
          "name": "CategoryURL",
          "type": "text"
        },
        {
          "name": "CategoryMetaID",
          "type": "number"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaDescription",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "ddInvoice": {
      "meta": [
        {
          "name": "OrderID",
          "type": "number"
        },
        {
          "name": "OrderCustomerID",
          "type": "number"
        },
        {
          "name": "OrderAmount",
          "type": "number"
        },
        {
          "name": "OrderShipName",
          "type": "text"
        },
        {
          "name": "OrderShipAddress",
          "type": "text"
        },
        {
          "name": "OrderShipAddress2",
          "type": "text"
        },
        {
          "name": "OrderCity",
          "type": "text"
        },
        {
          "name": "OrderState",
          "type": "text"
        },
        {
          "name": "OrderZip",
          "type": "text"
        },
        {
          "name": "OrderCountry",
          "type": "text"
        },
        {
          "name": "OrderPhone",
          "type": "text"
        },
        {
          "name": "OrderPostage",
          "type": "number"
        },
        {
          "name": "OrderTax",
          "type": "number"
        },
        {
          "name": "OrderEmail",
          "type": "text"
        },
        {
          "name": "OrderDate",
          "type": "datetime"
        },
        {
          "name": "OrderShipped",
          "type": "number"
        },
        {
          "name": "OrderTrackingNumber",
          "type": "text"
        },
        {
          "name": "CustomerEmail",
          "type": "text"
        },
        {
          "name": "CustomerFirstName",
          "type": "text"
        },
        {
          "name": "CustomerLastName",
          "type": "text"
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
          "name": "CustomerState",
          "type": "text"
        },
        {
          "name": "CustomerZip",
          "type": "text"
        },
        {
          "name": "CustomerCountry",
          "type": "text"
        },
        {
          "name": "qryOrderDetails",
          "type": "array",
          "sub": [
            {
              "name": "DetailID",
              "type": "number"
            },
            {
              "name": "DetailOrderID",
              "type": "number"
            },
            {
              "name": "DetailProductID",
              "type": "number"
            },
            {
              "name": "DetailName",
              "type": "text"
            },
            {
              "name": "DetailPrice",
              "type": "number"
            },
            {
              "name": "DetailSKU",
              "type": "text"
            },
            {
              "name": "DetailQuantity",
              "type": "number"
            }
          ]
        }
      ],
      "outputType": "array"
    },
    "ddProduct": {
      "meta": [
        {
          "name": "ProductID",
          "type": "number"
        },
        {
          "name": "ProductSKU",
          "type": "text"
        },
        {
          "name": "ProductName",
          "type": "text"
        },
        {
          "name": "ProductPrice",
          "type": "number"
        },
        {
          "name": "ProductWeight",
          "type": "number"
        },
        {
          "name": "ProductCartDesc",
          "type": "text"
        },
        {
          "name": "ProductShortDesc",
          "type": "text"
        },
        {
          "name": "ProductLongDesc",
          "type": "text"
        },
        {
          "name": "ProductThumb",
          "type": "text"
        },
        {
          "name": "ProductImage",
          "type": "text"
        },
        {
          "name": "ProductCategoryID",
          "type": "number"
        },
        {
          "name": "ProductUpdateDate",
          "type": "datetime"
        },
        {
          "name": "ProductStock",
          "type": "number"
        },
        {
          "name": "ProductLive",
          "type": "number"
        },
        {
          "name": "ProductUnlimited",
          "type": "number"
        },
        {
          "name": "ProductLocation",
          "type": "text"
        },
        {
          "name": "CategoryID",
          "type": "number"
        },
        {
          "name": "CategoryName",
          "type": "text"
        },
        {
          "name": "CategoryURL",
          "type": "text"
        },
        {
          "name": "CategoryMetaID",
          "type": "number"
        },
        {
          "name": "qryImages",
          "type": "array",
          "sub": [
            {
              "name": "ProductImageID",
              "type": "number"
            },
            {
              "name": "ProductImageProductID",
              "type": "number"
            },
            {
              "name": "ProductImageFile",
              "type": "text"
            },
            {
              "name": "ProductImageDisplayOrder",
              "type": "number"
            }
          ]
        }
      ],
      "outputType": "array"
    },
    "dvProductImages": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "ddProductImage": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    }
  },
  "products": {
    "rptProducts": {
      "meta": null,
      "outputType": "array"
    },
    "repeat1": {
      "meta": [
        {
          "name": "ProductID",
          "type": "number"
        },
        {
          "name": "ProductSKU",
          "type": "text"
        },
        {
          "name": "ProductName",
          "type": "text"
        },
        {
          "name": "ProductPrice",
          "type": "number"
        },
        {
          "name": "ProductWeight",
          "type": "number"
        },
        {
          "name": "ProductCartDesc",
          "type": "text"
        },
        {
          "name": "ProductShortDesc",
          "type": "text"
        },
        {
          "name": "ProductLongDesc",
          "type": "text"
        },
        {
          "name": "ProductThumb",
          "type": "text"
        },
        {
          "name": "ProductImage",
          "type": "text"
        },
        {
          "name": "ProductCategoryID",
          "type": "number"
        },
        {
          "name": "ProductUpdateDate",
          "type": "datetime"
        },
        {
          "name": "ProductStock",
          "type": "number"
        },
        {
          "name": "ProductLive",
          "type": "number"
        },
        {
          "name": "ProductUnlimited",
          "type": "number"
        },
        {
          "name": "ProductLocation",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "rptimages": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "rptImages": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    }
  },
  "appMetatags": {
    "rptMetaTags": {
      "meta": [
        {
          "name": "metaDescription",
          "type": "text"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        }
      ],
      "outputType": "array"
    }
  },
  "appOrders": {
    "rptOrderDetail": {
      "meta": [
        {
          "name": "DetailID",
          "type": "number"
        },
        {
          "name": "DetailOrderID",
          "type": "number"
        },
        {
          "name": "DetailProductID",
          "type": "number"
        },
        {
          "name": "DetailName",
          "type": "text"
        },
        {
          "name": "DetailPrice",
          "type": "number"
        },
        {
          "name": "DetailSKU",
          "type": "text"
        },
        {
          "name": "DetailQuantity",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "rptOrderDetails": {
      "meta": [
        {
          "name": "DetailID",
          "type": "number"
        },
        {
          "name": "DetailOrderID",
          "type": "number"
        },
        {
          "name": "DetailProductID",
          "type": "number"
        },
        {
          "name": "DetailName",
          "type": "text"
        },
        {
          "name": "DetailPrice",
          "type": "number"
        },
        {
          "name": "DetailSKU",
          "type": "text"
        },
        {
          "name": "DetailQuantity",
          "type": "number"
        }
      ],
      "outputType": "array"
    }
  },
  "appProducts": {
    "rptCategories": {
      "meta": [
        {
          "name": "CategoryID",
          "type": "number"
        },
        {
          "name": "CategoryName",
          "type": "text"
        },
        {
          "name": "CategoryURL",
          "type": "text"
        },
        {
          "name": "CategoryMetaID",
          "type": "number"
        },
        {
          "name": "metaID",
          "type": "number"
        },
        {
          "name": "metaPage",
          "type": "text"
        },
        {
          "name": "metaURL",
          "type": "text"
        },
        {
          "name": "metaTitle",
          "type": "text"
        },
        {
          "name": "metaDescription",
          "type": "text"
        }
      ],
      "outputType": "array"
    },
    "rptProducts": {
      "meta": [
        {
          "name": "$index",
          "type": "number"
        },
        {
          "name": "$key",
          "type": "text"
        },
        {
          "name": "$value",
          "type": "object"
        },
        {
          "name": "ProductID",
          "type": "number"
        },
        {
          "name": "ProductSKU",
          "type": "text"
        },
        {
          "name": "ProductName",
          "type": "text"
        },
        {
          "name": "ProductPrice",
          "type": "number"
        },
        {
          "name": "ProductWeight",
          "type": "number"
        },
        {
          "name": "ProductCartDesc",
          "type": "text"
        },
        {
          "name": "ProductShortDesc",
          "type": "text"
        },
        {
          "name": "ProductLongDesc",
          "type": "text"
        },
        {
          "name": "ProductThumb",
          "type": "text"
        },
        {
          "name": "ProductImage",
          "type": "text"
        },
        {
          "name": "ProductCategoryID",
          "type": "number"
        },
        {
          "name": "ProductUpdateDate",
          "type": "datetime"
        },
        {
          "name": "ProductStock",
          "type": "number"
        },
        {
          "name": "ProductLive",
          "type": "number"
        },
        {
          "name": "ProductUnlimited",
          "type": "number"
        },
        {
          "name": "ProductLocation",
          "type": "text"
        },
        {
          "name": "CategoryID",
          "type": "number"
        },
        {
          "name": "CategoryName",
          "type": "text"
        },
        {
          "name": "CategoryURL",
          "type": "text"
        },
        {
          "name": "CategoryMetaID",
          "type": "number"
        },
        {
          "name": "qryImages",
          "type": "array",
          "sub": [
            {
              "name": "ProductImageID",
              "type": "number"
            },
            {
              "name": "ProductImageProductID",
              "type": "number"
            },
            {
              "name": "ProductImageFile",
              "type": "text"
            },
            {
              "name": "ProductImageDisplayOrder",
              "type": "number"
            }
          ]
        }
      ],
      "outputType": "array"
    },
    "rptImages": {
      "meta": [
        {
          "name": "ProductImageID",
          "type": "number"
        },
        {
          "name": "ProductImageProductID",
          "type": "number"
        },
        {
          "name": "ProductImageFile",
          "type": "text"
        },
        {
          "name": "ProductImageDisplayOrder",
          "type": "number"
        }
      ],
      "outputType": "array"
    }
  }
});
