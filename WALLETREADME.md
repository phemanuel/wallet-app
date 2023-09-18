E-WALLET
-----

### Introduction

E-wallet is a virtual storage system that allows students to securely store, manage, and transact. E-wallet can be used for a wide range of purposes, including bill payments, fund transfers.


### Overview

The app is able to do the following operations:

* creating new wallet account.
* edit existing wallet account.
* loading wallet account.
* transfer funds to other wallet account.
* detailed analysis of transactions.


### Tech Stack

Our tech stack will include:

* **Laravel ORM** to be our ORM library of choice
* **MYSQL** as our database of choice
* **LARAVEL 10** and **PHP** as our server language and server framework
* **Laravel-Migrate** for creating and running schema migrations
* **HTML**, **CSS**, and **Javascript** with [Bootstrap 3] for our website's frontend

### Main Files: Project Structure

  ```sh
  ├── README.md
  ├── artisan.php *** the main driver of the app
  ├── env *** Database configuration settings
 
Overall:
* Models are located in app/models
* Controllers are also located in app/http/controllers
* The web frontend is located in resources/views/

MVC pattern

MODELS: app/models

├── User 
├── wallet_transaction
├── TransferFund

VIEW: resources/views/

├── Folders
    ├── auth (Login, reset password,accountsetup blade template)
    ├── emails (email blade template)
    ├── layouts (layouts for all blade templates)
    ├── pages (profile, contact, dashboard blade template)
    ├── payment (fund wallet, verify wallet, wallet transaction history blade template)

CONTROLLERS: app/http/controllers

├── AuthController : takes care of user authentication
├── CustomForgotPasswordController : takes care of password recovery
├── DashboardController : takes care of user dashboard
├── MailController : takes care of email functions
├── PaymentController : takes care of payment withing the application
├── UserController : takes care of user

ROUTES

├── auth routes
├── payment routes
├── email routes
├── Password reset routes
├── Other pages routes

