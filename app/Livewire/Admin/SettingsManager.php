<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Models\SiteContent;
use Livewire\Component;

class SettingsManager extends Component
{
    public string $brand_name = '';
    public string $whatsapp_number = '';
    public string $contact_email = '';
    public string $shop_address_1 = '';
    public string $hero_title = '';
    public string $hero_subtitle = '';
    public string $history_title = '';
    public string $history_body = '';
    public bool $saved = false;

    public function mount(): void
    {
        $this->brand_name = Setting::getValue('brand_name', 'Sunu Atelier');
        $this->whatsapp_number = Setting::getValue('whatsapp_number', '+221 77 000 00 00');
        $this->contact_email = Setting::getValue('contact_email', 'contact@sunuatelier.sn');
        $this->shop_address_1 = Setting::getValue('shop_address_1', 'Dakar Plateau');

        $hero = SiteContent::where('section_key', 'hero')->first();
        $this->hero_title = $hero?->title ?? '';
        $this->hero_subtitle = $hero?->subtitle ?? '';

        $history = SiteContent::where('section_key', 'notre_histoire')->first();
        $this->history_title = $history?->title ?? '';
        $this->history_body = $history?->body ?? '';
    }

    public function save(): void
    {
        foreach ([
            'brand_name' => $this->brand_name,
            'whatsapp_number' => $this->whatsapp_number,
            'contact_email' => $this->contact_email,
            'shop_address_1' => $this->shop_address_1,
        ] as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        SiteContent::updateOrCreate(
            ['section_key' => 'hero'],
            ['title' => $this->hero_title, 'subtitle' => $this->hero_subtitle]
        );

        SiteContent::updateOrCreate(
            ['section_key' => 'notre_histoire'],
            ['title' => $this->history_title, 'body' => $this->history_body]
        );

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
