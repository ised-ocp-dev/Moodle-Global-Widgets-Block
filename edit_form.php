<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing globalwidgets block instances.
 *
 * @package   block_globalwidgets
 * @copyright 2022 Andrew Normore
 * @license   http://www.gnu.org/copyleft/gpl.globalwidgets GNU GPL v3 or later
 */

/**
 * Form for editing globalwidgets block instances.
 *
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.globalwidgets GNU GPL v3 or later
 */
class block_globalwidgets_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG, $DB;

        // Fields for editing globalwidgets block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
		
		$mform->addElement('static', 'description', 'Edit Global Content Blocks',  '<a href="'.$CFG->wwwroot.'/local/globalwidgets/dashboard.php">Click Here</a>', 'editlink');
		
		$available_widgets = [];
		$available_widgets[0] = "-EMPTY-";
		$widgets = $DB->get_records_sql('SELECT * FROM {globalwidgets_datacache}', array(1));
		foreach($widgets as $widget){
			$available_widgets[$widget->id] = $widget->title;
		}
		
		
		$courseid = required_param('id', PARAM_INT);
		
		
		$select = $mform->addElement('select', 'display_widget', "Select Global Content To Display", $available_widgets, $attributes);

        $mform->setType('config_title', PARAM_TEXT);
		
		if( $_POST['display_widget']){
			
			// SAVE DATA
			
			//$block_data = $DB->get_record_sql('SELECT * FROM {block_globalwidgets} WHERE courseid = '.$courseid, array(1));
			$DB->execute('DELETE FROM {block_globalwidgets} WHERE courseid='.intval($courseid));
			
			$data = new stdClass();
			$data->courseid = $courseid;
			$data->globalwidget = $_POST['display_widget'];
			
			$DB->insert_record('block_globalwidgets', $data, false);
			
			
		}
	
    }
	


    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {
           
			$text = $this->block->config->text;
			$display_widget = $this->block->config->display_widget;
		
			// $draftid_editor = file_get_submitted_draft_itemid('config_text');
            // if (empty($text)) {
                // $currenttext = '';
            // } else {
                // $currenttext = $text;
            // }
            // $defaults->config_text['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_globalwidgets', 'content', 0, array('subdirs'=>true), $currenttext);
            // $defaults->config_text['itemid'] = $draftid_editor;
            // $defaults->config_text['format'] = $this->block->config->format;
			
			$defaults->config_text['display_widget'] = 0;
			
			
			
        } else {
            $text = '';
			$selected_widget = 0;
        }

        if (!$this->block->user_can_edit() && !empty($this->block->config->title)) {
            // If a title has been set but the user cannot edit it format it nicely
            $title = $this->block->config->title;
            $defaults->config_title = format_string($title, true, $this->page->context);
            // Remove the title from the config so that parent::set_data doesn't set it.
			
			
            unset($this->block->config->title);
        }

        // have to delete text here, otherwise parent::set_data will empty content
        // of editor
        unset($this->block->config->text);
        parent::set_data($defaults);
        // restore $text
        if (!isset($this->block->config)) {
            $this->block->config = new stdClass();
        }
        $this->block->config->text = $text;
        if (isset($title)) {
            // Reset the preserved title
            $this->block->config->title = $title;
        }
		
		$this->block->config->display_widget = $display_widget;
		
    }
}
