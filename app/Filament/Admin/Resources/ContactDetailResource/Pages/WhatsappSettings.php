<?php

namespace App\Filament\Admin\Resources\ContactDetailResource\Pages;

use App\Filament\Admin\Resources\ContactDetailResource;
use App\Models\ContactDetail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class WhatsappSettings extends Page
{
    protected static string $resource = ContactDetailResource::class;

    protected static string $view = 'filament.admin.resources.contact-detail-resource.pages.whatsapp-settings';

    protected static ?string $title = 'WhatsApp Button Settings';

    public bool   $whatsapp_enabled  = false;
    public string $whatsapp_number   = '';
    public string $whatsapp_message  = '';
    public string $whatsapp_position = 'bottom-right';

    public function mount(): void
    {
        $this->whatsapp_enabled  = $this->load('whatsapp_enabled', 'false') === 'true';
        $this->whatsapp_number   = $this->load('whatsapp_number', '');
        $this->whatsapp_message  = $this->load('whatsapp_message', "Hello! I'd like to inquire about your services.");
        $this->whatsapp_position = $this->load('whatsapp_position', 'bottom-right');
    }

    public function save(): void
    {
        $this->validate([
            'whatsapp_number'   => 'required|string|max:20',
            'whatsapp_message'  => 'required|string|max:500',
            'whatsapp_position' => 'required|in:bottom-right,bottom-left',
        ]);

        $settings = [
            'whatsapp_enabled'  => $this->whatsapp_enabled ? 'true' : 'false',
            'whatsapp_number'   => preg_replace('/[^0-9]/', '', $this->whatsapp_number),
            'whatsapp_message'  => $this->whatsapp_message,
            'whatsapp_position' => $this->whatsapp_position,
        ];

        foreach ($settings as $key => $value) {
            ContactDetail::updateOrCreate(
                ['key' => $key],
                ['label' => ucwords(str_replace('_', ' ', $key)), 'value' => $value, 'type' => 'text', 'icon' => 'heroicon-o-chat-bubble-left', 'is_active' => false, 'order' => 999]
            );
        }

        Notification::make()->title('WhatsApp settings saved.')->success()->send();
    }

    private function load(string $key, string $default = ''): string
    {
        return ContactDetail::where('key', $key)->value('value') ?? $default;
    }
}
