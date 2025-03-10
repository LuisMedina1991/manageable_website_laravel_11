<?php

namespace Database\Seeders;

use App\Models\FooterSocialMediaLink;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSocialMediaLinkSeeder extends Seeder
{
    public function run(): void
    {
        FooterSocialMediaLink::create([
            'name' => 'Facebook',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-facebook',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Twitter',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-twitter',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Instagram',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-square-instagram',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Tiktok',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-tiktok',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Youtube',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-square-youtube',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Linkedin',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-linkedin',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Telegram',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-telegram',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Github',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-github',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Gitlab',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-square-gitlab',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Discord',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-discord',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Twitch',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-twitch',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Snapchat',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-square-snapchat',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Reddit',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-reddit',
            'is_selected' => 0,
            'position' => 100,
        ]);

        FooterSocialMediaLink::create([
            'name' => 'Patreon',
            'url' => 'https://www.google.com/',
            'icon' => 'fa-brands fa-patreon',
            'is_selected' => 0,
            'position' => 100,
        ]);
    }
}
