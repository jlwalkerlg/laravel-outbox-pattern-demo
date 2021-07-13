<?php

namespace App\Console\Commands;

use App\Events\UserRegisteredEvent;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RegisterUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a new user.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::factory()->makeOne();

        DB::beginTransaction();

        $user->save();

        // mimic random database connection failure
        if (rand(0, 1)) throw new Exception("Failed to connect to database.");

        event(new UserRegisteredEvent($user));

        DB::commit();

        return 0;
    }
}
