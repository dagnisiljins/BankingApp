<div style="text-align: center;">
    <img src="public/images/logo.png" alt="Logo" width="200" height="200"/>
</div>


# Laravel Payment and Investment Web Application

## Project Description

This Laravel-based web application offers a comprehensive platform for managing personal finances, including currency-based accounts, money transfers, and cryptocurrency investments. It's designed to provide a seamless user experience for financial management and investment opportunities.

## Features

- **User Registration & Authorization**: Secure sign-up and login process for users.
- **Multi-Currency Accounts**: Users can create accounts in various currencies including EUR, USD, and GBP.
- **Money Transfers**: Facilitates transfers between accounts with a feature to view transfer history.
- **Currency Conversion**: Implements currency conversion for cross-currency transfers using Coinbase API for real-time exchange rates.
- **Investment Account Management**: Allows users to create an investment account for handling cryptocurrency transactions.
- **Cryptocurrency Investments**: Provides the ability to buy and manage cryptocurrencies, leveraging Coinbase API for current rates.
- **Investment Tracking**: Displays details of cryptocurrency investments including purchase price, current value, and performance (percentage increase or decrease).
- **Selling Investments**: Option to sell investments with automatic crediting of the sale amount to the user's investment account. Investment history is also available for review.

## Feature Overview
[Full Application Demonstration video](https://www.loom.com/share/a0522921aa714ef4a08f4c0ef92a36b5?sid=c47438ab-951a-4937-a61c-c4bbf99fe935)

## Installation and Setup

To get this project up and running on your local machine, follow these steps:

### Prerequisites

Ensure you have the following installed:
- PHP (version 7.4 or higher)
- Composer
- MySQL or a database of your choice
- npm

### Step-by-Step Guide

1. **Clone the Repository**: 
- **git clone ...**
2. **Install Dependencies**: 
- **composer install**
- **npm install**
- **npm run dev**
3. **Set Up Environment**
- **cp .env.example .env**
- **php artisan key:generate**
4. **Database Setup**
- **php artisan migrate**
5. **Run the Application**
- **php artisan serve**
