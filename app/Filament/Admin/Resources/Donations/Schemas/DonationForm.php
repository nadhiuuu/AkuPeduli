<?php

namespace App\Filament\Admin\Resources\Donations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('campaign_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('order_id')
                    ->required(),
                TextInput::make('gross_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('donor_name')
                    ->required(),
                Toggle::make('is_anonymous')
                    ->required(),
                Textarea::make('message')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('payment_type')
                    ->default(null),
            ]);
    }
}
