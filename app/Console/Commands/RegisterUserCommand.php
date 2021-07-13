<?php

namespace App\Console\Commands;

use App\Events\UserRegisteredEvent;
use App\Models\User;
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
        DB::beginTransaction();

        $user = User::factory()->makeOne();
        $user->save();
        event(new UserRegisteredEvent($user));

        DB::commit();

        return 0;
    }
}
