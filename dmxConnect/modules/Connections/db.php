<?php
// Database Type : "MySQL"
// Database Adapter : "mysql"
$exports = <<<'JSON'
{
    "name": "db",
    "module": "dbconnector",
    "action": "connect",
    "options": {
        "server": "mysql",
        "connectionString": "mysql:host=db;sslverify=false;port=3306;dbname=wcart;user=db_user;password=tutRmDTf;charset=utf8",
        "limit" : 1000,
        "debug" : false,
        "meta"  : {"allTables":["categories","company","countries","customers","metatags","orderdetails","orders","products","regions","users"],"allViews":[],"tables":{"categories":{"columns":{"CategoryID":{"type":"int","primary":true},"CategoryName":{"type":"varchar","size":50},"CategoryURL":{"type":"varchar","size":50,"nullable":true},"CategoryMetaID":{"type":"int","nullable":true}}},"metatags":{"columns":{"metaID":{"type":"int","primary":true},"metaPage":{"type":"varchar","size":50,"nullable":true},"metaURL":{"type":"varchar","size":50,"nullable":true},"metaTitle":{"type":"varchar","size":100,"nullable":true},"metaDescription":{"type":"text","size":65535,"nullable":true}}},"products":{"columns":{"ProductID":{"type":"int","primary":true},"ProductSKU":{"type":"varchar","size":50,"nullable":true},"ProductName":{"type":"varchar","size":100,"nullable":true},"ProductPrice":{"type":"float","nullable":true},"ProductWeight":{"type":"float","nullable":true},"ProductCartDesc":{"type":"varchar","size":250,"nullable":true},"ProductShortDesc":{"type":"varchar","size":1000,"nullable":true},"ProductLongDesc":{"type":"text","size":65535,"nullable":true},"ProductThumb":{"type":"varchar","size":100,"nullable":true},"ProductImage":{"type":"varchar","size":100,"nullable":true},"ProductCategoryID":{"type":"int","nullable":true},"ProductUpdateDate":{"type":"timestamp","nullable":true,"defaultValue":"CURRENT_TIMESTAMP"},"ProductStock":{"type":"float","nullable":true},"ProductLive":{"type":"tinyint","nullable":true,"defaultValue":"0"},"ProductUnlimited":{"type":"tinyint","nullable":true,"defaultValue":"1"},"ProductLocation":{"type":"varchar","size":250,"nullable":true}}}}}
    }
}
JSON;
?>