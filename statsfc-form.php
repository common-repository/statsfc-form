<?php
/*
Plugin Name: StatsFC Form
Plugin URI: https://statsfc.com/team-form
Description: StatsFC Form Guide
Version: 3.0.1
Author: Will Woodward
Author URI: https://willjw.co.uk
License: GPL2
*/

/*  Copyright 2020  Will Woodward  (email : will@willjw.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('STATSFC_FORM_ID',      'StatsFC_Form');
define('STATSFC_FORM_NAME',    'StatsFC Form');
define('STATSFC_FORM_VERSION', '3.0.1');

/**
 * Adds StatsFC widget.
 */
class StatsFC_Form extends WP_Widget
{
    public $isShortcode = false;

    protected static $count = 0;

    private static $defaults = array(
        'title'       => '',
        'key'         => '',
        'competition' => '',
        'team'        => '',
        'year'        => '',
        'date'        => '',
        'highlight'   => '',
        'show_badges' => true,
        'show_score'  => true,
        'limit'       => 0,
        'default_css' => true,
        'omit_errors' => false,
    );

    private static $whitelist = array(
        'competition',
        'team',
        'year',
        'date',
        'highlight',
        'showBadges',
        'showScore',
        'limit',
        'omitErrors',
        'lang',
    );

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(STATSFC_FORM_ID, STATSFC_FORM_NAME, array('description' => 'StatsFC League Table'));
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $instance    = wp_parse_args((array) $instance, self::$defaults);
        $title       = strip_tags($instance['title']);
        $key         = strip_tags($instance['key']);
        $competition = strip_tags($instance['competition']);
        $team        = strip_tags($instance['team']);
        $year        = strip_tags($instance['year']);
        $date        = strip_tags($instance['date']);
        $highlight   = strip_tags($instance['highlight']);
        $show_badges = strip_tags($instance['show_badges']);
        $show_score  = strip_tags($instance['show_score']);
        $limit       = strip_tags($instance['limit']);
        $default_css = strip_tags($instance['default_css']);
        $omit_errors = strip_tags($instance['omit_errors']);
        ?>
        <p>
            <label>
                <?php _e('Title', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Key', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo esc_attr($key); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Competition', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('competition'); ?>" type="text" value="<?php echo esc_attr($competition); ?>" placeholder="e.g., EPL, CHP, FAC">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Team', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('team'); ?>" type="text" value="<?php echo esc_attr($team); ?>" placeholder="e.g., Liverpool, Manchester City">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Year', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('year'); ?>" type="text" value="<?php echo esc_attr($year); ?>" placeholder="e.g., 2015/2016">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Date', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('date'); ?>" type="text" value="<?php echo esc_attr($date); ?>" placeholder="YYYY-MM-DD">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Highlight team', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('highlight'); ?>" type="text" value="<?php echo esc_attr($highlight); ?>" placeholder="e.g., Liverpool, Manchester City">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show badges?', STATSFC_FORM_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_badges'); ?>"<?php echo ($show_badges == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show match scores?', STATSFC_FORM_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_score'); ?>"<?php echo ($show_score == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Limit', STATSFC_FORM_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo esc_attr($limit); ?>" min="0" max="99">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Use default styles?', STATSFC_FORM_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('default_css'); ?>"<?php echo ($default_css == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Omit error messages?', STATSFC_FORM_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('omit_errors'); ?>"<?php echo ($omit_errors == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance                = $old_instance;
        $instance['title']       = strip_tags($new_instance['title']);
        $instance['key']         = strip_tags($new_instance['key']);
        $instance['competition'] = strip_tags($new_instance['competition']);
        $instance['team']        = strip_tags($new_instance['team']);
        $instance['year']        = strip_tags($new_instance['year']);
        $instance['date']        = strip_tags($new_instance['date']);
        $instance['highlight']   = strip_tags($new_instance['highlight']);
        $instance['show_badges'] = strip_tags($new_instance['show_badges']);
        $instance['show_score']  = strip_tags($new_instance['show_score']);
        $instance['limit']       = strip_tags($new_instance['limit']);
        $instance['default_css'] = strip_tags($new_instance['default_css']);
        $instance['omit_errors'] = strip_tags($new_instance['omit_errors']);

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        $title       = apply_filters('widget_title', (array_key_exists('title', $instance) ? $instance['title'] : ''));
        $unique_id   = ++static::$count;
        $key         = (array_key_exists('key', $instance) ? $instance['key'] : '');
        $referer     = (array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '');
        $default_css = (array_key_exists('default_css', $instance) && filter_var($instance['default_css'], FILTER_VALIDATE_BOOLEAN));

        $options = array(
            'competition' => (array_key_exists('competition', $instance) ? $instance['competition'] : ''),
            'team'        => (array_key_exists('team', $instance) ? $instance['team'] : ''),
            'year'        => (array_key_exists('year', $instance) ? $instance['year'] : ''),
            'date'        => (array_key_exists('date', $instance) ? $instance['date'] : ''),
            'highlight'   => (array_key_exists('highlight', $instance) ? $instance['highlight'] : ''),
            'showBadges'  => (array_key_exists('show_badges', $instance) && filter_var($instance['show_badges'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'showScore'   => (array_key_exists('show_score', $instance) && filter_var($instance['show_score'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'limit'       => (array_key_exists('limit', $instance) ? (int) $instance['limit'] : 0),
            'omitErrors'  => (array_key_exists('omit_errors', $instance) && filter_var($instance['omit_errors'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'lang'        => substr(get_bloginfo('language'), 0, 2),
        );

        $html = '';

        if (isset($before_widget)) {
            $html .= $before_widget;
        }

        if (isset($before_title)) {
            $html .= $before_title;
        }

        $html .= $title;

        if (isset($after_title)) {
            $html .= $after_title;
        }

        $html .= '<div id="statsfc-form-' . $unique_id . '"></div>' . PHP_EOL;

        if (isset($after_widget)) {
            $html .= $after_widget;
        }

        // Enqueue CSS
        if ($default_css) {
            wp_enqueue_style(STATSFC_FORM_ID, plugins_url('form.css', __FILE__), null, STATSFC_FORM_VERSION);
        }

        // Enqueue base JS
        wp_enqueue_script(STATSFC_FORM_ID, plugins_url('form.js', __FILE__), array('jquery'), STATSFC_FORM_VERSION, true);

        // Enqueue widget JS
        $object = 'statsfc_form_' . $unique_id;

        $script  = '<script>' . PHP_EOL;
        $script .= 'var ' . $object . ' = new StatsFC_Form(' . json_encode($key) . ');' . PHP_EOL;
        $script .= $object . '.referer = ' . json_encode($referer) . ';' . PHP_EOL;

        foreach (static::$whitelist as $parameter) {
            if (! array_key_exists($parameter, $options)) {
                continue;
            }

            $script .= $object . '.' . $parameter . ' = ' . json_encode($options[$parameter]) . ';' . PHP_EOL;
        }

        $script .= $object . '.display("statsfc-form-' . $unique_id . '");' . PHP_EOL;
        $script .= '</script>';

        add_action('wp_print_footer_scripts', function () use ($script) {
            echo $script;
        });

        if ($this->isShortcode) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function shortcode($atts)
    {
        $args = shortcode_atts(self::$defaults, $atts);

        $widget              = new self;
        $widget->isShortcode = true;

        return $widget->widget(array(), $args);
    }
}

// register StatsFC widget
add_action('widgets_init', function () {
    register_widget(STATSFC_FORM_ID);
});

add_shortcode('statsfc-form', STATSFC_FORM_ID . '::shortcode');
