<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class HeroBlock extends BlockBase
{
    public string $id = 'hero';
    public string $name = 'Hero Section';
    public string $category = 'Headers';
    public string $icon = 'fa-bolt';

    public function settings(): array
    {
        return [
            ['id' => 'badge', 'type' => 'text', 'label' => 'Badge Text', 'std' => ''],
            ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => ''],
            ['id' => 'highlight', 'type' => 'text', 'label' => 'Title Highlight', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'textarea', 'label' => 'Subtitle', 'std' => ''],
            ['id' => 'primary_text', 'type' => 'text', 'label' => 'Primary Button', 'std' => ''],
            ['id' => 'primary_url', 'type' => 'url', 'label' => 'Primary URL', 'std' => '#'],
            ['id' => 'secondary_text', 'type' => 'text', 'label' => 'Secondary Button', 'std' => ''],
            ['id' => 'secondary_url', 'type' => 'url', 'label' => 'Secondary URL', 'std' => '#'],
            ['id' => 'image', 'type' => 'image', 'label' => 'Side Image', 'std' => ''],
            ['id' => 'trust_items', 'type' => 'listItem', 'label' => 'Trust Badges', 'settings' => [
                ['id' => 'icon', 'type' => 'icon', 'label' => 'Icon', 'std' => 'fa-check'],
                ['id' => 'text', 'type' => 'text', 'label' => 'Text', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'badge' => 'Trusted by industry leaders',
            'title' => 'Smart Solutions for',
            'highlight' => 'Your Business',
            'subtitle' => 'We deliver reliable, modern solutions that help your business grow with confidence.',
            'primary_text' => 'Get Started',
            'primary_url' => '/contact',
            'secondary_text' => 'Learn More',
            'secondary_url' => '/about',
            'image' => '',
            'trust_items' => [
                ['icon' => 'fa-shield-halved', 'text' => 'Secure & Reliable'],
                ['icon' => 'fa-headset', 'text' => '24/7 Support'],
                ['icon' => 'fa-award', 'text' => 'Award Winning'],
            ],
        ];
    }
}
