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
        }
      ],
      "outputType": "array"
    }
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
    }
  },
  "products": {
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
        }
      ],
      "outputType": "array"
    }
  }
});
