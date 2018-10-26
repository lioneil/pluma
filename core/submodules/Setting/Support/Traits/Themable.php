<?php

namespace Setting\Support\Traits;

trait Themable
{
    /**
     * Retrieve the themes from the filesystem.
     *
     * @return \Illuminate\Support\Collection
     */
    public function files()
    {
        return get_themes()
            ->except('active')
            ->sortBy('timestamp')
            ->reverse();
    }

    /**
     * Gets the registered themes.
     *
     * @param boolean $withActive
     * @return array
     */
    public static function themes($withActive = true)
    {
        $themes = get_themes();

        if (! $withActive) {
            foreach ($themes as $i => $item) {
                if (strtolower($item->name) === strtolower(settings('active_theme', 'default'))) {
                    unset($themes[$i]);
                }
            }
        }

        return collect($themes)->sortBy('timestamp')->reverse();
    }

    /**
     * Gets the specified theme.
     *
     * @param  string $theme
     * @return mixed
     */
    public static function theme($theme)
    {
        return get_themes()->only($theme)->first();
    }
}
