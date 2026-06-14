<?php

namespace App\Library\PageBuilder\Blocks;

use App\Library\PageBuilder\BlockBase;

class VideoBlock extends BlockBase
{
    public string $id = 'video';
    public string $name = 'Video';
    public string $category = 'Media';
    public string $icon = 'fa-circle-play';

    public function settings(): array
    {
        return [
            ['id' => 'title', 'type' => 'text', 'label' => 'Heading', 'std' => ''],
            ['id' => 'subtitle', 'type' => 'text', 'label' => 'Subheading', 'std' => ''],
            ['id' => 'video_url', 'type' => 'url', 'label' => 'YouTube/Embed URL', 'std' => ''],
            ['id' => 'poster', 'type' => 'image', 'label' => 'Poster Image (optional)', 'std' => ''],
        ];
    }

    public function model(): array
    {
        return [
            'title' => 'Watch Our Story',
            'subtitle' => 'See what we do in two minutes',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'poster' => '',
        ];
    }
}
