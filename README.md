# Introduction

This demo project demonstrates [the outbox pattern](https://walkerjordan.com/the-outbox-pattern/) with Laravel using queued event listeners when using the database queue driver. Read the full write up at [https://walkerjordan.com/implementing-the-outbox-pattern-with-laravel/](https://walkerjordan.com/implementing-the-outbox-pattern-with-laravel/).

Since the database queue driver effectively stores events in the database before dispatching them to the appropriate listeners in a background process, they can be wrapped in a transaction along with any other database operations you might perform, such as inserting a new user upon registration. Therefore, if an exception is thrown after inserting the user, but before the event is dispatched, both the user and the event are effectively rolled back.

Without wrapping these operations in a transaction, if an exception is thrown after inserting the user, the event would be never be dispatched and the user wouldn't receive a confirmation email, for example.

## Instructions

1. Clone this project.
2. Copy `.env.example` to `.env` and configure the environment variables as necessary. Make sure that `QUEUE_CONNECTION=database`.
3. Run `php artisan migrate` to migrate the database.
4. Run `php artisan queue:work` to start the queue worker in a background process.
5. Either run `php artisan user:register` or send a `POST` request to `/api/users` to register a new user.

When a new user is registered, a `UserRegisteredEvent` event will be dispatched to `SendUserRegisteredConfirmationEmailListener`, which in turn simulates sending an email to the user (it actually just writes to the log). If an exception is thrown in sending the email, ordinarily the user would be inserted into the database but they would not receive the confirmation email.

However, by queueing the work performed by `SendUserRegisteredConfirmationEmailListener`, the event is never lost but is instead saved to the database and dispatched in a background process, such that if it fails, it can be retried later, either manually or through some automated process. Either way, there is the potential to recover from failed background work.

If the database transaction fails to commit, neither the user nor a confirmation email will be sent. To check this, throw an exception in the `SendUserRegisteredConfirmationEmailListener::handle` method, and verify that neither the user is inserted nor the `UserRegisteredEvent` event.
