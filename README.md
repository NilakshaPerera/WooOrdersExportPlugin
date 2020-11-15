<p align=**center**>Wordpress WooCommerce Assessment</p>

## WooOrdersExportPlugin
A Wordpress plugin built as an enhancement plugin for WooCommerce that demonstrated orders data export in CSV format.

## Setting up the application into your local machine
 
1. Have the applicatoin cloned into your local machine XAMPP htdocs path.
2. Get the sql file inside the source code's **database** folder. Create a database in your database and import the SQL file to generate the databse.
3. Open up the **wp_options** table and find the records under option_name, **siteurl** and **home** and update the **option_value** fields with the current setup path in your local apache server.
4. Access the **wp-config.php** file and updata the followings in the file.
    - **DB_NAME** Define the database name as you imported to your database.
    - **DB_USER** Define as your database engine user name.
    - **DB_PASSWORD** Define your database password here.
5. You are now good to run the application.
6. Access the admin login by appending **admin** to the URL from the hosted loacation.
    - The default username of the application is *perera.nilaksha@gmail.com*
    - The default password for the applicatio is *password*. Use these credentials and login.
6. Access the installed plugins in the applicatoin, if requires enable the plugins **WooCommerce** and **WooOrderExport**.
7. Access the **Orders** sub menu under **Woocommerce** main menu and find the **Export CSV** button activated by the plugin. 

## Usage

* This plugin will export a CSV containing *Order_Number*, *Order_Date*, *Order_Status*,*Customer_Name*, *Order_Total* or the orders, filtered by the order statuses, pagination, dates and registered customers.

* Also the records will be rearranged based on the *Order*, *Date*, and *Total* by ascending and descending order.

