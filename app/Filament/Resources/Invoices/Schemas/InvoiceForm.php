<?php

declare(strict_types=1);

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Client;
use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

final class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Factuur Informatie')
                    ->schema([
                        TextInput::make('number')
                            ->label('Factuurnummer')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                            
                        Select::make('client_id')
                            ->label('Klant')
                            ->relationship('client', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                            
                        Select::make('project_id')
                            ->label('Project')
                            ->relationship('project', 'name')
                            ->searchable()
                            ->preload(),
                            
                        DatePicker::make('issue_date')
                            ->label('Factuurdatum')
                            ->required()
                            ->default(now()),
                            
                        DatePicker::make('due_date')
                            ->label('Vervaldatum')
                            ->default(now()->addDays(30)),
                            
                        TextInput::make('currency')
                            ->label('Valuta')
                            ->default('EUR')
                            ->maxLength(3),
                    ])
                    ->columns(2),
                    
                Section::make('Bedragen')
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Subtotaal')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('€'),
                            
                        TextInput::make('vat_total')
                            ->label('BTW Totaal')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('€'),
                            
                        TextInput::make('total')
                            ->label('Totaal')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('€'),
                    ])
                    ->columns(3),
                    
                Section::make('Status & Opmerkingen')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Concept',
                                'sent' => 'Verzonden',
                                'paid' => 'Betaald',
                                'overdue' => 'Achterstallig',
                                'cancelled' => 'Geannuleerd',
                            ])
                            ->default('draft')
                            ->required(),
                            
                        Textarea::make('notes')
                            ->label('Opmerkingen')
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}
