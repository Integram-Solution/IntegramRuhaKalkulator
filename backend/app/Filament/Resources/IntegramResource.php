<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntegramResource\Pages;
use App\Filament\Resources\IntegramResource\RelationManagers;
use App\Models\Integram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IntegramResource extends Resource
{
    protected static ?string $model = Integram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Megrendelések';

    protected static ?string $title = 'Megrendelés';

    protected static ?string $modelLabel = 'Megrendelés';

    protected static ?string $pluralLabel = 'Megrendelések';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cegnev')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cim')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('adoszam')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nev')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tel')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('pdf')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cegnev')
                    ->searchable()
                    ->label('Cégnév'),
                Tables\Columns\TextColumn::make('cim')
                    ->searchable()
                    ->label('Cím'),
                Tables\Columns\TextColumn::make('adoszam')
                    ->searchable()
                    ->label('Adószám'),
                Tables\Columns\TextColumn::make('nev')
                    ->searchable()
                    ->label('Név'),
                Tables\Columns\TextColumn::make('tel')
                    ->searchable()
                    ->label('Telefonszám'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('E-mail'),
                Tables\Columns\TextColumn::make('pdf')
                    ->label('PDF')
                    ->formatStateUsing(fn ($record) => view('components.download-button', ['pdfData' => $record->pdf])),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListIntegrams::route('/'),
            'create' => Pages\CreateIntegram::route('/create'),
            'edit' => Pages\EditIntegram::route('/{record}/edit'),
        ];
    }
}
