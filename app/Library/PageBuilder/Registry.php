<?php

namespace App\Library\PageBuilder;

/**
 * Central registry of all available page-builder blocks.
 * Mirrors the reference project's Registry: register blocks, expose a
 * grouped catalog for the editor, and resolve a block by id.
 *
 * Adding a new block = create a class under Blocks/ and register it here,
 * then add a matching frontend partial at resources/views/frontend/blocks/{id}.blade.php
 */
class Registry
{
    /** @var array<string, BlockBase> */
    protected array $blocks = [];

    public function __construct()
    {
        $classes = [
            Blocks\PageHeaderBlock::class,
            Blocks\HeroBlock::class,
            Blocks\HeroSliderBlock::class,
            Blocks\TextBlock::class,
            Blocks\FeaturesBlock::class,
            Blocks\ServicesGridBlock::class,
            Blocks\WhyChooseBlock::class,
            Blocks\StatsBlock::class,
            Blocks\FeatureWithImageBlock::class,
            Blocks\GalleryBlock::class,
            Blocks\FaqBlock::class,
            Blocks\TestimonialsBlock::class,
            Blocks\PartnersBlock::class,
            Blocks\VideoBlock::class,
            Blocks\CtaBannerBlock::class,
            Blocks\ContactBlock::class,
        ];

        foreach ($classes as $class) {
            $this->register(new $class);
        }
    }

    public function register(BlockBase $block): void
    {
        $this->blocks[$block->id] = $block;
    }

    /** @return array<string, BlockBase> */
    public function all(): array
    {
        return $this->blocks;
    }

    public function get(string $id): ?BlockBase
    {
        return $this->blocks[$id] ?? null;
    }

    /** Default model for a block id (used when adding to the canvas). */
    public function defaultModel(string $id): array
    {
        $block = $this->get($id);

        return $block ? $block->model() : [];
    }

    /** Catalog grouped by category for the editor's block list. */
    public function catalog(): array
    {
        $groups = [];

        foreach ($this->blocks as $id => $block) {
            $cat = $block->category;
            $groups[$cat] ??= ['name' => $cat, 'items' => []];
            $groups[$cat]['items'][] = $block->options();
        }

        return array_values($groups);
    }
}
