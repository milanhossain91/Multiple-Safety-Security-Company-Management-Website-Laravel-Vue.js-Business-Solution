<?php

namespace App\Library\PageBuilder;

/**
 * Base class for every page-builder block.
 *
 * A block declares:
 *  - id / name / category / icon  (catalog metadata)
 *  - settings[]  : the editor form schema (fields the admin can edit)
 *  - model{}     : default data values
 *
 * Field types supported by the dynamic form + renderer:
 *   text | textarea | richtext | number | image | icon | url | select | color | listItem
 *
 * (Single-language — unlike the multilingual reference project, no en_/bn_ pairs.)
 */
abstract class BlockBase
{
    public string $id;
    public string $name;
    public string $category = 'General';
    public string $icon = 'fa-cube';

    public function __construct()
    {
        if (!isset($this->id)) {
            $this->id = class_basename(static::class);
        }
        if (!isset($this->name)) {
            $this->name = class_basename(static::class);
        }
    }

    /** Editor schema: ['settings' => [...], 'model' => [...]]. */
    abstract public function settings(): array;

    /** Default data for a freshly added block. */
    abstract public function model(): array;

    /** Full catalog entry for the front-end builder. */
    public function options(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'category' => $this->category,
            'icon'     => $this->icon,
            'settings' => $this->settings(),
            'model'    => $this->model(),
        ];
    }
}
