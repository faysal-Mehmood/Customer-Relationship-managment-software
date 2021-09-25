<?php
/**
  * Import materials from csv material lists to be uploaded to customer database
  *
**/
session_start();
require_once '../classes/dbClass.php';
$db = new DB();
require_once '../classes/logging.php';
$log = new Log($dbPre);

$jsonData = array();

if (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
    // Clean and convert post vars for html
    foreach ($_POST as $key => $value) {
        $key = trim(htmlentities($key, ENT_QUOTES, "UTF-8"));
        $value = trim(htmlentities($value, ENT_QUOTES, "UTF-8"));  // prior to 5.4 default is iso-8859-1
        $post[$key] = $value;
    }

    switch ($post['method']) {

        case 'cancelImport':                     // cancel and remove import session data
            unset($_SESSION['import']);
            unset($_SESSION['topRow']);
            unset($_SESSION['columnOrder']);
            $jsonData['error'] = 0;
            break;

        case 'continueImport' :                  // Second Step, receive organized columns
            unset($_SESSION['topRow']);
            if(get_magic_quotes_gpc()){
                $d = stripslashes($_POST['columnOrder']);
            }else{
                $d = $_POST['columnOrder'];
            }
            $_SESSION['columnOrder'] = json_decode($d, true);

            $sql = "select * from {$dbPre}leadSource order by sourceName asc";
            $leadSource = $db->extQuery($sql);
            $sql = "select * from {$dbPre}leadStatus order by statusName asc";
            $leadStatus = $db->extQuery($sql);
            $sql = "select * from {$dbPre}leadType order by typeName asc";
            $leadType = $db->extQuery($sql);
            
            $jsonData['leadSource'] = $leadSource;
            $jsonData['leadStatus'] = $leadStatus;
            $jsonData['leadType'] = $leadType;
            $jsonData['error'] = 0;
            break;

        case 'finishImport' :                    // Complete upload and move data to database
            $source = $post['source'];
            $status = $post['status'];
            $type = $post['type'];

            $where = array (
                'id' => 1
            );

            $newOrder = array();
            $dbColumns = array(
                0 =>  'firstName',
                1 =>  'lastName',
                2 =>  'Address',
                3 =>  'Phone',
                4 =>  'subject',
                5 =>  'startdate',
                6 =>  'Email',
                7 =>  'secondaryEmail1',
                8 =>  'secondaryEmail2',
                9 =>  'secondaryEmail3',
                10 => 'enddate',
                11 => 'weightage',
                12 => 'marksobtained',
                13 => 'totalmarks',
                14 => 'customField',
                15 => 'customField2',
                16 => 'customField3',
                17 => 'customField4',
                18 => 'customField5',
                19 => 'customField6',
                20 => 'customField7',
                21 => 'customField8',
                22 => 'customField9',
                23 => 'customField10',
                24 => 'customField11',
                25 => 'customField12',
                26 => 'customField13',
                27 => 'customField14',
                28 => 'customField15',
                29 => 'customField16',
                30 => 'Notes'
             );
            $line = 0;
            foreach ($_SESSION['import'] as $row => $data) {
                $line++;
                $i = 0;
                foreach ($_SESSION['columnOrder'] as $order => $column) {
                    if ($i > 30) {
                        break;
                    }
                    $newOrder[$line][$dbColumns[$i]] = isset($data[$column['name']]) ? trim($data[$column['name']]) : '';
                    $i++;
                }
            }
            $insertCount = 0;
            foreach ($newOrder as $row => $data) {
                $dateAdded = date("Y-m-d H:i:s");
                $creator = $_SESSION['userID'];
                if ( $data['firstName'] != '' ) {  // just make sure there is at least a first name
                // && $data['lastName'] != '' ) {
                    if (isset($data['Email']) ) {        // Do not allow invalid emails
                        $Email = filter_var($data['Email'], FILTER_VALIDATE_EMAIL) ? $data['Email'] : '';
                    } else {
                        $Email = '';
                    }

                    $vals = array(
                        'firstName'      => isset($data['firstName']) ? $data['firstName'] : '',
                        'lastName'       => isset($data['lastName']) ? $data['lastName'] : '',
                        'Address'        => isset($data['Address']) ? $data['Address'] : '',
                        'Phone'          => isset($data['Phone']) ? $data['Phone'] : '',
                        'subject' => isset($data['subject']) ? $data['subject'] : '',
                        'startdate'            => isset($data['startdate']) ? $data['startdate'] : '',
                        'Email'          => isset($data['Email']) ? $data['Email'] : '',
                        'enddate'           => isset($data['enddate']) ? $data['enddate'] : '',
                        'weightage'          => isset($data['weightage']) ? $data['weightage'] : '',
                        'marksobtained'        => isset($data['marksobtained']) ? $data['marksobtained'] : '',
                        'totalmarks'            => isset($data['totalmarks']) ? $data['totalmarks'] : '',
                        'customField'    => isset($data['customField']) ? $data['customField'] : '',
                        'customField2'   => isset($data['customField2']) ? $data['customField2'] : '',
                        'customField3'   => isset($data['customField3']) ? $data['customField3'] : '',
                        'customField4'    => isset($data['customField4']) ? $data['customField4'] : '',
                        'customField5'   => isset($data['customField5']) ? $data['customField5'] : '',
                        'customField6'   => isset($data['customField6']) ? $data['customField6'] : '',
                        'customField7'    => isset($data['customField7']) ? $data['customField7'] : '',
                        'customField8'   => isset($data['customField8']) ? $data['customField8'] : '',
                        'customField9'   => isset($data['customField9']) ? $data['customField9'] : '',
                        'customField10'    => isset($data['customField10']) ? $data['customField10'] : '',
                        'customField11'   => isset($data['customField11']) ? $data['customField11'] : '',
                        'customField12'   => isset($data['customField12']) ? $data['customField12'] : '',
                        'customField13'    => isset($data['customField13']) ? $data['customField13'] : '',
                        'customField14'   => isset($data['customField14']) ? $data['customField14'] : '',
                        'customField15'   => isset($data['customField15']) ? $data['customField15'] : '',
                        'customField16'    => isset($data['customField16']) ? $data['customField16'] : '',
                       
                        'leadType'       => $type,
                        'leadSource'     => $source,
                        'istatus'        => $status,
                        'dateAdded'      => "$dateAdded",
                        'dateModified'   => "$dateAdded",
                        'lastModifiedBy' => $creator,
                        'assignedTo'     => $creator
                     );
                    $insertID = $db->insert("{$dbPre}contacts",$vals);
                    $insertCount++;
                    if (!empty($data['secondaryEmail1'])) {                 // Extra Emails
                        if (filter_var($data['secondaryEmail1'], FILTER_VALIDATE_EMAIL)) {
                            $vals = array (
                                'email'   => $data['secondaryEmail1'],
                                'contact' => $insertID
                            );
                            $db->insert("{$dbPre}otherEmails", $vals);
                        }
                    }
                    if (!empty($data['secondaryEmail2'])) {
                        if (filter_var($data['secondaryEmail2'], FILTER_VALIDATE_EMAIL)) {
                            $vals = array (
                                'email'   => $data['secondaryEmail2'],
                                'contact' => $insertID
                            );
                            $db->insert("{$dbPre}otherEmails", $vals);
                        }
                    }
                    if (!empty($data['secondaryEmail3'])) {
                        if (filter_var($data['secondaryEmail3'], FILTER_VALIDATE_EMAIL)) {
                            $vals = array (
                                'email'   => $data['secondaryEmail3'],
                                'contact' => $insertID
                            );
                            $db->insert("{$dbPre}otherEmails", $vals);
                        }
                    }
                    if (!empty($data['Notes'])) {                           // Insert Notes
                        $vals = array (
                            'Note'      => $data['Notes'],
                            'leadID'    => $insertID,
                            'creator'   => $creator,
                            'dateAdded' => "$dateAdded"
                        );
                        $db->insert("{$dbPre}leadNotes", $vals);
                    }
                }
            }

            $jsonData['newOrder'] = $newOrder;
            $jsonData['error'] = 0;
            $jsonData['insertCount'] = $insertCount;
            // logging
            $event = 'Imported Leads and Contacts';
            $detail = "Imported $insertCount Contacts";
            $log->logEvent($_SESSION['userID'], $event, $detail);
            break;

        case 'uploadFile':                       // Upload the file, store contents in session
            unset($_SESSION['import']);
            unset($_SESSION['topRow']);
            unset($_SESSION['columnOrder']);

    	    $error = "";
    	    $msg = "";
    	    $file = 'fileToUpload';
            $TempSrc   = $_FILES[$file]['tmp_name']; // Tmp name of image file stored in PHP tmp folder
            $fileType = $_FILES[$file]['type']; //Obtain file type, returns "image/png", image/jpeg, text/plain etc.
            //$directory = dirname(__FILE__) . '/output/';
			//$extension = end(explode(".", $_FILES["fileToUpload"]["name"]));
			$tmp = explode('.',$_FILES['fileToUpload']['name']); $extension = end($tmp);  // avoid strict warning

    	    if(!empty($_FILES[$file]['error'])) {

    		    switch($_FILES[$file]['error']) {

			    case '1':
				    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				    break;
			    case '2':
				    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				    break;
			    case '3':
				    $error = 'The uploaded file was only partially uploaded';
				    break;
			    case '4':
				    $error = 'No file was uploaded.';
				    break;
			    case '6':
				    $error = 'Missing a temporary folder';
				    break;
			    case '7':
				    $error = 'Failed to write file to disk';
				    break;
			    case '8':
				    $error = 'File upload stopped by extension';
				    break;
			    case '999':
			    default:
				    $error = 'No error code avaiable';
	    	    }
    	    } elseif(empty($_FILES[$file]['tmp_name']) || $_FILES[$file]['tmp_name'] == 'none') {
	    	    $error = 'No file was uploaded..';
    	    } else {
                $fileName = preg_split("/\./", $_FILES[$file]['name']);
                $fileName = $fileName[0];
                switch($fileType) {
                    case 'text/csv' :                   // csv's 
                    case 'application/vnd.ms-excel':
                    case 'text/plain' :
                    case 'text/tsv' :
                        $extension = '.csv';
                        break;

                    case 'application/vnd.ms-excel' :   // Excel
                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' :
                        $extension = '.xlsx';
                        break;

                    default :
                        $extension = 'unsupported';
                        $error = 'Unsupported file type.  Use file type csv, xls, or xlsx';
                }
        
                if ($error == '') {
    	            $msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
    		        $msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);

                    include_once '../classes/PHPExcel/Classes/PHPExcel.php';
                    $inputFileName = $TempSrc;
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $worksheet = $objPHPExcel->getActiveSheet();
                    $i = 0;
                    foreach ($worksheet->getRowIterator() as $row) {   // Preliminary sanity check
                        $i++;
                        $col = 0;
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                if ($i == 1) {                // our top row is our keys for input
                                    $headRow[$col] = $cell->getValue();
                                    $col++;
                                }
                            }
                        }
                    }
                    $i = 0;
                    foreach ($worksheet->getRowIterator() as $row) {
                        $i++;
                        $col = 0;
                        //echo 'Row number: ' . $row->getRowIndex() . "\r\n";
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                if ($i == 1) {                // our top row is our keys for input
                                    $_SESSION['topRow'][$col] = trim($cell->getValue());
                                    $topRow[$col] = trim($cell->getValue());
                                    $col++;
                                } else {
                                    $_SESSION['import'][$row->getRowIndex()][$topRow[$col]] = trim(strip_tags($cell->getValue()));
                                    $col++;
                                    //echo 'Cell: ' . $cell->getCoordinate() . ' - ' . $cell->getValue() . "\r\n";
                                }
                            }
                        }
                    }
                    $jsonData['topRow'] =$_SESSION['topRow'];
                    $jsonData['import'] = $_SESSION['import'];
                    $jsonData['rows'] = $i;
                }
    	    }		
            $jsonData['tempSrc'] = $TempSrc;
            $jsonData['error'] = $error;
            $jsonData['msg'] = $msg;
            break;

        default:
            $jsonData = array(
                'error' => 1,
                'msg' => 'Unknown Post Method.'
            );
        }

        echo json_encode($jsonData);


    } else {
        echo "use the form.";
    }

?>
