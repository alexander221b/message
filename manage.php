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
//Set la url para evitar warnings
$PAGE->set_url(new moodle_url('/local/message/manage.php'));
//contexto. El nivel del sitio al que estamos. En este caso al nivel más alto. system level
$PAGE->set_context(\context_system::instance());
//Configuración del título de la página
$PAGE->set_title('Manage messages');

global $DB;

$messages = $DB->get_records('local_message');

//Para renderizar html se utiliza la variable local OUTPUT
echo $OUTPUT->header();
//El contexto del template por si le queremos pasar variables. Puedo usar el texto 'texttodisplay' en el template
$templatecontext = (object)[
    //convertimos el objeto con los datos a array para q el template lo pueda leer
    'messages' => array_values($messages),
    'editurl'  => new moodle_url('/local/message/edit.php')
];

echo $OUTPUT->render_from_template('local_message/manage',$templatecontext);

echo $OUTPUT->footer();