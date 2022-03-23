<?php

/**
 * 
 *
 * @package   local_message
 * @author    Alexander Acosta
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 */

//Cargar configuración de moodle
require_once(__DIR__.'/../../config.php');
//Cargar la clase del formulario 
require_once($CFG->dirroot.'/local/message/classes/form/edit.php');

//interface with the db
global $DB;


//Set la url para evitar warnings
$PAGE->set_url(new moodle_url('/local/message/edit.php'));
//contexto. El nivel del sitio al que estamos. En este caso al nivel más alto. system level
$PAGE->set_context(\context_system::instance());
//Configuración del título de la página
$PAGE->set_title('Edit');

//We want to display our form
$mform = new edit();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {

    //go back to manage.php page
    redirect($CFG->wwwroot.'/local/message/manage.php', get_string('cancelled_form','local_message'));
    
} else if ($fromform = $mform->get_data()) {
  
    //Insert the data into our database
    $recordtoinsert = new stdClass();
    $recordtoinsert->messagetext = $fromform->messagetext;
    $recordtoinsert->messagetype = $fromform->messagetype;
 
    //Insertamos en la tabla de la db el objeto con los datos
    $DB->insert_record('local_message', $recordtoinsert);
    redirect($CFG->wwwroot.'/local/message/manage.php', get_string('created_message','local_message').$fromform->messagetext);
} 

//Para renderizar html se utiliza la variable local OUTPUT
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();