<?php

declare(strict_types=1);

namespace CybertronianKelvin\Graper\Resources;

use CybertronianKelvin\Graper\Forms\Components\GrapesJsField;
use CybertronianKelvin\Graper\Models\GraperPage;
use CybertronianKelvin\Graper\Resources\GraperPageResource\Pages\CreateGraperPage;
use CybertronianKelvin\Graper\Resources\GraperPageResource\Pages\EditGraperPage;
use CybertronianKelvin\Graper\Resources\GraperPageResource\Pages\ListGraperPages;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GraperPageResource extends Resource
{
    protected static ?string $model = GraperPage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $slug = 'graper-pages';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required(),
            TextInput::make('slug')
                ->unique(ignoreRecord: true)
                ->required(),
            Select::make('is_published')
                ->label('Published')
                ->options([true => 'Yes', false => 'No'])
                ->default(false)
                ->required(),
            DateTimePicker::make('published_at'),
            GrapesJsField::make('content')
                ->loadDefaultBlocks()
                ->minHeight('70vh')
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title'),
                TextColumn::make('slug'),
                IconColumn::make('is_published'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGraperPages::route('/'),
            'create' => CreateGraperPage::route('/create'),
            'edit' => EditGraperPage::route('/{record}/edit'),
        ];
    }
}
