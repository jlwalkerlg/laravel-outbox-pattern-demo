# Introduction

This demo project demonstrates [the outbox pattern](https://walkerjordan.com/the-outbox-pattern/) with Laravel using queued event listeners when using the database queue driver.

Since the database queue driver effectively stores events in the database before dispatching them to the appropriate listeners in a background process, they can be wrapped in a transaction along with any other database operations you might perform, such as inserting a new user upon registration. Therefore, if an exception is thrown after inserting the user, but before the event is dispatched, both the user and the event are effectively rolled back.

Without wrapping these operations in a transaction, if an exception is thrown after inserting the user, the event would be never be dispatched and the user wouldn't receive a confirmation email, for example.

## Setting up

1. Clone this project.
2. Copy `.env.example` to `.env` and configure the environment variables as necessary. Make sure that `QUEUE_CONNECTION=database`.
3. Run `php artisan migrate` to migrate the database.
4. Run `php artisan queue:work` to start the queue worker in a background process.
5. Run `php artisan user:register` to register a new user.

The `php artisan user:register` command will run the `RegisterUserCommand::handle` method, which inserts a new user into the database before raising a `UserRegisteredEvent` event. This event is handled by the `SendUserRegisteredConfirmationListener` event listener, which simply logs the user's name.

`RegisterUserCommand::handle` is setup with a 50% chance of throwing an exception between inserting the user and raising the event. When the exception is thrown, no user should be inserted into the database, and no event should be dispatched. Otherwise, the user will be inserted and the event subsequently dispatched to the `SendUserRegisteredConfirmationListener` event listener.
