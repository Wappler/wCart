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
        "meta"  : {"allTables":["categories","company","countries","customers","metatags","orderdetails","orders","products","regions","users"],"allViews":[],"tables":{"orders":{"columns":{"OrderID":{"type":"int","primary":true},"OrderCustomerID":{"type":"int","nullable":true},"OrderAmount":{"type":"float","nullable":true},"OrderShipName":{"type":"varchar","size":100,"nullable":true},"OrderShipAddress":{"type":"varchar","size":100,"nullable":true},"OrderShipAddress2":{"type":"varchar","size":100,"nullable":true},"OrderCity":{"type":"varchar","size":50,"nullable":true},"OrderState":{"type":"varchar","size":50,"nullable":true},"OrderZip":{"type":"varchar","size":20,"nullable":true},"OrderCountry":{"type":"varchar","size":50,"nullable":true},"OrderPhone":{"type":"varchar","size":20,"nullable":true},"OrderPostage":{"type":"float","nullable":true},"OrderTax":{"type":"float","nullable":true},"OrderEmail":{"type":"varchar","size":100,"nullable":true},"OrderDate":{"type":"timestamp","defaultValue":"CURRENT_TIMESTAMP"},"OrderShipped":{"type":"tinyint","defaultValue":"0"},"OrderTrackingNumber":{"type":"varchar","size":80,"nullable":true}}},"customers":{"columns":{"CustomerID":{"type":"int","primary":true},"CustomerEmail":{"type":"varchar","size":60,"nullable":true},"CustomerPassword":{"type":"varchar","size":64,"nullable":true},"CustomerFirstName":{"type":"varchar","size":50,"nullable":true},"CustomerLastName":{"type":"varchar","size":50,"nullable":true},"CustomerAddress":{"type":"varchar","size":60,"nullable":true},"CustomerCity":{"type":"varchar","size":30,"nullable":true},"CustomerState":{"type":"varchar","size":20,"nullable":true},"CustomerZip":{"type":"varchar","size":12,"nullable":true},"CustomerCountry":{"type":"varchar","size":20,"nullable":true},"CustomerPhone":{"type":"varchar","size":20,"nullable":true},"CustomerEmailVerified":{"type":"tinyint","nullable":true,"defaultValue":"0"},"CustomerRegistrationDate":{"type":"timestamp","nullable":true,"defaultValue":"CURRENT_TIMESTAMP"},"CustomerVerificationCode":{"type":"varchar","size":20,"nullable":true},"CustomerIP":{"type":"varchar","size":50,"nullable":true}}}}}
    }
}
JSON;
?>