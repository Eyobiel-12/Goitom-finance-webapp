<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ResetPasswordMultiStep extends Component
{
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    public function mount(string $email): void
    {
        $this->email = $email;
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function resetPassword(): void
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Gebruiker niet gevonden.');
            return;
        }

        // Update password
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        // Redirect to login
        session()->flash('status', 'Je wachtwoord is succesvol gereset. Je kunt nu inloggen.');
        $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.reset-password-multi-step');
    }
}

