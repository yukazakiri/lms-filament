<?php

namespace App\Filament\Resources\UserProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('employee_id'),
                TextInput::make('job_title'),
                TextInput::make('department'),
                TextInput::make('manager_id')
                    ->numeric(),
                DatePicker::make('hire_date'),
                TextInput::make('location'),
                TextInput::make('address_line_1'),
                TextInput::make('address_line_2'),
                TextInput::make('city'),
                TextInput::make('state_province'),
                TextInput::make('postal_code'),
                TextInput::make('country'),
                TextInput::make('emergency_contact_name'),
                TextInput::make('emergency_contact_phone')
                    ->tel(),
                TextInput::make('emergency_contact_relationship'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                Textarea::make('skills')
                    ->columnSpanFull(),
                Textarea::make('interests')
                    ->columnSpanFull(),
                Textarea::make('social_links')
                    ->columnSpanFull(),
                Textarea::make('custom_fields')
                    ->columnSpanFull(),
            ]);
    }
}
