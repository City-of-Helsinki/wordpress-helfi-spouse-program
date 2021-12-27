<?php

class LoginStaticPagesGenerator{
        // Information needed for creating the plugin's pages
    const page_definitions = array(
        'login' => array(
            'slug' => 'login',
            'title' => 'Sign In',
            'content' => ''
        ),
        'register' => array(
            'slug' => 'register',
            'title' => 'Sign up',
            'content' => ''
        ),
        'account' => array(
            'slug' => 'member-account',
            'title' => 'Your Account',
            'content' => '[account-info]'
        ),
        'password-lost' => array(
            'slug' => 'password-lost',
            'title' => 'Forgot Your Password?',
            'content' => '[custom-password-lost-form]'
        ),
        'password-reset' => array(
            'slug' => 'member-password-reset',
            'title' => 'Pick a New Password',
            'content' => '[custom-password-reset-form]'
        )
    );
    public static function getPostId($slug){
        $posts = get_posts(array(
            'name'        => $slug,
            'post_type'   => 'page',
            'post_status' => 'publish',
            'numberposts' => 1
        ));
        
        if (is_array($posts) && is_object($posts[0])){
            return $posts[0]->ID;
        }

        return false;
    }
    public static function generate() {
        foreach ( self::page_definitions as $slug => $page ) {

            // Check that the page doesn't exist already
            $post = self::getPostId($slug);
            if ( ! $post) {
                // Add the page using the data from the array above
                wp_insert_post(
                    array(
                        'post_content'   => $page['content'],
                        'post_name'      => $slug,
                        'post_title'     => $page['title'],
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                        'ping_status'    => 'closed',
                        'comment_status' => 'closed',
                    )
                );
            }
        }
    }

    public static function url($key){

        $vals = self::get($key);
        if ($vals){
            $slug = $vals['slug'];
            return home_url($slug);
        }

        return false;
    }

    public static function get($key){
        if (array_key_exists($key, self::page_definitions)){
            return self::page_definitions[$key];
        }

        return false;
    }
}