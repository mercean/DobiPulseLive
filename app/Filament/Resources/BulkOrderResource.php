<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BulkOrderResource\Pages;
use App\Filament\Resources\BulkOrderResource\RelationManagers;
use App\Models\BulkOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BulkOrderResource extends Resource
{
    protected static ?string $model = BulkOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cloth_type')
                    ->required(),
                Forms\Components\TextInput::make('load_kg')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('load_arrival_date')
                    ->required(),
                Forms\Components\TextInput::make('load_arrival_time')
                    ->required(),
                Forms\Components\DatePicker::make('pickup_date')
                    ->required(),
                Forms\Components\TextInput::make('pickup_time')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cloth_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('load_kg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('load_arrival_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('load_arrival_time'),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickup_time'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

public static function getPages(): array
{
    return [
        'index' => Pages\ListBulkOrders::route('/'),
        'create' => Pages\CreateBulkOrder::route('/create'),
        'view' => Pages\ViewBulkOrder::route('/{record}'),
        'edit' => Pages\EditBulkOrder::route('/{record}/edit'),
    ];
}


}

