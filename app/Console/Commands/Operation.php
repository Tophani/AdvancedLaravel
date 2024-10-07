<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Operation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'perform crud on db';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info("Select the command
- Select
- Update
- Delete
- Add");

        $operation = $this->choice(
            'Which operation would you like to perform?',
            ['Select', 'Update', 'Delete', 'Add'],
            0
        );

        if($operation=='Select'){
            $this->selectOperation();
        }else if($operation=='Update'){
            $this->updateOperation();
        }else if($operation=='Delete'){
            $this->deleteOperation();
        }else if($operation=='Add'){
            $this->addOperation();
        }
    }

    private function selectOperation()
    {
        $user_Id = $this->ask('Enter the user ID to view users');
        $user = UserModel::with('userPassword')->where('id',$user_Id)->first();

        if (!$user)return $this->error(string:'User not found.');

            $this->info("Displaying all users:");
            $this->info("UserId: $user->id");
            $this->info("Name: $user->name");
            $this->info("Address:$user->address");
            $this->info("Phone No: $user->phone");
            $this->info("Password: $user->password");


            // if ($user->userPassword &&count($user->userPassword)>0)  {
            //     $this->info("\nPasswords:");
            //     foreach ($user->userPassword as $password) {
            //         $this->info("platform:: {$password->platform} \nPassword::$password->password");
            //     }
            // } else {
            //     // $this->info(string:"Not available");
            // }
    }

    private function updateOperation()
    {
        // Example update operation logic
        $user_Id = $this->ask('Enter the user ID to update');
        $user = UserModel::where('id',$user_Id)->first();

        if ($user) {
            $newName = $this->ask('Enter the new name');
            $user->name = $newName;

            $newAddress = $this->ask('Enter the new Address');
            $user->address = $newAddress?$newAddress:$user->address;

            $user->save();
            $this->info('User updated successfully.');
        } else {
            $this->error('User not found.');
        }
    }

    private function deleteOperation()
    {
        $user_Id = $this->ask('Enter the user ID to delete');
        $user = UserModel::find('id',$user_Id);

        if ($user) {

            $user->userPassword()->delete();

            $user->delete();
            $this->info(string:'User deleted successfully.');
        } else {
            $this->error(string:'User not found.');
        }
    }

    private function addOperation()
    {
        // Example add operation logic
        $user = $this->ask('Enter the user name');
        $address = $this->ask('Enter the user address');
        $phone = $this->ask('Enter the user phone Number');
        $password = Hash::make($this->ask('Enter the user password'));


        if (empty($user) || empty($address) || empty($phone)) {
            $this->error('Please provide valid inputs for name, address, and phone.');
            return;
        }

        UserModel::create([
            'name' => $user,
            'address' => $address,
            'phone' => $phone,
            'password' => $password,

        ]);

        $this->info('User saved successfully.');

    }
}
