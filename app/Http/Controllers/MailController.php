<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class MailController extends Controller {

    public $dades = '';

/*    public function basic_email() {
      $data = array('name'=>"Virat Gandhi");

      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Asigancio de guardia');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Basic Email Sent. Check your inbox.";
   } */
   public function html_email($guardia) {
    $this->dades = $guardia['profe'];
      $data = array('modul'=>$guardia['modul'], 'aula' => $guardia['aula'], 'hora' => $guardia['hora'], 'dia' =>$guardia['dia'], 'tasca' =>$guardia['tasca']);
      Mail::send('mail', $data, function($message) {
         $message->to($this->dades, 'Prefectura ViB ')->subject
            ('Asignació i/o modificació de guardia');
        // $message->from('no-reply@gmail.com','NO REPLY Prefectura');
      });

   }
/*    public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('c:\Users\39714900H\Desktop\getput');
         $message->attach('c:\xampp\img\bitnami.ico');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   } */
}
