<?php

namespace ElementorToGutenberg\Parser\Elementor;

class Settings
{
    protected array $settings = [];
    protected array $replace = [];
    protected array $additional = [];
    protected array $classes = [];
    protected array $attributes = [];

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
        if (!empty($this->classes)) {
            return implode(' ', $this->classes);
        }
        return false;
    }

    public function attributes()
    {
        if (!empty($this->attributes)) {
            foreach($this->attributes as $attribute => $value) {
                if (!empty($value)) {
                    $return[] = $attribute . '="' . $value . '"';
                }
            }
            return implode(' ', $return);
        }
        return false;
    }

    public function css(): string
    {
        $css = [];
        foreach ($this->settings as $name => $settings) {
            if (!empty($settings)) {
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
            if (!empty($settings)) {
                $json[$this->replace[$name]] = $settings;
            }
        }
        return $json;
    }

    public function json_additional(): array
    {
        $json = [];
        if (!empty($this->additional)) {
            foreach ($this->additional as $name => $settings) {
                if (!empty($settings)) {
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