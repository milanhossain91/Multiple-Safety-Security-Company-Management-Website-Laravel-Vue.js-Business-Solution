<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class TextBlock extends BlockBase
{
    public string $id = 'text';
    public string $name = 'Text / Rich Content';
    public string $category = 'Content';
    public string $icon = 'fa-align-left';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'content', 'type' => 'richtext', 'label' => 'Content', 'std' => ''],
            ['id' => 'align', 'type' => 'select', 'label' => 'Text Align', 'std' => 'left',
                'options' => ['left' => 'Left', 'center' => 'Center']],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'About This Section',
            'subtitle' => '',
            'content' => '<p>Write your content here. You can use <strong>bold</strong>, lists and links.</p>',
            'align' => 'left',
        ];
    }
}
