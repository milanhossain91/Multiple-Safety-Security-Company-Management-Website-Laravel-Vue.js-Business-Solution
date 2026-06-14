<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class FeatureWithImageBlock extends BlockBase
{
    public string $id = 'feature_with_image';
    public string $name = 'Feature With Image';
    public string $category = 'Sections';
    public string $icon = 'fa-image';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'content', 'type' => 'richtext', 'label' => 'Content', 'std' => ''],
            ['id' => 'image', 'type' => 'image', 'label' => 'Image', 'std' => ''],
            ['id' => 'image_side', 'type' => 'select', 'label' => 'Image Side', 'std' => 'right',
                'options' => ['right' => 'Right', 'left' => 'Left']],
            ['id' => 'points', 'type' => 'listItem', 'label' => 'Bullet Points', 'settings' => [
                ['id' => 'text', 'type' => 'text', 'label' => 'Point', 'std' => ''],
            ]],
            ['id' => 'button_text', 'type' => 'text', 'label' => 'Button Text', 'std' => ''],
            ['id' => 'button_url', 'type' => 'url', 'label' => 'Button URL', 'std' => '#'],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Built For Performance',
            'subtitle' => 'Our approach',
            'content' => '<p>We combine modern technology with proven methods to deliver outstanding results for every client.</p>',
            'image' => '',
            'image_side' => 'right',
            'points' => [
                ['text' => 'Tailored to your goals'],
                ['text' => 'Transparent process'],
                ['text' => 'Measurable results'],
            ],
            'button_text' => 'Learn More',
            'button_url' => '/about',
        ];
    }
}
