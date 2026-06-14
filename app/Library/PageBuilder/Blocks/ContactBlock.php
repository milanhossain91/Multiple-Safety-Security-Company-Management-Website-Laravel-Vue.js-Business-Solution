<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class ContactBlock extends BlockBase
{
    public string $id = 'contact';
    public string $name = 'Contact';
    public string $category = 'Marketing';
    public string $icon = 'fa-envelope';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'address', 'type' => 'text', 'label' => 'Address', 'std' => ''],
            ['id' => 'phone', 'type' => 'text', 'label' => 'Phone', 'std' => ''],
            ['id' => 'email', 'type' => 'text', 'label' => 'Email', 'std' => ''],
            ['id' => 'show_form', 'type' => 'select', 'label' => 'Show Contact Form', 'std' => '1',
                'options' => ['1' => 'Yes', '0' => 'No']],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Get In Touch',
            'subtitle' => 'We would love to hear from you',
            'address' => 'Dhaka, Bangladesh',
            'phone' => '+8801718200298',
            'email' => 'info@atsl.com',
            'show_form' => '1',
        ];
    }
}
