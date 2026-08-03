<?php

namespace App\Console\Commands\User;

use App\Console\Commands\Traits\HasValidator;
use App\Enums\User\Role;
use App\Models\User as NewUser;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class UserCreateCommand extends Command
{
    use HasValidator;

    protected $signature = 'user:create';

    protected $description = 'Create a new user.';

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $data['name'] = text(
            label: 'Name:',
            required: true,
            validate: fn ($value) => $this->validate($value, 'name', ['required', 'string', 'max:255'])
        );

        $data['username'] = text(
            label: 'Username:',
            required: true,
            validate: fn ($value) => $this->validate($value, 'username', ['required', 'string', 'max:255'])
        );

        $data['email'] = text(
            label: 'Email:',
            validate: fn ($value) => $this->validate($value, 'email', ['nullable', 'email', 'max:255'])
        );

        $roles = collect(Role::cases())
            ->mapWithKeys(fn (Role $role) => [$role->value => $role->label()])
            ->all();

        $data['role'] = select(
            label: 'Select user role',
            options: $roles,
        );

        $passwordRules = Password::min(8);
        $hint = "Minimum of 8 characters.\n";

        if (app()->environment() === 'production') {
            $passwordRules = $passwordRules
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised();

            $hint .= "Must contain at least one letter.\n";
            $hint .= "Must contain at least one number.\n";
            $hint .= "Must not have been compromised in data leaks.\n";
        }

        $rawPassword = password(
            label: 'Password:',
            validate: fn ($value) => $this->validate($value, 'password', [$passwordRules]),
            hint: $hint,
        );

        if (trim($rawPassword) === '') {
            $rawPassword = Str::password(8);
        }

        $data['password'] = Hash::make($rawPassword);

        $verifyEmail = confirm('Auto verify email?', default: false);
        if ($verifyEmail) {
            $data['email_verified_at'] = now();
        }

        info('Please review the following data:');
        info("Name: {$data['name']}");
        info("Username: {$data['username']}");
        info("Email: {$data['email']}");
        info('Role: '.data_get($roles, $data['role']));
        info("Password: $rawPassword");
        $verifyEmailStr = $verifyEmail ? 'YES' : 'NO';
        info("Auto verify email? $verifyEmailStr");

        $confirmed = confirm(
            label: 'Do you wish to continue with the above data?',
            default: false,
            yes: 'Continue',
            no: 'Cancel',
        );

        if (! $confirmed) {
            info('User creation cancelled.');

            return self::SUCCESS;
        }

        try {
            $user = new NewUser();
            $user->fill($data);

            $this->userRepository->save($user);

            info("User [{$user->id}] successfully created!");
        } catch (Exception $e) {
            report($e);
            error('Unable to create user. Error: '.$e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
