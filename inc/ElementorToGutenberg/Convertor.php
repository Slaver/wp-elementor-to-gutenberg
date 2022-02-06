<?php

declare(strict_types=1);

namespace ElementorToGutenberg;

use ElementorToGutenberg\Parser\Parser;

class Convertor {

	private Options $options;
	private Models\Posts $posts;
	private Parser $parser;

	public function __construct()
	{
		$this->options = new Options();
		$this->posts = new Models\Posts();
		$this->parser = new Parser();
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
        $debug = filter_var($_POST['debug'], FILTER_VALIDATE_BOOLEAN);

        $last = $this->options->get('last') ?: 0;
        $posts = $this->posts->elementor($last);

        foreach ($posts as $post) {
            if (!empty($post->elementor)) {
                $result[$post->ID]['post'] = $post;
                $result[$post->ID]['converted'] = $this->parser->recursively($post->elementor);
            }
        }

        if (!$debug) {
            foreach ($result as $postId => $postData) {
                $this->posts->update($postData);
                unset($result[$postId]['converted']);
            }
        }

        wp_send_json_success($result);
	}
}