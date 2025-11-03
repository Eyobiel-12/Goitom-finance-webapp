<?php

declare(strict_types=1);

namespace App\Filament\Resources\Organizations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->circular()
                    ->size(40),
                    
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('owner.name')
                    ->label('Eigenaar')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('vat_number')
                    ->label('BTW Nummer')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('country')
                    ->label('Land')
                    ->badge()
                    ->sortable(),
                    
                TextColumn::make('currency')
                    ->label('Valuta')
                    ->badge()
                    ->sortable(),
                    
                TextColumn::make('default_vat_rate')
                    ->label('BTW Tarief')
                    ->suffix('%')
                    ->sortable(),
                    
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'suspended',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'In behandeling',
                        'active' => 'Actief',
                        'suspended' => 'Opgeschort',
                    }),
                    
                TextColumn::make('created_at')
                    ->label('Aangemaakt')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'In behandeling',
                        'active' => 'Actief',
                        'suspended' => 'Opgeschort',
                    ]),
                    
                SelectFilter::make('country')
                    ->label('Land')
                    ->options([
                        'NL' => 'Nederland',
                        'BE' => 'België',
                        'DE' => 'Duitsland',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
