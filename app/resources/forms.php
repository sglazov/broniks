<?php
  if (isset($_POST['call_name'])) { $name = $_POST['call_name'];}
  if (isset($_POST['call_tel']))  { $tel  = $_POST['call_tel'];}

  $ip = getenv(REMOTE_ADDR);
  $time = date("H:i:s d M Y");
  $soft = getenv(HTTP_USER_AGENT);
  $url_o = getenv(HTTP_REFERER);

  $sub = "=?utf-8?b?".base64_encode("Сайт «Броникс»: появилась новая заявка на вызов агента")."?="; // тема письма, принудительно в ЮТФ-8

  $address = "yaglazov@gmail.com"; // кому отправляется письмо, указание адресатов через запятую — сработает

  $headers  = "From: " . strip_tags($email) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($email) . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html;charset=utf-8 \r\n"; // чтобы всё пришло в правильной кодировке!

  $mes  = "<html><body style='font-family:Arial,sans-serif;'>";
  $mes .= "<h1 style='font-weight:400;border-bottom:1px dotted #f3f3f3;font-size:22px;padding-bottom:8px;color:#2E2B77;'>Сайт «Броникс»: новая заявка на вызов агента</h1>\r\n";
    if (isset($_POST['call_name'])){$mes .= "<p style=\"margin-left:20px;font-size:16px;line-height: 24px\"><strong>Представились:</strong> ".$name."<br />\r\n";}
    if (isset($_POST['call_tel'])) {$mes .= "<strong>Телефонный номер:</strong> ".$tel."</p>\r\n";}
  $mes .= "<p style=\"color:#444;font-size:12px;padding-top:10px;border-top:1px dotted #dae5e8;\">IP: ".$ip."<br />\r\n";
  $mes .= "Время отправки заявки: ".$time."<br />\r\n";
  $mes .= "Браузер: ".$soft."<br />\r\n";
  $mes .= "Откуда пришёл посетитель: ".$url_o."</p>\r\n";
  $mes .= "</body></html>";
  mail ($address,$sub,$mes,$headers);

  // Записать данные из формы в файл
  $fo=fopen("_dataforms.txt", "a");
  fwrite($fo, "
  <tr>
   <td>$time</td>
   <td>{$_POST['call_name']}</td>
   <td><a href=\"tel:{$_POST['call_tel']}\">{$_POST['call_tel']}</a></td>
  </tr>\n");
  fclose($fo);
?>
