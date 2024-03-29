<?php

namespace ElementorToGutenberg\Models;

use ElementorToGutenberg\Models;
use ElementorToGutenberg\Options;
use WP_Query;

class Posts extends Models
{
    const POST_META_ELEMENTOR_FIELD = '_elementor_data';
    const POST_META_ELEMENTOR_CONVERTED = '_elementor_converted';

    public function meta_query(): array
    {
        return [
            'relation' => 'AND',
            [
                'key' => self::POST_META_ELEMENTOR_FIELD
            ],
            [
                'key'     => self::POST_META_ELEMENTOR_CONVERTED,
                'compare' => 'NOT EXISTS',
                'value'   => '',
            ]
        ];
    }

    public function count(): int
    {
        $query = new WP_Query([
            'post_status'    => 'publish',
            'post_type'      => 'post',
            'posts_per_page' => '-1',
            'meta_query'     => $this->meta_query(),
        ]);

        return $query->found_posts;
    }

    public function elementor($last = 0, $limit = 1)
    {
        add_filter('posts_where', function ($where, WP_Query $q) {
            if ($q->get('last_id')) {
                $where .= ' AND ID > ' . $q->get('last_id');
            }
            return $where;
        }, 10, 2);

        $query = new WP_Query([
            'post_status'    => 'publish',
            'post_type'      => 'post',
            'posts_per_page' => $limit,
            'order'          => 'ASC',
            'meta_query'     => $this->meta_query(),
            // Custom param for `posts_where` filter
            'last_id'        => $last,
        ]);

        if ($query->posts) {
            foreach ($query->posts as $id => $post) {
                $query->posts[$id]->elementor = get_post_meta($post->ID, self::POST_META_ELEMENTOR_FIELD, true);
            }

            return $query->posts;
        }
        return false;
    }

    public function post($postId = false)
    {
        if ($postId) {
            $query = new WP_Query([
                'p' => $postId,
                'post_type'   => 'any',
                'post_status' => 'any',
            ]);

            if ($query->posts) {
                foreach ($query->posts as $id => $post) {
                    $query->posts[0]->elementor = get_post_meta($post->ID, self::POST_META_ELEMENTOR_FIELD, true);
                }
            }
            return $query->posts[0];
        }
    }

    public function update($postId, $postContent)
    {
        wp_update_post(wp_slash([
            'ID'           => $postId,
            'post_content' => $postContent
        ]));

        if (is_wp_error($postId)) {
            $errors = $postId->get_error_messages();
            wp_send_json_error('Post update errors: ' . implode("\r\n", $errors));
        }

        add_post_meta($postId, self::POST_META_ELEMENTOR_CONVERTED, true);

        $options = new Options();
        $options->add(['last' => $postId]);
    }

}