<?php

/**
 * 
 *
 * @package   local_message
 * @author    Alexander Acosta
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 function local_message_before_footer(){
    // Add a notification of some kind.
   \core\notification::add('test message', \core\output\notification::NOTIFY_INFO);
 }