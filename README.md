# Free Ads

## Introduction

Free Ads is a web application designed for creating and managing classified advertisements. The goal of the project is to create a user-friendly, efficient, and secure platform using Laravel framework. 

## Features

- Authentication and registration module with email verification, using Breeze Laravel package.
- Reset password by receiving an e-mail.
- CRUD profile controller.
- Post new ads using /newadd page.
- Image uploads for ads are stored in /public/storage/images.
- Images associated with an ad are properly deleted from storage when the ad is modified or deleted.
- View own ads from /myadds page.
- Edit and/or delete own ads from /myadds page using the EDIT and DELETE buttons.
- View the list of all ads from /adds page.
- Simple sorting of ads by name.
- Clicking the "More filters" button displays additional filters for sorting ads with price ranges and keywords.
- Reorder the ads without refreshing the page, with options to sort by recent or popular.
- Contact button to initiate contact with the advertiser from the ad's page.
- Display of unread message count on the navigation bar next to "Messages".
- List of all conversations on /messages page, along with the date of the last message.
- Clicking on a conversation takes the user to /conversation page to view the conversation with the option to send a message.

## Project Management

Project management was organized using Trello. Click [here](https://trello.com/b/ejy4XU3X/laravel) to access the board.

## Getting Started

1. Clone the repository.
2. Run `composer install` to install the dependencies.
3. Rename `.env.example` to `.env` and add database credentials.
4. Run `php artisan migrate` to migrate the database.
5. Run `php artisan serve` to start the server.
6. Access the application at [http://localhost:3000/](http://localhost:3000/)

## Conclusion

Free Ads is a powerful and user-friendly platform for creating and managing classified advertisements. Its intuitive design and feature-rich environment make it an excellent tool for anyone looking to create a seamless experience for buyers and sellers alike.

JS validated by JSLint
PHP files validated by PHP Checker
HTML/CSS W3C validated