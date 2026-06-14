<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class TestimonialsBlock extends BlockBase
{
    public string $id = 'testimonials';
    public string $name = 'Testimonials';
    public string $category = 'Sections';
    public string $icon = 'fa-quote-left';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'items', 'type' => 'listItem', 'label' => 'Testimonials', 'settings' => [
                ['id' => 'quote', 'type' => 'textarea', 'label' => 'Quote', 'std' => ''],
                ['id' => 'name', 'type' => 'text', 'label' => 'Name', 'std' => ''],
                ['id' => 'role', 'type' => 'text', 'label' => 'Role / Company', 'std' => ''],
                ['id' => 'image', 'type' => 'image', 'label' => 'Photo', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'What Our Clients Say',
            'subtitle' => 'Trusted by businesses like yours',
            'items' => [
                ['quote' => 'They transformed our business. Truly professional and reliable.', 'name' => 'Sarah Ahmed', 'role' => 'CEO, TechCorp', 'image' => ''],
                ['quote' => 'Outstanding service from start to finish. Highly recommended!', 'name' => 'John Carter', 'role' => 'Founder, BuildIt', 'image' => ''],
            ],
        ];
    }
}
