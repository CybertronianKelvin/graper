<?php

declare(strict_types=1);

namespace CybertronianKelvin\Graper\Resources\GraperPageResource\Pages;

use CybertronianKelvin\Graper\Resources\GraperPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGraperPage extends EditRecord
{
    protected static string $resource = GraperPageResource::class;

    protected function getRedirectUrlIfShouldRedirectAfterSaving(): ?string
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('viewPage')
                ->label('View Page')
                ->icon('heroicon-o-eye')
                ->url(fn (Model $record) => route('graper.page.display', ['slug' => $record->slug]))
                ->openUrlInNewTab()
                ->color('gray'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function fillForm(): void
    {
        $this->fillFormWithDataAndCallHooks($this->getRecord());
    }

    protected function fillFormWithDataAndCallHooks(Model $record, array $extraData = []): void
    {
        $data = $this->mutateFormDataBeforeFill(array_merge(
            $record->attributesToArray(),
            ['content' => $record->content],
            $extraData,
        ));

        $this->form->fill($data);
    }
}
