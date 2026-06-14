<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class CtaBannerBlock extends BlockBase
{
    public string $id = 'cta_banner';
    public string $name = 'Call To Action';
    public string $category = 'Marketing';
    public string $icon = 'fa-bullhorn';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => ''],
            ['id' => 'text', 'type' => 'textarea', 'label' => 'Text', 'std' => ''],
            ['id' => 'button_text', 'type' => 'text', 'label' => 'Button Text', 'std' => ''],
            ['id' => 'button_url', 'type' => 'url', 'label' => 'Button URL', 'std' => '#'],
            ['id' => 'style', 'type' => 'select', 'label' => 'Style', 'std' => 'gradient',
                'options' => ['gradient' => 'Gradient', 'dark' => 'Dark', 'light' => 'Light']],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Ready to Get Started?',
            'text' => 'Contact us today and let’s build something great together.',
            'button_text' => 'Get A Quote',
            'button_url' => '/contact',
            'style' => 'gradient',
        ];
    }
}
