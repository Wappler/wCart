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
        "meta"  : {"allTables":["categories","company","countries","currencies","customers","metatags","orderdetails","orders","payment_gateway","product_images","products","regions","users"],"allViews":[],"tables":{"countries":{"columns":{"CountryID":{"type":"int","primary":true},"CountryISO":{"type":"char","size":2},"CountryName":{"type":"varchar","size":80},"CountryRegionName":{"type":"char","size":30,"nullable":true},"CountryRegionRequired":{"type":"tinyint","defaultValue":"0"}}},"currencies":{"columns":{"CurrencyID":{"type":"int","primary":true},"CurrencyCountryISO":{"type":"varchar","size":5},"CurrencyISO":{"type":"varchar","size":5,"nullable":true}}}}}
    }
}
JSON;
?>