<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class GalleryBlock extends BlockBase
{
    public string $id = 'gallery';
    public string $name = 'Image Gallery';
    public string $category = 'Media';
    public string $icon = 'fa-photo-film';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'columns', 'type' => 'select', 'label' => 'Columns', 'std' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4']],
            ['id' => 'images', 'type' => 'listItem', 'label' => 'Images', 'settings' => [
                ['id' => 'image', 'type' => 'image', 'label' => 'Image', 'std' => ''],
                ['id' => 'caption', 'type' => 'text', 'label' => 'Caption', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Gallery',
            'columns' => '3',
            'images' => [
                ['image' => '', 'caption' => ''],
                ['image' => '', 'caption' => ''],
                ['image' => '', 'caption' => ''],
            ],
        ];
    }
}
