<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('mailer/class.phpmailer.php');

function log_notification($locale, $kind, $to, $subj, $text, $refop, $link)
{
	global $mysqlprefix;
	$query = sprintf(
		"insert into ${mysqlprefix}chatnotification (locale,vckind,vcto,vcsubject,tmessage,refoperator,dtmcreated) values ('%s','%s','%s','%s','%s',%s,%s)",
		$locale,
		$kind,
		mysql_real_escape_string($to, $link),
		mysql_real_escape_string($subj, $link),
		mysql_real_escape_string($text, $link),
		$refop ? $refop : "0",
		"CURRENT_TIMESTAMP");

	perform_query($query, $link);
}

/*function webim_mail($toaddr, $reply_to, $subject, $body, $link)
{
	global $webim_encoding, $webim_mailbox, $mail_encoding, $current_locale;

	$headers = "From: $webim_mailbox\r\n"
			   . "Reply-To: " . myiconv($webim_encoding, $mail_encoding, $reply_to) . "\r\n"
			   . "Content-Type: text/plain; charset=$mail_encoding\r\n"
			   . 'X-Mailer: PHP/' . phpversion();

	$real_subject = "=?" . $mail_encoding . "?B?" . base64_encode(myiconv($webim_encoding, $mail_encoding, $subject)) . "?=";

	$body = preg_replace("/\n/", "\r\n", $body);

	log_notification($current_locale, "mail", $toaddr, $subject, $body, null, $link);
	@mail($toaddr, $real_subject, wordwrap(myiconv($webim_encoding, $mail_encoding, $body), 70), $headers);
}*/


function webim_mail($toaddr, $reply_to, $subject, $body, $link)
{
   global $webim_encoding, $webim_mailbox, $mail_encoding, $current_locale;

   $headers = "From: $webim_mailbox\r\n"
            . "Reply-To: " . myiconv($webim_encoding, $mail_encoding, $reply_to) . "\r\n"
            . "Content-Type: text/plain;
charset=$mail_encoding\r\n"
            . 'X-Mailer: PHP/' . phpversion();

   $real_subject = "=?" . $mail_encoding . "?B?" . base64_encode(myiconv($webim_encoding, $mail_encoding, $subject)) . "?=";

   $body = preg_replace("/\n/", "\r\n", $body);  //I couldn't get the line breaks to work
  
      $mail             = new PHPMailer();

      $mail->IsSMTP();
      $mail->SMTPAuth   = false;                  // enable SMTP authentication
      $mail->Host           = "localhost";      // sets up fqdn of your SMTP server : port
      //$mail->Username   = "pudicaph17@gmail.com";  // username
      //$mail->Password   = "powman87";            // password
      //$mail->Port     = 465; // PORTA

      $mail->From       = $webim_mailbox;
      $mail->FromName   = "Chat Online"; // you can adjust these to suit
      $mail->Subject    = $subject;
      $mail->AltBody    = $body; //Text Body
      $mail->WordWrap   = 50; // set word wrap

      $mail->MsgHTML($body);

      //$mail->AddReplyTo("contato@netsuprema.com.br","Contato Net Suprema");

      $mail->AddAddress($toaddr, $toaddr);

      $mail->IsHTML(false); // send as HTML

      $mail->Send();

 
}

function webim_xmpp($toaddr, $subject, $text, $link)
{
	global $current_locale;
	log_notification($current_locale, "xmpp", $toaddr, $subject, $text, null, $link);
}

?>