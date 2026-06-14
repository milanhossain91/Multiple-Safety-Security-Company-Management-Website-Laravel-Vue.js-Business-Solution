<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class FaqBlock extends BlockBase
{
    public string $id = 'faq';
    public string $name = 'FAQ / Accordion';
    public string $category = 'Content';
    public string $icon = 'fa-circle-question';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'items', 'type' => 'listItem', 'label' => 'Questions', 'settings' => [
                ['id' => 'question', 'type' => 'text', 'label' => 'Question', 'std' => ''],
                ['id' => 'answer', 'type' => 'textarea', 'label' => 'Answer', 'std' => ''],
            ]],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Frequently Asked Questions',
            'subtitle' => 'Everything you need to know',
            'items' => [
                ['question' => 'How do I get started?', 'answer' => 'Simply contact us and our team will guide you through the process.'],
                ['question' => 'What areas do you cover?', 'answer' => 'We work with clients nationwide and internationally.'],
                ['question' => 'Do you offer support?', 'answer' => 'Yes, we provide 24/7 dedicated support to all our clients.'],
            ],
        ];
    }
}
