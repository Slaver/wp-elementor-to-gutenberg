<?php

namespace ElementorToGutenberg\Parser\Elementor;

class Settings
{
    // List of CSS rules
    protected array $settings = [];

    // List of JSON comments properties, replaced from settings
    protected array $replace = [];

    // Custom properties only for JSON comments
    protected array $additional = [];

    // Custom HTML classes for tags
    protected array $classes = [];

    // Custom HTML attributes for tags
    protected array $attributes = [];

    // Current element
    protected object $element;

    public function __construct(object $element)
    {
        $this->element = $element;
        $this->set();
    }

    public function set()
    {
    }

    public function push($name, $value)
    {
        $this->settings[$name] = $value;
    }

    public function get(string $value): array
    {
        if ($value) {
            if (in_array($value, $this->settings)) {
                return $this->settings[$value];
            }
        }

        return $this->settings;
    }

    public function classes()
    {
        if ( ! empty($this->classes)) {
            return implode(' ', $this->classes);
        }

        return false;
    }

    public function attributes()
    {
        $attributes = [];
        if ( ! empty($this->attributes)) {
            foreach ($this->attributes as $attribute => $value) {
                if ( ! empty($value)) {
                    $attributes[] = $attribute . '="' . $value . '"';
                }
            }

            return implode(' ', $attributes);
        }

        return false;
    }

    public function css(): string
    {
        $css = [];
        foreach ($this->settings as $name => $settings) {
            if ( ! empty($settings)) {
                if ($name !== 'ordered') {
                    $css[] = $name . ': ' . $settings;
                }
            }
        }

        return implode('; ', $css);
    }

    public function json_settings(): array
    {
        $json = [];
        foreach ($this->settings as $name => $settings) {
            if ( ! empty($settings)) {
                $json[$this->replace[$name]] = $settings;
            }
        }

        return $json;
    }

    public function json_additional(): array
    {
        $json = [];
        if ( ! empty($this->additional)) {
            foreach ($this->additional as $name => $settings) {
                if ( ! empty($settings)) {
                    $json[$name] = $settings;
                }
            }
        }

        return $json;
    }

    public function json(): string
    {
        return json_encode(array_merge(
            ['block_id' => $this->element->id],
            $this->json_settings(),
            $this->json_additional()
        ));
    }
}