<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 17.07.2017
 * Time: 12:46
 */

include("../connect.php");

$req = false;
ob_start();

if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '" . $_POST['email'] . "'");
	$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

	if ($emailCheck[0] > 0) {
		$filesErrors = 0;
		$fileNames = "";
		$filesCount = 0;

		if (!empty($_FILES['attachment']['tmp_name'][0])) {
			for ($i = 0; $i < count($_FILES['attachment']['name']); $i++) {
				if (empty($_FILES['attachment']['tmp_name'][$i]) or $_FILES['attachment']['error'][$i] != 0) {
					$filesErrors++;
				} else {
					if ($i > 0) {
						$fileNames .= "; ";
					}

					$filesCount++;
					$fileNames .= $_FILES['attachment']['name'][$i];
				}
			}
		}

		if ($filesErrors == 0) {
			$from = "ЧТУП Аргос-ФМ <" . CONTACT_EMAIL . ">";
			$subject = $mysqli->real_escape_string($_POST['subject']);
			$reply = CONTACT_EMAIL;
			$text = $_POST['text'];
			$to = $_POST['email'];

			$hash = md5(rand(0, 1000000) . date('Y-m-d H:i:s'));

			$headers = "From: " . $from . "\nReply-To: " . $reply . "\nMIME-Version: 1.0";
			$headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-" . $hash . "\"\n\n";

			$message = "--PHP-mixed-" . $hash . "\n";
			$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
			$message .= "Content-Transfer-Encoding: 8bit\n\n";
			$message .= $text . "\n";
			$message .= "--PHP-mixed-" . $hash . "\n";

			if (!empty($_FILES['attachment']['tmp_name'][0])) {
				for ($i = 0; $i < count($_FILES['attachment']['name']); $i++) {
					$attachment = chunk_split(base64_encode(file_get_contents($_FILES['attachment']['tmp_name'][$i])));

					$message .= "Content-Type: application/octet-stream; name=" . $_FILES['attachment']['name'][$i] . "\n";
					$message .= "Content-Transfer-Encoding: base64\n";
					$message .= "Content-Disposition: attachment\n\n";
					$message .= $attachment . "\n";
					$message .= "--PHP-mixed-" . $hash . "\n";
				}
			}

			if (mail($to, $subject, $message, $headers)) {
				if ($mysqli->query("INSERT INTO mail_result (subject, text, send_to, date, count, send, files_count, filenames) VALUES ('" . $subject . "', '" . $text . "', '" . $to . "', '" . date('Y-m-d H:i:s') . "', '1', '1', '" . $filesCount . "', '" . $fileNames . "')")) {
					echo "ok";
				} else {
					echo "result";
				}
			} else {
				echo "failed";
			}
		} else {
			echo "files";
		}
	} else {
		echo "email";
	}
} else {
	echo "format";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;