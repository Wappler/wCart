<?php
require('../dmxConnectLib/dmxConnect.php');

$app = new \lib\App();

$app->exec(<<<'JSON'
{
	"steps": [
		"Connections/db",
		"SecurityProviders/adminsecurity",
		{
			"module": "auth",
			"action": "restrict",
			"options": {"loginUrl":"login.html","provider":"adminsecurity"}
		}
	]
}
JSON
, TRUE);
?>
<!doctype html>
<html lang="en">

<head>
	<meta name="ac:route" content="/admin/">
	<base href="/admin/">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administration</title>

	<link rel="stylesheet" href="../bootstrap/4/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
	<link rel="stylesheet" href="../dmxAppConnect/dmxMediumEditor/dmxMediumEditor.css" />
	<link rel="stylesheet" href="../dmxAppConnect/dmxMediumEditor/themes/default.css" />
	<link rel="stylesheet" href="../dmxAppConnect/dmxMediumEditor/medium-editor.css" />
	<link rel="stylesheet" href="../dmxAppConnect/dmxNotifications/dmxNotifications.css">
	<link rel="stylesheet" href="../dmxAppConnect/dmxBootstrap4TableGenerator/dmxBootstrap4TableGenerator.css">
	<link rel="stylesheet" href="../dmxAppConnect/dmxDropzone/dmxDropzone.css">
	<link rel="stylesheet" href="../dmxAppConnect/dmxValidator/dmxValidator.css">

	<script src="../dmxAppConnect/dmxAppConnect.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
	<script src="../dmxAppConnect/dmxRouting/dmxRouting.js" defer=""></script>
	<script src="../dmxAppConnect/dmxBootstrap4Navigation/dmxBootstrap4Navigation.js" defer=""></script>
	<script src="../dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
	<script src="../dmxAppConnect/dmxFormatter/dmxFormatter.js" defer=""></script>
	<script src="../dmxAppConnect/dmxDataTraversal/dmxDataTraversal.js" defer=""></script>
	<script src="../dmxAppConnect/dmxNotifications/dmxNotifications.js" defer=""></script>
	<script src="../dmxAppConnect/dmxBootstrap4Modal/dmxBootstrap4Modal.js" defer=""></script>
	<script src="../dmxAppConnect/dmxDropzone/dmxDropzone.js" defer=""></script>
	<script src="../dmxAppConnect/dmxValidator/dmxValidator.js" defer=""></script>
	<script src="../dmxAppConnect/dmxMediumEditor/medium-editor.js" defer=""></script>
	<script src="../dmxAppConnect/dmxMediumEditor/dmxMediumEditor.js" defer=""></script>
</head>

