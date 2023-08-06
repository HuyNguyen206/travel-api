<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--wizard : Whether should show step by step}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('wizard')) {
            $user = User::factory()->create();
            $user->roles()->attach(Role::query()->where('name', 'admin')->value('id'));
            $this->info('The user '. $user->toJson() . ' was created');
            return Command::SUCCESS;
        }

        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');
        $role = $this->choice('What is your role?', ['editor', 'admin'], 1);

        $user = compact('name', 'email', 'password', 'role');
        $validator = \Illuminate\Support\Facades\Validator::make($user, [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => [Password::defaults()],
            'role' => ['required', Rule::exists(Role::class, 'name')],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return -1;
        }

        $roleId = Role::whereName($role)->value('id');

        $user['password'] = bcrypt($user['password']);
        $user = Arr::except($user, 'role');
        DB::transaction(function () use ($user, $roleId) {
            $user = User::factory()->create($user);
            $user->roles()->attach($roleId);
        });

        $this->info('The user '. json_encode($user) . ' was created');

        return Command::SUCCESS;
    }
}
