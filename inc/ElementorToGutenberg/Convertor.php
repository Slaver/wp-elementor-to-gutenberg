<?php

namespace ElementorToGutenberg;

use ElementorToGutenberg\Parser\Parser;

class Convertor
{

    private Options $options;
    private Models\Posts $posts;
    private Parser $parser;

    public function __construct()
    {
        $this->options = new Options();
        $this->posts   = new Models\Posts();
        $this->parser  = new Parser();
    }

    public function run()
    {
        wp_send_json_success([
            'count' => $this->posts->count()
        ]);
    }

    public function next()
    {
        $result = [];
        $debug  = filter_var($_POST['debug'], FILTER_VALIDATE_BOOLEAN);

        $last  = $this->options->get('last') ?: 0;
        $posts = $this->posts->elementor($last);

        foreach ($posts as $post) {
            if ( ! empty($post->elementor)) {
                wp_cache_set('converter_postId', $post->ID);
                $result[$post->ID] = [
                    'title' => $post->post_title,
                    'converted' => $this->parser->recursively($post->elementor),
                ];
            }
        }

        if ( ! $debug) {
            foreach ($result as $postId => $postData) {
                $this->posts->update($postId, $postData['converted']);
                unset($result[$postId]['converted']);
            }
        }

        wp_send_json_success($result);
    }
}