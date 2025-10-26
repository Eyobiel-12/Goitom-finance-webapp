<?php

declare(strict_types=1);

namespace App\Filament\Resources\Organizations\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

final class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Organisatie Informatie')
                    ->schema([
                        TextInput::make('name')
                            ->label('Naam')
                            ->required()
                            ->maxLength(255),
                            
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                            
                        Select::make('owner_user_id')
                            ->label('Eigenaar')
                            ->relationship('owner', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                            
                        TextInput::make('vat_number')
                            ->label('BTW Nummer')
                            ->maxLength(255),
                            
                        TextInput::make('country')
                            ->label('Land')
                            ->default('NL')
                            ->maxLength(2),
                            
                        TextInput::make('currency')
                            ->label('Valuta')
                            ->default('EUR')
                            ->maxLength(3),
                            
                        TextInput::make('default_vat_rate')
                            ->label('Standaard BTW Tarief (%)')
                            ->numeric()
                            ->default(21.00)
                            ->step(0.01),
                    ])
                    ->columns(2),
                    
                Section::make('Branding')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->directory('organizations/logos'),
                            
                        ColorPicker::make('branding_color')
                            ->label('Brand Kleur')
                            ->default('#d4af37'),
                    ])
                    ->columns(2),
                    
                Section::make('Status')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'In behandeling',
                                'active' => 'Actief',
                                'suspended' => 'Opgeschort',
                            ])
                            ->default('pending')
                            ->required(),
                            
                        Textarea::make('settings')
                            ->label('Instellingen (JSON)')
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}
