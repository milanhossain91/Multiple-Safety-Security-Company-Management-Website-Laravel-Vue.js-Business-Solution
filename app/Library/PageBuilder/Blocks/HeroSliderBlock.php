<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class HeroSliderBlock extends BlockBase
{
    public string $id = 'hero_slider';
    public string $name = 'Hero Slider';
    public string $category = 'Headers';
    public string $icon = 'fa-images';

    public function settings(): array
    {
        return [
            ['id' => 'slides', 'type' => 'listItem', 'label' => 'Slides', 'settings' => [
                ['id' => 'image', 'type' => 'image', 'label' => 'Image', 'std' => ''],
                ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => ''],
                ['id' => 'subtitle', 'type' => 'textarea', 'label' => 'Subtitle', 'std' => ''],
                ['id' => 'button_text', 'type' => 'text', 'label' => 'Button Text', 'std' => ''],
                ['id' => 'button_url', 'type' => 'url', 'label' => 'Button URL', 'std' => '#'],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'slides' => [
                ['image' => '', 'title' => 'Welcome to Our Company', 'subtitle' => 'Building the future, together.', 'button_text' => 'Discover', 'button_url' => '/about'],
                ['image' => '', 'title' => 'Quality You Can Trust', 'subtitle' => 'Premium standards on every project.', 'button_text' => 'Our Work', 'button_url' => '/services'],
            ],
        ];
    }
}
