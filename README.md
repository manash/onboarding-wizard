# onboarding-wizard

Overview

The sample app was built in angular js on the front end side, laravel on the back end & mySQL as the DB layer. The app is a on-boarding wizard, which takes the user through certain number of steps to complete the on-boarding process & after user is done through all the steps, takes them to the dashboard page. The onboarding can only happen once the user makes a login.


DB Design Schema

The tables designed for the application are as follows:

users: Once the user makes a registration, the corresponding user data gets stored in this table. When user makes a loging the credentials are validated against the one stored in this table. So the main purpose is basically authentication.

wizard: The purpose of this table is to have the support for multiple wizard/on-barding tool. Each wizard when created inserts a record in to this table & thus gives the support of running multiple  wizard/on-barding tool in the application.

wizard_steps: The table serves the purpose of defining the number of steps that the corresponding wizard/on-boarding tool has. The configuration for each step can be done in here, like whether the step can be skipped or not, what would be the order of the step as such.

store_details:  The table serves the purpose of storing the store related details for the wizard step defined & store all relavant information related to a store like name, address, city, pin, phone number as such.

store_products: This table stores the information regading the second step of store on boarding wizard & stores the name, price of the item wrt the store for which the item created.

user_store_setup: As one user can create multiple stores & as the design of on-boarding wizard had to be done in such a way that any incomplete onboarding will be shown to the user when the user makes a re-login, so this table keeps the association between user & store & the step that user is in right now.


Application overview

The user can proceed on to the onboarding tool upon making a login/registeration. If the on-boarding tool is not enabled from the database side, then user is directly redirected to the dashboard page.

The on-boarding tool lets the user through the number of steps defined for the corresponding on-boarding wizard/tool. In each step the user has some detail to be filled & depending on the configuration the tool decides whether the step can be skippable or not. The tool has support for going back & forth in the application.

Once the user skips the last step or clicks the button to go to dashboard, the application sets up the dashboard for the user in which the user can see the store created as well as the items created for each store.


APIs

Get User: /user/get/<email-address>, Method : GET
Ex: http://local.onboarding-wizard.com/user/get/manash082@gmail.com

Check Store Exist: /api/checkstorepresence/1<user-id>/<store-name>, Method: GET
Ex: http://local.onboarding-wizard.com/api/checkstorepresence/1/Al+Amanah+Cafe

Insert Store: api/insertstore, Method: POST
Ex: http://local.onboarding-wizard.com/api/insertstore
Payload: {
"userId" : "1",
"name" : "KFC",
"address" : "HSR layout main road",
"city" : "Bangalore",
"phone" : "9686935485",
"pin" : "560023"
}

Check Menu/Item Exist: /api/checkitempresence/<Store-id>/<item-name>, Method: Get
Ex: http://local.onboarding-wizard.com/api/checkitempresence/1/Chicken+Falafal+Roll

Get all Menu items belonging to a store: /api/getallstoreitems/<store-id>, Method: Get
Ex: http://local.onboarding-wizard.com/api/getallstoreitems/1


Setup Prerequisite

1. Please make sure the server has all the requirement that's needed for running laravel framework.
https://laravel.com/docs/5.2#server-requirements

2. Setup a virtual host & point it to public directory

<VirtualHost *:80>
ServerName local.onboarding-wizard.com

DocumentRoot /home/manash/Project/onboarding-wizard/public
    <Directory /home/manash/Project/onboarding-wizard/public>
        Options +Indexes +FollowSymLinks
        AllowOverride all
        Require all granted
    </Directory>
</VirtualHost>

3.  Run the sql file & give the corresponding DB details in .env file

FYI my config:
DB_HOST=localhost
DB_DATABASE=Wizards
DB_USERNAME=root
DB_PASSWORD=qkr123@#

4. Update the .env file with the domain name as given in the virtual host


