<?php

namespace App\Filament\Admin\Resources\ContactDetailResource\Pages;

use App\Filament\Admin\Resources\ContactDetailResource;
use App\Models\ContactDetail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class SocialMediaSettings extends Page
{
    protected static string $resource = ContactDetailResource::class;

    protected static string $view = 'filament.admin.resources.contact-detail-resource.pages.social-media-settings';

    protected static ?string $title = 'Social Media Links';

    public string $social_facebook  = '';
    public string $social_twitter   = '';
    public string $social_instagram = '';
    public string $social_linkedin  = '';
    public string $social_youtube   = '';

    public function mount(): void
    {
        $this->social_facebook  = $this->load('social_facebook');
        $this->social_twitter   = $this->load('social_twitter');
        $this->social_instagram = $this->load('social_instagram');
        $this->social_linkedin  = $this->load('social_linkedin');
        $this->social_youtube   = $this->load('social_youtube');
    }

    public function save(): void
    {
        $this->validate([
            'social_facebook'  => 'nullable|url|max:500',
            'social_twitter'   => 'nullable|url|max:500',
            'social_instagram' => 'nullable|url|max:500',
            'social_linkedin'  => 'nullable|url|max:500',
            'social_youtube'   => 'nullable|url|max:500',
        ]);

        $links = [
            'social_facebook'  => $this->social_facebook,
            'social_twitter'   => $this->social_twitter,
            'social_instagram' => $this->social_instagram,
            'social_linkedin'  => $this->social_linkedin,
            'social_youtube'   => $this->social_youtube,
        ];

        foreach ($links as $key => $value) {
            ContactDetail::updateOrCreate(
                ['key' => $key],
                [
                    'label'     => ucwords(str_replace('_', ' ', $key)),
                    'value'     => $value ?? '',
                    'type'      => 'url',
                    'icon'      => 'heroicon-o-link',
                    'is_active' => false,
                    'order'     => 998,
                ]
            );
        }

        Notification::make()->title('Social media links saved.')->success()->send();
    }

    private function load(string $key): string
    {
        return ContactDetail::where('key', $key)->value('value') ?? '';
    }
}
