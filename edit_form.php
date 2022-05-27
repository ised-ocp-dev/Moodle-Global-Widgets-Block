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
		
		$mform->addElement('static', 'description', get_string('GlobalContentBlocks', 'block_globalwidgets'),  '<a href="'.$CFG->wwwroot.'/local/globalwidgets/dashboard.php">'.get_string('ManageAvailableGlobalContentBlocks', 'block_globalwidgets').'</a>', 'editlink');
		
		$available_widgets = [];
		$available_widgets[0] = "-EMPTY-";
		$widgets = $DB->get_records_sql('SELECT * FROM {globalwidgets_datacache}', array(1));
		foreach($widgets as $widget){
			//$available_widgets[$widget->id] = $widget->title; // WORKING - no mfilter
			
			$available_widgets[$widget->id] = format_text($widget->title, FORMAT_HTML, null);
			
		}
		
		
		$courseid = required_param('id', PARAM_INT);
		
		
		$select = $mform->addElement('select', 'display_widget', get_string('newglobalwidgetsblock','block_globalwidgets'), $available_widgets, $attributes);
		$mform->setDefault('display_widget', $widget->id);
		
		$mform->addElement('hidden','update_blockinstanceid','blockinstanceid',$_GET['id']);
		$mform->setDefault('update_blockinstanceid', $_GET['bui_editid']);

        $mform->setType('config_title', PARAM_TEXT);
		
		if( $_POST['display_widget']){
			
			// SAVE DATA
			//var_dump($_POST); die();
		
			//$block_data = $DB->get_record_sql('SELECT * FROM {block_globalwidgets} WHERE courseid = '.$courseid, array(1));
			$DB->execute("DELETE FROM {block_globalwidgets} WHERE courseid='".intval($courseid)."' AND blockinstanceid = '".intval($_POST['update_blockinstanceid'])."'");
			
			$blockinstanceid = 0;
			//var_dump($_GET['bui_editid']);
			if($_GET['bui_editid']){
				$blockinstanceid = $_GET['bui_editid'];
			}
			
			$DB->execute("INSERT INTO {block_globalwidgets} (courseid,globalwidget,blockinstanceid) VALUES (".$courseid.",".$_POST['display_widget'].",".$_POST['update_blockinstanceid'].")");
			
			// $data = new stdClass();
			// $data->courseid = $courseid;
			// $data->globalwidget = $_POST['display_widget'];
			// $data->blockinstanceid = $_POST['update_blockinstanceid']; 
			
			// // //var_dump($data); die();
			
			// $DB->insert_record('block_globalwidgets', $data, true);
			
			
		}
	
    }
	


    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {
           
			$text = $this->block->config->text;
			$display_widget = $this->block->config->display_widget;
			//$blockinstanceid = $this->block->config->blockinstanceid;
			
		
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
		
    }
}
