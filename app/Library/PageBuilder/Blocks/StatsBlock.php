<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class StatsBlock extends BlockBase
{
    public string $id = 'stats';
    public string $name = 'Stats / Counters';
    public string $category = 'Sections';
    public string $icon = 'fa-chart-simple';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading (optional)', 'std' => ''],
            ['id' => 'items', 'type' => 'listItem', 'label' => 'Stats', 'settings' => [
                ['id' => 'value', 'type' => 'text', 'label' => 'Number', 'std' => '100'],
                ['id' => 'suffix', 'type' => 'text', 'label' => 'Suffix', 'std' => '+'],
                ['id' => 'label', 'type' => 'text', 'label' => 'Label', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => '',
            'items' => [
                ['value' => '500', 'suffix' => '+', 'label' => 'Happy Clients'],
                ['value' => '120', 'suffix' => '+', 'label' => 'Projects Done'],
                ['value' => '15', 'suffix' => '+', 'label' => 'Years Experience'],
                ['value' => '24', 'suffix' => '/7', 'label' => 'Support'],
            ],
        ];
    }
}
