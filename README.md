# wCart
An e-commerce site using Wappler

To Install:
1. Create a new project in Wappler
2. Where the New Project window states 'Clone Git...' enter https://github.com/Wappler/wCart.git
3. When creating a Target choose the Docker Engine as the type and  'wcart' as the Database Name. Make sure to choose 'No Sample Data'
4. If you want to use the Bootstrap source files to theme the project, type 'npm install' in the terminal window. It is best to restart wappler when done. Then enter 'gulp watch' in the terminal window to watch for changes in the Sass files. The CSS will be automatically created.
5. Login details, Username & Password are the same: admin (full access) - supervisor (no access to Company) - salesmanager (access to Orders and Customers) - productsmanager (access to Products and Categories). Recommend change for production.

Note:
The project is yet to be completed. The intention of this early release is to get feedback with a view of improving the project as well as to iron out problems.

Please enjoy,
Ben
