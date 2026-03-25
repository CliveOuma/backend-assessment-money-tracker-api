# Money Tracker API

A simple RESTful API built with Laravel that allows users to manage multiple wallets and track income and expenses.

## Objective

This project provides backend functionality for a Money Tracker system where users can:

Create accounts
Manage multiple wallets
Track income and expenses
View wallet balances and overall balance

## Tech Stack

- PHP (Laravel Framework)
- PostgreSQL
- RESTful API architecture

# Features

## User
- Create a user account 
- View user profile:
- All wallets
- Individual wallet balances
- Total balance across all wallets

## Wallet
- Create one or more wallets per user
- View a specific wallet:
- Wallet balance
- All transactions

## Transactions
- Add transactions to a wallet:
- Income (adds to balance)
- Expense (subtracts from balance)

## Database Structure

- User
hasMany → Wallets
- Wallet
belongsTo → User
hasMany → Transactions
- Transaction
belongsTo → Wallet

