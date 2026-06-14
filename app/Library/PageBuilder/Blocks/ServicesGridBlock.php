<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class ServicesGridBlock extends BlockBase
{
    public string $id = 'services_grid';
    public string $name = 'Services Grid';
    public string $category = 'Sections';
    public string $icon = 'fa-table-cells-large';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'columns', 'type' => 'select', 'label' => 'Columns', 'std' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4']],
            ['id' => 'items', 'type' => 'listItem', 'label' => 'Services', 'settings' => [
                ['id' => 'image', 'type' => 'image', 'label' => 'Image', 'std' => ''],
                ['id' => 'icon', 'type' => 'icon', 'label' => 'Icon (if no image)', 'std' => 'fa-gear'],
                ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => ''],
                ['id' => 'text', 'type' => 'textarea', 'label' => 'Description', 'std' => ''],
                ['id' => 'url', 'type' => 'url', 'label' => 'URL', 'std' => '#'],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Our Services',
            'subtitle' => 'What we can do for you',
            'columns' => '3',
            'items' => [
                ['image' => '', 'icon' => 'fa-laptop-code', 'title' => 'Web Development', 'text' => 'Modern, fast and responsive websites.', 'url' => '#'],
                ['image' => '', 'icon' => 'fa-shield-halved', 'title' => 'Security', 'text' => 'Protect your business and data.', 'url' => '#'],
                ['image' => '', 'icon' => 'fa-chart-line', 'title' => 'Consulting', 'text' => 'Strategy that drives real growth.', 'url' => '#'],
            ],
        ];
    }
}
