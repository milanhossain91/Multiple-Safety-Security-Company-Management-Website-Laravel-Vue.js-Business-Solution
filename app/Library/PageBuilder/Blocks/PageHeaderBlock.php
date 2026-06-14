<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class PageHeaderBlock extends BlockBase
{
    public string $id = 'page_header';
    public string $name = 'Page Header';
    public string $category = 'Headers';
    public string $icon = 'fa-heading';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => 'Page Title'],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle', 'std' => ''],
            ['id' => 'image', 'type' => 'image', 'label' => 'Background Image', 'std' => ''],
            ['id' => 'align', 'type' => 'select', 'label' => 'Align', 'std' => 'center',
                'options' => ['center' => 'Center', 'left' => 'Left']],
        ];
    }

    public function model(): array
    {
        return ['title' => 'Page Title', 'subtitle' => 'A short supporting line', 'image' => '', 'align' => 'center'];
    }
}
