<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

abstract class SettingPage extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    abstract protected function settingKey(): string;

    abstract protected function settingGroup(): string;

    abstract protected function formSchema(): array;

    public function mount(): void
    {
        $this->form->fill($this->loadPayload());
    }

    protected function loadPayload(): array
    {
        return SiteSetting::where('key', $this->settingKey())->value('payload') ?? [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->formSchema())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::updateOrCreate(
            ['key' => $this->settingKey()],
            ['group' => $this->settingGroup(), 'payload' => $data]
        );

        Notification::make()
            ->title('Konten tersimpan')
            ->success()
            ->send();
    }

    protected static function makeImageField(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->disk('public')
            ->directory('settings')
            ->image()
            ->imageEditor();
    }
}