<body id="admin" is="dmx-app">
	<dmx-serverconnect id="scLogout" url="../dmxConnect/api/security/adminLogout.php" noload="noload" dmx-on:success="browser.goto('login.html')"></dmx-serverconnect>
	<dmx-serverconnect id="scUser" url="../dmxConnect/api/security/adminDetails.php"></dmx-serverconnect>
	<dmx-serverconnect id="scCompany" url="../dmxConnect/api/company/list.php"></dmx-serverconnect>
	<dmx-serverconnect id="scAdministrators" url="../dmxConnect/api/administrators/list.php"></dmx-serverconnect>
	<dmx-serverconnect id="scCustomers" url="../dmxConnect/api/customers/list.php"></dmx-serverconnect>
	<dmx-serverconnect id="scOrders" url="../dmxConnect/api/orders/list_admin.php"></dmx-serverconnect>
	<dmx-serverconnect id="scInvoice" url="../dmxConnect/api/orderdetails/invoice_admin.php"></dmx-serverconnect>
	<dmx-serverconnect id="scProducts" url="../dmxConnect/api/products/list.php"></dmx-serverconnect>
	<dmx-serverconnect id="scProductImages" url="../dmxConnect/api/product_images/list.php"></dmx-serverconnect>
	<dmx-serverconnect id="scCategories" url="../dmxConnect/api/categories/list.php"></dmx-serverconnect>
	<dmx-serverconnect id="scMetatags" url="../dmxConnect/api/metatags/list.php" dmx-param:sort=""></dmx-serverconnect>
	<dmx-data-detail id="ddCategory" dmx-bind:data="scCategories.data.qryCategories" key="CategoryID"></dmx-data-detail>
	<dmx-data-view id="dvMetatags" dmx-bind:data="scMetatags.data.qryMetaTags" filter="!metaURL.startsWith(&quot;/products/&quot;)" sortOn="metaPage"></dmx-data-view>
	<dmx-data-view id="dvProductImages" dmx-bind:data="scProductImages.data.qryImages" filter="(ProductImageProductID == ddProduct.data.ProductID)"></dmx-data-view>
	<dmx-data-detail id="ddAdministrator" dmx-bind:data="scAdministrators.data.qryAdministrators" key="UserID"></dmx-data-detail>
	<dmx-data-detail id="ddCustomer" dmx-bind:data="scCustomers.data.qryCustomers" key="CustomerID">

	</dmx-data-detail>
	<dmx-data-detail id="ddInvoice" dmx-bind:data="scInvoice.data.rptOrders" key="OrderID"></dmx-data-detail>
	<dmx-data-detail id="ddProduct" dmx-bind:data="scProducts.data.rptProducts" key="ProductID"></dmx-data-detail>
	<dmx-data-detail id="ddProductImage" dmx-bind:data="dvProductImages.data" key="ProductImageID"></dmx-data-detail>

	<dmx-data-detail id="ddMetatag" dmx-bind:data="dvMetatags.data" key="metaID"></dmx-data-detail>
	<div is="dmx-browser" id="browser"></div>
	<dmx-notifications id="notifies" offset-y="45"></dmx-notifications>

	<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#" dmx-text="scCompany.data.qryCompany.CompanyName">Company name</a>
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap">
				<a class="nav-link" href="#" dmx-on:click="scLogout.load()">Sign out</a>
			</li>
		</ul>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link active" href="./">
								<i class="fas fa-home fa-fw"></i>&nbsp;Dashboard
							</a>
						</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot;)">
							<a class="nav-link" href="./seo">
								<i class="fas fa-chart-bar fa-fw"></i>&nbsp;SEO
							</a>
						</li>
						<li class="dropdown-divider" style="border-top: 1px solid #d2d4d6;"></li>
						<li class="nav-item font-weight-bold text-center"
							dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Sales Manager&quot;))">Sales</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Sales Manager&quot;))">
							<a class="nav-link" href="./orders">
								<i class="fas fa-file fa-fw"></i>&nbsp;Orders
							</a>
						</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Sales Manager&quot;))">
							<a class="nav-link" href="./customers">
								<i class="fas fa-users fa-fw"></i>&nbsp;Customers
							</a>
						</li>
						<li class="dropdown-divider" style="border-top: 1px solid #d2d4d6;"
							dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Sales Manager&quot;))"></li>
						<li class="nav-item font-weight-bold text-center"
							dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Products Manager&quot;))">Products</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Products Manager&quot;))">
							<a class="nav-link" href="./products">
								<i class="fas fa-shopping-cart fa-fw"></i>&nbsp;Products
							</a>
						</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Products Manager&quot;))">
							<a class="nav-link" href="./categories">
								<i class="fas fa-tags fa-fw"></i>&nbsp;Categories
							</a>
						</li>
						<li class="dropdown-divider" style="border-top: 1px solid #d2d4d6;"
							dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot; || scUser.data.qryUsers.UserLevel == &quot;Supervisor&quot; || (scUser.data.qryUsers.UserLevel == &quot;Products Manager&quot;))"></li>
						<li class="nav-item font-weight-bold text-center" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot;)">Company</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot;)">
							<a class="nav-link" href="./company">
								<i class="fas fa-building fa-fw"></i>&nbsp;Company
							</a>
						</li>
						<li class="nav-item" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot;)">
							<a class="nav-link" href="./administrators">
								<i class="fas fa-user-friends fa-fw"></i>&nbsp;Administrators
							</a>
						</li>
						<li class="dropdown-divider" style="border-top: 1px solid #d2d4d6;" dmx-show="(scUser.data.qryUsers.UserLevel == &quot;Manager&quot;)"></li>
					</ul>
				</div>
			</nav>
		</div>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="container mt-5">
				<div class="row">
					<div class="col">
						<div is="dmx-route" path="/" url="_dashboard.html" id="rteDashboard" exact></div>
						<div is="dmx-route" path="/orders" url="_orders.html" id="rteOrders"></div>
						<div is="dmx-route" path="/customers" url="_customers.html" id="rteCustomers" exact></div>
						<div is="dmx-route" path="/administrators" url="_administrators.html" id="rteAdministrators" exact></div>
						<div is="dmx-route" path="/seo" url="_seo.html" id="rteMetatags"></div>
						<div is="dmx-route" path="/company" url="_company.html" id="rteCompany" exact></div>
						<div is="dmx-route" path="/categories" url="_categories.html" id="rteCategories" exact></div>
						<div is="dmx-route" path="/products" url="_products.html" exact id="rteProducts"></div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="mdlLogin" is="dmx-bs4-modal" tabindex="-1" role="dialog" dmx-bind:show="">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Modal body text goes here.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	<script src="../bootstrap/4/js/bootstrap.min.js"></script>
	<script src="../bootstrap/4/js/popper.min.js"></script>
	<!--sortableScript-->
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
			$( "#record" ).sortable({cursor: "move"},{revert:true},{scroll:true},{scrollSensitivity: 10},{tolerance: "pointer"});
			$( "#record" ).disableSelection();
			$( "#record" ).sortable({
				update: function( event, ui ) {
					var listItems = $('#record div');
					listItems.each(function(idx) {
						$(this).find('.cos').val(idx+1);
					});
				}
			});
		});
	</script>
	<!--//sortableScript-->
</body>

</html>