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
    global $DB, $USER;
    
    //Garantiza que los mensajes sólo se vean una vez
    $sql = 'SELECT lm.id, lm.messagetext, lm.messagetype
            FROM {local_message} lm
            left outer join {local_message_read} lmr ON lm.id = lmr.messageid
            WHERE lmr.userid <> :userid
            OR lmr.userid IS NULL';

    $params = [
      'userid' => $USER->id 
    ];

    $messages = $DB->get_records_sql($sql, $params);

    foreach($messages as $message){

      $type = \core\output\notification::NOTIFY_INFO;

      if($message->messagetype === '0'){
        $type = \core\output\notification::NOTIFY_WARNING;
      }
      if($message->messagetype === '1'){
        $type = \core\output\notification::NOTIFY_SUCCESS;
      }
      if($message->messagetype === '2'){
        $type = \core\output\notification::NOTIFY_ERROR;
      }

      // Add a notification of some kind.
      \core\notification::add($message->messagetext, $type);

      $readrecord = new stdClass();
      $readrecord->messageid = $message->id;
      $readrecord->userid = $USER->id;
      $readrecord->timeread = time();
      $DB->insert_record('local_message_read', $readrecord);
    }
 }