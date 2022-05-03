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
 * Settings for the globalwidgets block
 *
 * @copyright 2022 Andrew Normore
 * @license   http://www.gnu.org/copyleft/gpl.globalwidgets GNU GPL v3 or later
 * @package   block_globalwidgets
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_globalwidgets_allowcssclasses', get_string('allowadditionalcssclasses', 'block_globalwidgets'),
                       get_string('configallowadditionalcssclasses', 'block_globalwidgets'), 0));
}


