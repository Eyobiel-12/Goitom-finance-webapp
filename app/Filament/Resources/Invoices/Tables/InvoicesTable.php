<?php

declare(strict_types=1);

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('Factuurnummer')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('client.name')
                    ->label('Klant')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('issue_date')
                    ->label('Factuurdatum')
                    ->date('d M Y')
                    ->sortable(),
                    
                TextColumn::make('due_date')
                    ->label('Vervaldatum')
                    ->date('d M Y')
                    ->sortable(),
                    
                TextColumn::make('total')
                    ->label('Totaal')
                    ->money('EUR')
                    ->sortable(),
                    
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'secondary' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Concept',
                        'sent' => 'Verzonden',
                        'paid' => 'Betaald',
                        'overdue' => 'Achterstallig',
                        'cancelled' => 'Geannuleerd',
                    }),
                    
                TextColumn::make('sent_at')
                    ->label('Verzonden op')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Concept',
                        'sent' => 'Verzonden',
                        'paid' => 'Betaald',
                        'overdue' => 'Achterstallig',
                        'cancelled' => 'Geannuleerd',
                    ]),
                    
                SelectFilter::make('client_id')
                    ->label('Klant')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload(),
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
