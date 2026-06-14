<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class WhyChooseBlock extends BlockBase
{
    public string $id = 'why_choose';
    public string $name = 'Why Choose Us';
    public string $category = 'Sections';
    public string $icon = 'fa-circle-check';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'image', 'type' => 'image', 'label' => 'Side Image', 'std' => ''],
            ['id' => 'items', 'type' => 'listItem', 'label' => 'Reasons', 'settings' => [
                ['id' => 'icon', 'type' => 'icon', 'label' => 'Icon', 'std' => 'fa-check'],
                ['id' => 'title', 'type' => 'text', 'label' => 'Title', 'std' => ''],
                ['id' => 'text', 'type' => 'textarea', 'label' => 'Description', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Why Choose Us',
            'subtitle' => 'The advantages that set us apart',
            'image' => '',
            'items' => [
                ['icon' => 'fa-medal', 'title' => 'Proven Experience', 'text' => '10+ years delivering results.'],
                ['icon' => 'fa-users', 'title' => 'Expert Team', 'text' => 'Specialists in every field.'],
                ['icon' => 'fa-clock', 'title' => 'On-Time, Every Time', 'text' => 'We respect your deadlines.'],
            ],
        ];
    }
}
