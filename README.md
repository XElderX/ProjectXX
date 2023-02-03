

## About Project

This is project XX

## technologies used:

* uuid generator: composer require webpatser/laravel-uuid
* flags (https://github.com/lipis/flag-icons) use (import "/node_modules/flag-icons/css/flag-icons.min.css";)

## ChangeLog

# First batch (pushed 03.11.2022)

#### 2022.09.29

* settin up the project;
* User, Country, Town models created
* controllers store method created 
* user country town tests made

#### 2022.09.30

* Club model created
* Club controller created

#### 2022.10.29

* JWT implementation
* Updated blade templates for dashboard 
* Added User model blades
* added column into user table with column name disabled, it stores true or false 

#### 2022.11.01

* added new column 'logins' into users table it stores last 20 logins information
* implement method to extract user ip address and store it into databased table
* updating login logic as it now checks if user is disabled or nor 

#### 2022.11.02

* added blades for Country model
* added modal boxes on .blade.php templates to have create, view or update page to pop up in index view.

# Second batch (...)

#### 2022.11.03

* added blade template for Town model
* implemented it add, delete, update methods, request validation

#### 2022.11.04

* added blade template for Club model
* implemented it add, delete, update methods, request validation
* updated club migration changing foreignt keys constrains now user_id and town_id can be nullable
* Using JS implemented dynamic dependenced dropdown for country->town selection 

#### 2022.11.19

* added blade templates for Player model
* implemented it add, delete, update methods, request validation

#### 2023.01.23

* added back to dashboard button on each index blade to navigate back to dashboard page.

#### 2023.02.03
* Corrected add player form css









