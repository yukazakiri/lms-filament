<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Organization;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterOrganization extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Organization';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Organization Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Organization Slug')
                    ->helperText('Used in URLs. Leave blank to auto-generate from name.')
                    ->maxLength(255)
                    ->unique(Organization::class, 'slug'),

                Textarea::make('description')
                    ->label('Description')
                    ->maxLength(1000)
                    ->rows(3),

                Select::make('type')
                    ->label('Organization Type')
                    ->options([
                        'company' => 'Company',
                        'division' => 'Division',
                        'department' => 'Department',
                        'team' => 'Team',
                        'group' => 'Group',
                    ])
                    ->default('company'),

                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Contact Email')
                    ->email()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(50),
            ]);
    }

    protected function handleRegistration(array $data): Organization
    {
        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        // Set default status
        $data['status'] = 'active';

        // Create the organization
        $organization = Organization::create($data);

        // Add the current user as a member of the organization
        $organization->users()->attach(auth()->user(), [
            'role' => 'admin',
            'is_primary' => true,
            'joined_at' => now(),
            'status' => 'active',
        ]);

        return $organization;
    }
}
