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
        "meta"  : {"allTables":["categories","company","countries","currencies","customers","metatags","orderdetails","orders","payment_gateway","product_images","products","regions","users"],"allViews":[],"tables":{"customers":{"columns":{"CustomerID":{"type":"int","primary":true},"CustomerEmail":{"type":"varchar","size":60,"nullable":true},"CustomerPassword":{"type":"varchar","size":64,"nullable":true},"CustomerFirstName":{"type":"varchar","size":50,"nullable":true},"CustomerLastName":{"type":"varchar","size":50,"nullable":true},"CustomerAddress":{"type":"varchar","size":60,"nullable":true},"CustomerCity":{"type":"varchar","size":30,"nullable":true},"CustomerState":{"type":"varchar","size":20,"nullable":true},"CustomerZip":{"type":"varchar","size":12,"nullable":true},"CustomerCountry":{"type":"varchar","size":20,"nullable":true},"CustomerPhone":{"type":"varchar","size":20,"nullable":true},"CustomerEmailVerified":{"type":"tinyint","nullable":true,"defaultValue":"0"},"CustomerRegistrationDate":{"type":"timestamp","nullable":true,"defaultValue":"CURRENT_TIMESTAMP"},"CustomerVerificationCode":{"type":"varchar","size":20,"nullable":true},"CustomerIP":{"type":"varchar","size":50,"nullable":true},"CustomerPaymentGatewayID":{"type":"varchar","size":50,"nullable":true}}},"users":{"columns":{"UserID":{"type":"int","primary":true},"UserName":{"type":"varchar","size":50,"nullable":true},"UserPassword":{"type":"varchar","size":64,"nullable":true},"UserLevel":{"type":"varchar","size":50,"nullable":true}}}}}
    }
}
JSON;
?>