<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class PartnersBlock extends BlockBase
{
    public string $id = 'partners';
    public string $name = 'Partners / Logos';
    public string $category = 'Media';
    public string $icon = 'fa-handshake';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'logos', 'type' => 'listItem', 'label' => 'Logos', 'settings' => [
                ['id' => 'image', 'type' => 'image', 'label' => 'Logo', 'std' => ''],
                ['id' => 'name', 'type' => 'text', 'label' => 'Name', 'std' => ''],
                ['id' => 'url', 'type' => 'url', 'label' => 'URL', 'std' => '#'],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Trusted By',
            'logos' => [
                ['image' => '', 'name' => 'Partner 1', 'url' => '#'],
                ['image' => '', 'name' => 'Partner 2', 'url' => '#'],
                ['image' => '', 'name' => 'Partner 3', 'url' => '#'],
                ['image' => '', 'name' => 'Partner 4', 'url' => '#'],
            ],
        ];
    }
}
