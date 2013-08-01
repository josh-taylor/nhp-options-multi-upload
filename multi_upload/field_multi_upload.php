<?php
/*  Copyright 2013  Josh Taylor  (email : joshotaylor@gmail.com)

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

class NHP_Options_multi_upload extends NHP_Options
{
    protected $inputKey = 0;

    public function __construct($field = array(), $value = '', $parent)
    {
        parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
        $this->field = $field;
        $this->value = $value;
    }

    public function render()
    {
        $class = isset($this->field['class']) ? $this->field['class'] : 'regular-text';
        $id = $this->field['id'];
        $name = $this->args['opt_name'];
        $value = $this->value;

        // Render each input
        echo "<ul id='{$id}-ul'>";
        if (is_array($value)) {
            foreach ($value as $key => $value) {
                $this->renderInput($id, $name, $value, $class);
            }
        } else {
            $this->renderInput($id, $name, $value, $class);
        }
        echo "</ul>";

        // Render the add button
        echo "<a href='javascript:;' class='nhp-opts-multi-upload-add' rel-id='{$id}-ul' rel-name='{$name}[{$id}][]'>";
        echo __('Add More', 'nhp-opts');
        echo "</a><br />";

        if ($description = $this->field['desc'] && !empty($description)) {
            echo "<br /><br /><span class='description'>{$description}</span>";
        }
    }

    protected function renderInput($id, $name, $value, $class)
    {
        echo "<li>";
        echo "<input type='hidden' id='{$id}-{$this->inputKey}' name='{$name}[{$id}][]' value='{$value}' class='{$class}' />";
        echo "<img class='nhp-opts-screenshot' id='nhp-opts-screenshot-{$id}-{$this->inputKey}' src='{$value}' />";

        $uploadStyle = '';
        $removeStyle = '';
        if ($value == '') {
            $removeStyle = "style='display:none;'";
        } else {
            $uploadStyle = "style='display:none;'";
        }

        echo "<a href='javascript:;' class='nhp-opts-multi-upload button-secondary' rel-id='{$id}-{$this->inputKey}' {$uploadStyle}>";
        echo __('Browse', 'nhs-opts');
        echo "</a>";
        echo "<a href='javascript:;' class='nhp-opts-multi-upload-remove nhp-opts-multi-upload-remove' rel-id='{$id}-{$this->inputKey}' {$removeStyle}>";
        echo __('Remove', 'nhs-opts');
        echo "</a>";
        echo "</li>";

        ++$this->inputKey;
    }

    public function enqueue()
    {
        wp_enqueue_script(
            'nhp-opts-field-multi-upload-js',
            NHP_OPTIONS_URL . 'fields/multi_upload/field_multi_upload.js',
            array('jquery'),
            time(),
            true
        );

        wp_enqueue_script('thickbox');
        wp_localize_script('nhp-opts-field-upload-js', 'nhp_upload', array('url' => $this->url . 'fields/upload/blank.png'));
    }
}

