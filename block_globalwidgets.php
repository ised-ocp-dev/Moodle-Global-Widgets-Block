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

class block_globalwidgets extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_globalwidgets');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
		
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('newglobalwidgetsblock', 'block_globalwidgets'));
		$this->title = "";
    }

    function instance_allow_multiple() {
        return true;
    }
	

    function get_content() {
        global $CFG, $USER, $COURSE, $DB;
		
		// NOTE $this is this current block :)
		
		//var_dump($this->instance->id);
		
		// // // // require_once( $CFG->libdir.'/blocklib.php' );
		// // // // $context_course = context_course::instance($COURSE->id);
		// // // // //var_dump($context_course->id);
		
		// // // // //$blockrecords = $DB->get_records('block_instances', array('blockname' => 'globalwidgets', 'parentcontextid' => $context_course->id));
		// // // // //var_dump($blockrecords);
		// // // // // foreach ($blockrecords as $b){
			// // // // // var_dump($b);
			// // // // // $blockinstance = block_instance('globalwidgets', $b);
			// // // // // var_dump($blockinstance->config);
		// // // // // }
		
		
		
		// // // // $course_blocks = $DB->get_records_sql("SELECT * FROM {block_instances} WHERE parentcontextid = '".intval($context_course->id)."'", array(1));
		// // // // if($course_blocks){
		
			// // // // foreach($course_blocks as $course_block){
				// // // // //var_dump($course_block->configdata);
				// // // // //$block_instance = block_instance('globalwidgets', $course_block);
				// // // // //var_dump($block_instance->instance->configdata);
				// // // // //$config = unserialize(base64_decode($course_block->configdata));
				// // // // //var_dump($config);

				
			// // // // }
			

		
		// // // // }
		
		//$block_globalwidget = block_instance( 'globalwidgets', $context_course );

		
		
		$block_data = $DB->get_record_sql("SELECT * FROM {block_globalwidgets} WHERE blockinstanceid = '".intval($this->instance->id)."'", array(1));
		if($block_data){
			//var_dump($block_data->globalwidget);
			
			$content_data = $DB->get_record_sql("SELECT * FROM {globalwidgets_datacache} WHERE id = '".intval($block_data->globalwidget)."'", array(1));
			//var_dump($content_data->content);
			
			$this->content = new stdClass;
			$this->content->text =  format_text($content_data->content, FORMAT_HTML, null);
			
			//$template=format_text($template,FORMAT_HTML,$formatoptions);


			
			return  $this->content;
		}else{
			return false;
		}
    }


    /**
     * Serialize and store config data
     */
    // function instance_config_save($data, $nolongerused = false) {
        // global $DB;

        // $config = clone($data);
        // // Move embedded files into a proper filearea and adjust globalwidgets links to match
        // $config->text = file_save_draft_area_files($data->text['itemid'], $this->context->id, 'block_globalwidgets', 'content', 0, array('subdirs'=>true), $data->text['text']);
        // $config->format = $data->text['format'];

        // parent::instance_config_save($config, $nolongerused);
    // }

    // function instance_delete() {
        // global $DB;
        // $fs = get_file_storage();
        // $fs->delete_area_files($this->context->id, 'block_globalwidgets');
        // return true;
    // }

    /**
     * Copy any block-specific data when copying to a new block instance.
     * @param int $fromid the id number of the block instance to copy from
     * @return boolean
     */
    // public function instance_copy($fromid) {
        // $fromcontext = context_block::instance($fromid);
        // $fs = get_file_storage();
        // // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
        // if (!$fs->is_area_empty($fromcontext->id, 'block_globalwidgets', 'content', 0, false)) {
            // $draftitemid = 0;
            // file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_globalwidgets', 'content', 0, array('subdirs' => true));
            // file_save_draft_area_files($draftitemid, $this->context->id, 'block_globalwidgets', 'content', 0, array('subdirs' => true));
        // }
        // return true;
    // }

    // function content_is_trusted() {
        // global $SCRIPT;

        // if (!$context = context::instance_by_id($this->instance->parentcontextid, IGNORE_MISSING)) {
            // return false;
        // }
        // //find out if this block is on the profile page
        // if ($context->contextlevel == CONTEXT_USER) {
            // if ($SCRIPT === '/my/index.php') {
                // // this is exception - page is completely private, nobody else may see content there
                // // that is why we allow JS here
                // return true;
            // } else {
                // // no JS on public personal pages, it would be a big security issue
                // return false;
            // }
        // }

        // return true;
    // }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    // public function instance_can_be_docked() {
        // return (!empty($this->config->title) && parent::instance_can_be_docked());
    // }

    /*
     * Add custom globalwidgets attributes to aid with theming and styling
     *
     * @return array
     */
    // function globalwidgets_attributes() {
        // global $CFG;

        // $attributes = parent::globalwidgets_attributes();

        // if (!empty($CFG->block_globalwidgets_allowcssclasses)) {
            // if (!empty($this->config->classes)) {
                // $attributes['class'] .= ' '.$this->config->classes;
            // }
        // }

        // return $attributes;
    // }
}
