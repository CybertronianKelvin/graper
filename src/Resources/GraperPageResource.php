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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GraperPageResource extends Resource
{
    protected static ?string $model = GraperPage::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-document-text';

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
            Toggle::make('is_published')
                ->label('Published')
                ->default(false),
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
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
