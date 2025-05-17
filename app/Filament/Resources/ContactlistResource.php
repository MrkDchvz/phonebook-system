<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactlistResource\Pages;
use App\Filament\Resources\ContactlistResource\RelationManagers;
use App\Models\Contact;
use App\Models\Contactlist;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactlistResource extends Resource
{
    protected static ?string $model = Contactlist::class;


    protected static ?string $navigationIcon = 'heroicon-o-phone';


    public static function getPluralModelLabel(): string {
        return auth()->user()->hasRole('Admin') ? 'User Added Contacts' : 'My Contacts';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('contact_id')
                ->relationship('contact', 'name')
                ->required()
                ->disabledOn('edit')
                ->reactive()
                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\get $get) {
                    if ($state) {
                        $contact= Contact::find($get('contact_id'));
                        $set('number', $contact->number);

                    }
                }),
                Forms\Components\TextInput::make('number')
                ->disabled(),
                Forms\Components\TextInput::make('nickname')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->hidden(fn () => !auth()->user()->hasRole(['Admin'])),
                Tables\Columns\TextColumn::make('contact.name')
                    ->label('Contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact.number')
                    ->label('Number')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nickname')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit Contact'),
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

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('User')) {
            $userId = auth()->id();
            return parent::getEloquentQuery()->where('user_id', $userId);
        }
        else {
            return parent::getEloquentQuery();
        }

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactlists::route('/'),
            'create' => Pages\CreateContactlist::route('/create'),
            'edit' => Pages\EditContactlist::route('/{record}/edit'),
        ];
    }
}
