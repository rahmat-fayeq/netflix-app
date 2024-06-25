<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MoviesRelationManager extends RelationManager
{
    protected static string $relationship = 'movies';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Details')->columns(4)->schema([
                    TextInput::make('title')
                        ->live()
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('slug')->columnSpan(2),
                    TextInput::make('overview')->columnSpan(2),
                    DatePicker::make('release_date')->columnSpan(2)
                ]),
                Forms\Components\Section::make('Urls')->columns(4)->schema([
                    TextInput::make('poster_path')->url(),
                    TextInput::make('backdrop_path')->url(),
                    TextInput::make('video_url')->url(),
                    TextInput::make('trailer_url')->url(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
