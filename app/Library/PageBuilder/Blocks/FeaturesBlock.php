<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class FeaturesBlock extends BlockBase
{
    public string $id = 'features';
    public string $name = 'Features';
    public string $category = 'Sections';
    public string $icon = 'fa-star';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'columns', 'type' => 'select', 'label' => 'Columns', 'std' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4']],
            ['id' => 'items', 'type' => 'listItem', 'label' => 'Features', 'settings' => [
                ['id' => 'icon', 'type' => 'icon', 'label' => 'Icon', 'std' => 'fa-bolt'],
                ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => ''],
                ['id' => 'text', 'type' => 'textarea', 'label' => 'Description', 'std' => ''],
                ['id' => 'link', 'type' => 'url', 'label' => 'Link (optional)', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Why Work With Us',
            'subtitle' => 'Everything you need to succeed',
            'columns' => '3',
            'items' => [
                ['icon' => 'fa-bolt', 'title' => 'Fast Delivery', 'text' => 'Quick turnaround without compromising quality.', 'link' => ''],
                ['icon' => 'fa-shield-halved', 'title' => 'Secure', 'text' => 'Your data is protected at every step.', 'link' => ''],
                ['icon' => 'fa-headset', 'title' => 'Support', 'text' => 'Dedicated help whenever you need it.', 'link' => ''],
            ],
        ];
    }
}
