<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class GetUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getUser {user_Id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to get user passwords and user details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_Id = $this->argument('user_Id');

        $user = UserModel::with('userPassword')->where('id',$user_Id)->first();
        //
        $this->info($user);

    }
}
