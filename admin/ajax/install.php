<?php
/**
 *  This is the working script for most of the ajax requests.
**/
session_start();
if (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
    // Clean and convert post vars for html
    foreach ($_POST as $key => $value) {
        $key = trim(htmlentities($key, ENT_QUOTES, "UTF-8"));
        $value = trim(htmlentities($value, ENT_QUOTES, "UTF-8"));
        $post[$key] = $value;
    }
    switch ($post['type']) {
        
        case 'testDB':                 // Test Database Connection
            $host       = $post['hostName'];
            $database   = $post['database'];
            $dbUser     = $post['dbUser'];
            $dbPassword = $post['dbPassword'];
            $dbPre      = $post['dbPre'];
            try {
                $connection = new PDO("mysql:host=$host;dbname=$database", 
                                      $dbUser, 
                                      $dbPassword,
                                      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $result = 'success';
            } catch(PDOException $ex) {
                $result = 'fail';
            }
            if ($result == 'fail') {
                $jsonData['error'] = 1;
                $jsonData['msg'] = "Cannot Connect with supplied credentials.";
            } else {
                $jsonData['error'] = 0;
                $jsonData['msg'] = 'Database Test Passed!';
            }
            echo json_encode($jsonData);
            break;

        case 'installLCM':            // Install Tables and config file
            $host       = $post['hostName'];
            $database   = $post['database'];
            $dbUser     = $post['dbUser'];
            $dbPassword = $post['dbPassword'];
            $dbPre      = $post['dbPre'];
            require_once "../classes/dbClass.php";
            $db = new DB($host, $database, $dbUser, $dbPassword);
            try {
                $connection = new PDO("mysql:host=$host;dbname=$database",
                                      $dbUser,
                                      $dbPassword,
                                      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $result = 'success';
            } catch(PDOException $ex) {
                $result = 'fail';
            }
            if ($result == 'fail') {
                $jsonData['error'] = 1;
                $jsonData['msg'] = "Cannot Connect with supplied credentials.";
            } else {

                // contacts table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}contacts` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`firstName` varchar(255) NOT NULL,"
                     . "`lastName` varchar(255) NOT NULL,"
                     . "`Address` varchar(100) NOT NULL,"
                     . "`Phone` varchar(25) NOT NULL,"
                     . "`subject` varchar(255) NOT NULL,"
                     . "`startdate` datetime NOT NULL,"
                     . "`Email` varchar(50) NOT NULL,"
                     . "`leadType` int(11) NOT NULL,"
                     . "`leadSource` int(11) NOT NULL,"
                     . "`enddate` datetime NOT NULL,"
                     . "`weightage` varchar(30) NOT NULL,"
                     . "`marksobtained` int(255) NOT NULL,"
                     . "`totalmarks` int(255) NOT NULL,"
                     . "`dateAdded` datetime NOT NULL,"
                     . "`dateModified` datetime NOT NULL,"
                     . "`lastModifiedBy` int(11) NOT NULL,"
                     . "`assignedTo` int(11) NOT NULL COMMENT 'Who owns the lead',"
                     . "`istatus` int(11) NOT NULL,"
                     . "`customField` varchar(255) NOT NULL,"
                     . "`customField2` varchar(255) NOT NULL,"
                     . "`customField3` varchar(255) NOT NULL,"
                     . "`customField4` varchar(255) NOT NULL,"
                     . "`customField5` varchar(255) NOT NULL,"
                     . "`customField6` varchar(255) NOT NULL,"
                     . "`customField7` varchar(255) NOT NULL,"
                     . "`customField8` varchar(255) NOT NULL,"
                     . "`customField9` varchar(255) NOT NULL,"
                     . "`customField10` varchar(255) NOT NULL,"
                     . "`customField11` varchar(255) NOT NULL,"
                     . "`customField12` varchar(255) NOT NULL,"
                     . "`customField13` varchar(255) NOT NULL,"
                     . "`customField14` varchar(255) NOT NULL,"
                     . "`customField15` varchar(255) NOT NULL,"
                     . "`customField16` varchar(255) NOT NULL,"
                     
                     . "`customField17` varchar(255) NOT NULL,"
                     . "`customField18` varchar(255) NOT NULL,"
                     . "`customField19` varchar(255) NOT NULL,"
                     . "`customField20` varchar(255) NOT NULL,"
                     . "`customField21` varchar(255) NOT NULL,"
                     . "`customField22` varchar(255) NOT NULL,"
                     . "`customField23` varchar(255) NOT NULL,"
                     . "`customField24` varchar(255) NOT NULL,"
                     . "`customField25` varchar(255) NOT NULL,"
                     . "`customField26` varchar(255) NOT NULL,"
                     . "`customField27` varchar(255) NOT NULL,"
                     . "`customField28` varchar(255) NOT NULL,"
                     . "`customField29` varchar(255) NOT NULL,"
                     . "`customField30` varchar(255) NOT NULL,"
                     . "`customField31` varchar(255) NOT NULL,"
                     . "`customField32` varchar(255) NOT NULL,"

                     . "`customField33` varchar(255) NOT NULL,"
                     . "`customField34` varchar(255) NOT NULL,"
                     . "`customField35` varchar(255) NOT NULL,"
                     . "`customField36` varchar(255) NOT NULL,"
                     . "`customField37` varchar(255) NOT NULL,"
                     . "`customField38` varchar(255) NOT NULL,"
                     . "`customField39` varchar(255) NOT NULL,"
                     . "`customField40` varchar(255) NOT NULL,"
                     . "`customField41` varchar(255) NOT NULL,"
                     . "`customField42` varchar(255) NOT NULL,"
                     . "`customField43` varchar(255) NOT NULL,"
                     . "`customField44` varchar(255) NOT NULL,"
                     . "`customField45` varchar(255) NOT NULL,"
                     . "`customField46` varchar(255) NOT NULL,"
                     . "`customField47` varchar(255) NOT NULL,"
                     . "`customField48` varchar(255) NOT NULL,"

                     . "`customField49` varchar(255) NOT NULL,"
                     . "`customField50` varchar(255) NOT NULL,"
                     . "`customField51` varchar(255) NOT NULL,"
                     . "`customField52` varchar(255) NOT NULL,"
                     . "`customField53` varchar(255) NOT NULL,"
                     . "`customField54` varchar(255) NOT NULL,"
                     . "`customField55` varchar(255) NOT NULL,"
                     . "`customField56` varchar(255) NOT NULL,"
                     . "`customField57` varchar(255) NOT NULL,"
                     . "`customField58` varchar(255) NOT NULL,"
                     . "`customField59` varchar(255) NOT NULL,"
                     . "`customField60` varchar(255) NOT NULL,"
                     . "`customField61` varchar(255) NOT NULL,"
                     . "`customField62` varchar(255) NOT NULL,"
                     . "`customField63` varchar(255) NOT NULL,"
                     . "`customField64` varchar(255) NOT NULL,"
                     . "`assign_teacher` int(11) NOT NULL,"

                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installContacts = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}contacts CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                // Add Custom Fields to table if needed
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField` varchar(255) NOT NULL after `lStatus`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField2` varchar(255) NOT NULL after `customField`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField3` varchar(255) NOT NULL after `customField2`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField4` varchar(255) NOT NULL after `customField3`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField5` varchar(255) NOT NULL after `customField4`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField6` varchar(255) NOT NULL after `customField5`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField7` varchar(255) NOT NULL after `customField6`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField8` varchar(255) NOT NULL after `customField7`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField9` varchar(255) NOT NULL after `customField8`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField10` varchar(255) NOT NULL after `customField9`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField11` varchar(255) NOT NULL after `customField10`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField12` varchar(255) NOT NULL after `customField11`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField13` varchar(255) NOT NULL after `customField12`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField14` varchar(255) NOT NULL after `customField13`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField15` varchar(255) NOT NULL after `customField14`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField16` varchar(255) NOT NULL after `customField15`";
                $db->extQuery($sql);

                
                
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField17` varchar(255) NOT NULL after `customField16`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField18` varchar(255) NOT NULL after `customField17`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField19` varchar(255) NOT NULL after `customField18`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField20` varchar(255) NOT NULL after `customField19`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField21` varchar(255) NOT NULL after `customField20`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField22` varchar(255) NOT NULL after `customField21`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField23` varchar(255) NOT NULL after `customField22`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField24` varchar(255) NOT NULL after `customField23`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField25` varchar(255) NOT NULL after `customField24`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField26` varchar(255) NOT NULL after `customField25`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField27` varchar(255) NOT NULL after `customField26`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField28` varchar(255) NOT NULL after `customField27`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField29` varchar(255) NOT NULL after `customField28`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField30` varchar(255) NOT NULL after `customField29`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField31` varchar(255) NOT NULL after `customField30`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField32` varchar(255) NOT NULL after `customField31`";
                $db->extQuery($sql);
                
                
                
                
                // Add Custom Fields to table if needed
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField33` varchar(255) NOT NULL after `customField32`";
                $db->extQuery($sql);


                $sql = "ALTER TABLE {$dbPre}contacts Add `customField34` varchar(255) NOT NULL after `customField33`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField35` varchar(255) NOT NULL after `customField34`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField36` varchar(255) NOT NULL after `customField35`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField37` varchar(255) NOT NULL after `customField36`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField38` varchar(255) NOT NULL after `customField37`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField39` varchar(255) NOT NULL after `customField38`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField40` varchar(255) NOT NULL after `customField39`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField41` varchar(255) NOT NULL after `customField40`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField42` varchar(255) NOT NULL after `customField41`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField43` varchar(255) NOT NULL after `customField42`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField44` varchar(255) NOT NULL after `customField43`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField45` varchar(255) NOT NULL after `customField44`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField46` varchar(255) NOT NULL after `customField45`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField47` varchar(255) NOT NULL after `customField46`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField48` varchar(255) NOT NULL after `customField47`";
                $db->extQuery($sql);
                
                 

                
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField49` varchar(255) NOT NULL after `customField48`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField50` varchar(255) NOT NULL after `customField49`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField51` varchar(255) NOT NULL after `customField50`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField52` varchar(255) NOT NULL after `customField51`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField53` varchar(255) NOT NULL after `customField52`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField54` varchar(255) NOT NULL after `customField53`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField55` varchar(255) NOT NULL after `customField54`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField56` varchar(255) NOT NULL after `customField55`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField57` varchar(255) NOT NULL after `customField56`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField58` varchar(255) NOT NULL after `customField57`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField59` varchar(255) NOT NULL after `customField58`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField60` varchar(255) NOT NULL after `customField59`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField61` varchar(255) NOT NULL after `customField60`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField62` varchar(255) NOT NULL after `customField61`";
                $db->extQuery($sql);

                $sql = "ALTER TABLE {$dbPre}contacts Add `customField63` varchar(255) NOT NULL after `customField62`";
                $db->extQuery($sql);
                $sql = "ALTER TABLE {$dbPre}contacts Add `customField64` varchar(255) NOT NULL after `customField63`";
                $db->extQuery($sql);
                

                

                $sql = "ALTER TABLE {$dbPre}contacts Add `assignedTo` int(11) NOT NULL after `lastModifiedBy`";
                $db->extQuery($sql);

                // lead Notes table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}leadNotes` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`leadID` int(11) NOT NULL,"
                     . "`Note` text NOT NULL,"
                     . "`creator` int(11) NOT NULL,"
                     . "`dateAdded` datetime NOT NULL,"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installNotes = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}leadNotes CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                // lead Source table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}leadSource` ("
                     . "`sourceID` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`sourceName` varchar(255) NOT NULL,"
                     . "`description` text NOT NULL,"
                     . "PRIMARY KEY (`sourceID`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

                $installSource = $db->extQuery($sql);
                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}leadSource CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                $sql = "select * from {$dbPre}leadSource where sourceName='None'";
                $exists = $db->extQueryRowObj($sql);
                if (!$exists) {
                    $vals = array (
                        'sourceName' => 'None',
                        'description' => 'None Category for empty matches.'
                    );
                    $noneSource = $db->insert("{$dbPre}leadSource", $vals);
                }

                // lead Status table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}leadStatus` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`statusName` varchar(255) NOT NULL,"
                     . "`description` varchar(255) NOT NULL,"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installStatus = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}leadStatus CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                $sql = "select * from {$dbPre}leadStatus where statusName='None'";
                $exists = $db->extQueryRowObj($sql);
                if (!$exists) {
                    $vals = array (
                        'statusName' => 'None',
                        'description' => 'Default Holder for empty matches.'
                    );
                    $noneStatus = $db->insert("{$dbPre}leadStatus", $vals);
                }

                // lead Type table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}leadType` ("
                     . "`typeID` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`typeName` varchar(255) NOT NULL,"
                     . "`description` text NOT NULL,"
                     . "PRIMARY KEY (`typeID`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installType = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}leadType CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                $sql = "select * from {$dbPre}leadType where typeName='None'";
                $exists = $db->extQueryRowObj($sql);
                if (!$exists) {
                    $vals = array (
                        'typeName' => 'None',
                        'description' => 'None Type for empty matches.'
                    );
                    $noneType = $db->insert("{$dbPre}leadType", $vals);
                }

                // logging table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}log` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`userFirst` varchar(255) NOT NULL,"
                     . "`userLast` varchar(255) NOT NULL,"
                     . "`event` varchar(255) NOT NULL,"
                     . "`detail` varchar(255) NOT NULL,"
                     . "`eventTime` datetime NOT NULL,"
                     . "`ipAddr` varchar(255) NOT NULL,"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

                $installLog = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}log CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                // Install other emails table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}otherEmails` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`email` varchar(255) NOT NULL,"
                     . "`contact` int(11) NOT NULL,"
                     . "`notes` text NOT NULL,"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installOtherEm = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}otherEmails CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                // users table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}users` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`userName` varchar(255) NOT NULL,"
                     . "`secret` varchar(80) NOT NULL,"
                     . "`email` varchar(255) NOT NULL,"
                     . "`created` datetime NOT NULL,"
                     . "`first` varchar(255) NOT NULL,"
                     . "`last` varchar(255) NOT NULL,"
                     . "`isAdmin` tinyint(4) NOT NULL COMMENT '1 = admin',"
                     . "`ownLeadsOnly` int(11) NOT NULL COMMENT 'users, if 1 can only manage their own',"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installUsers = $db->extQuery($sql);

                // add ownLeadsOnly if needed
                $sql = "ALTER TABLE {$dbPre}users Add `ownLeadsOnly` int(11) NOT NULL after `isAdmin`";
                $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}users CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);
            
                // default 'admin' 'admin' user and password check if it already exists first
                $sql = "select * from {$dbPre}users where userName='admin'";
                $exists = $db->extQueryRowObj($sql);
                if (!$exists) {
                    $dateAdded = date("Y-m-d H:i:s");
                    $vals = array (
                        'userName' => 'admin',
                        'secret'   => 'd033e22ae348aeb5660fc2140aec35850c4da997263294b28c3e477023dba725d8eb4c9d23719c93',
                        'email'    => 'yourEmail@yoursite.com',
                        'created'  => "$dateAdded",
                        'first'    => 'admin',
                        'last'     => 'admin',
                        'isAdmin'  => '1'
                    );
                    $adminID = $db->insert("{$dbPre}users", $vals);
                }

                // Drop the old site settting if it exists
                $sql = "DROP TABLE IF EXISTS `{$dbPre}siteSettings`;";
                $dropSettings = $db->extQuery($sql);

                // Site Settings table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}siteSettings` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`pageResults` int(11) NOT NULL COMMENT 'Results Per Page',"
                     . "`customField1` varchar(255) NOT NULL COMMENT 'Custom Field 1',"
                     . "`customField2` varchar(255) NOT NULL,"
                     . "`customField3` varchar(255) NOT NULL,"
                     . "`customField4` varchar(255) NOT NULL,"
                     . "`customField5` varchar(255) NOT NULL,"
                     . "`customField6` varchar(255) NOT NULL,"
                     . "`customField7` varchar(255) NOT NULL,"
                     . "`customField8` varchar(255) NOT NULL,"
                     . "`customField9` varchar(255) NOT NULL,"
                     . "`customField10` varchar(255) NOT NULL,"
                     . "`customField11` varchar(255) NOT NULL,"
                     . "`customField12` varchar(255) NOT NULL,"
                     . "`customField13` varchar(255) NOT NULL,"
                     . "`customField14` varchar(255) NOT NULL,"
                     . "`customField15` varchar(255) NOT NULL,"
                     . "`customField16` varchar(255) NOT NULL,"

                     
                     . "`customField17` varchar(255) NOT NULL,"
                     . "`customField18` varchar(255) NOT NULL,"
                     . "`customField19` varchar(255) NOT NULL,"
                     . "`customField20` varchar(255) NOT NULL,"
                     . "`customField21` varchar(255) NOT NULL,"
                     . "`customField22` varchar(255) NOT NULL,"
                     . "`customField23` varchar(255) NOT NULL,"
                     . "`customField24` varchar(255) NOT NULL,"
                     . "`customField25` varchar(255) NOT NULL,"
                     . "`customField26` varchar(255) NOT NULL,"
                     . "`customField27` varchar(255) NOT NULL,"
                     . "`customField28` varchar(255) NOT NULL,"
                     . "`customField29` varchar(255) NOT NULL,"
                     . "`customField30` varchar(255) NOT NULL,"
                     . "`customField31` varchar(255) NOT NULL,"

                     . "`customField32` varchar(255) NOT NULL,"
                     . "`customField33` varchar(255) NOT NULL,"
                     . "`customField34` varchar(255) NOT NULL,"
                     . "`customField35` varchar(255) NOT NULL,"
                     . "`customField36` varchar(255) NOT NULL,"
                     . "`customField37` varchar(255) NOT NULL,"
                     . "`customField38` varchar(255) NOT NULL,"
                     . "`customField39` varchar(255) NOT NULL,"
                     . "`customField40` varchar(255) NOT NULL,"
                     . "`customField41` varchar(255) NOT NULL,"
                     . "`customField42` varchar(255) NOT NULL,"
                     . "`customField43` varchar(255) NOT NULL,"
                     . "`customField44` varchar(255) NOT NULL,"
                     . "`customField45` varchar(255) NOT NULL,"
                     . "`customField46` varchar(255) NOT NULL,"

                     . "`customField47` varchar(255) NOT NULL,"
                     . "`customField48` varchar(255) NOT NULL,"
                     . "`customField49` varchar(255) NOT NULL,"
                     . "`customField50` varchar(255) NOT NULL,"
                     . "`customField51` varchar(255) NOT NULL,"
                     . "`customField52` varchar(255) NOT NULL,"
                     . "`customField53` varchar(255) NOT NULL,"
                     . "`customField54` varchar(255) NOT NULL,"
                     . "`customField55` varchar(255) NOT NULL,"
                     . "`customField56` varchar(255) NOT NULL,"
                     . "`customField57` varchar(255) NOT NULL,"
                     . "`customField58` varchar(255) NOT NULL,"
                     . "`customField59` varchar(255) NOT NULL,"
                     . "`customField60` varchar(255) NOT NULL,"
                     . "`customField61` varchar(255) NOT NULL,"
                     . "`customField62` varchar(255) NOT NULL,"
                     . "`customField63` varchar(255) NOT NULL,"
                     . "`customField64` varchar(255) NOT NULL,"

                     
                     . "`Address` varchar(255) NOT NULL,"
                     . "`enddate` varchar(255) NOT NULL,"
                     . "`weightage` varchar(30) NOT NULL,"
                     . "`marksobtained` varchar(255) NOT NULL,"
                     . "`totalmarks` varchar(255) NOT NULL,"
                     . "`Phone` varchar(255) NOT NULL,"
                     . "`subject` varchar(255) NOT NULL,"
                     . "`startdate` varchar(255) NOT NULL,"
                     . "`assignedTo` varchar(255) NOT NULL COMMENT 'Who owns the lead',"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

                $installSettings = $db->extQuery($sql);

                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}siteSettings CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                $sql = "select * from {$dbPre}siteSettings";
                $exists = $db->extQueryRowObj($sql);
                if (!$exists) {
                    $vals = array (
                        'pageResults' => 20,
                        'customField1' => 'Extra1',
                        'customField2' => 'Extra2',
                        'customField3' => 'Extra3',
                        'customField4' => 'Extra4',
                        'customField5' => 'Extra5',
                        'customField6' => 'Extra6',
                        'customField7' => 'Extra7',
                        'customField8' => 'Extra8',
                        'customField9' => 'Extra9',
                        'customField10' => 'Extra10',
                        'customField11' => 'Extra11',
                        'customField12' => 'Extra12',
                        'customField13' => 'Extra13',
                        'customField14' => 'Extra14',
                        'customField15' => 'Extra15',
                        'customField16' => 'Extra16',

                        
                        'customField17' => 'Extra17',
                        'customField18' => 'Extra18',
                        'customField19' => 'Extra19',
                        'customField20' => 'Extra20',
                        'customField21' => 'Extra21',
                        'customField22' => 'Extra22',
                        'customField23' => 'Extra23',
                        'customField24' => 'Extra24',
                        'customField25' => 'Extra25',
                        'customField26' => 'Extra26',
                        'customField27' => 'Extra27',
                        'customField28' => 'Extra28',
                        'customField29' => 'Extra29',
                        'customField30' => 'Extra30',
                        'customField31' => 'Extra31',
                        'customField32' => 'Extra32',

                        'customField33' => 'Extra33',
                        'customField34' => 'Extra34',
                        'customField35' => 'Extra35',
                        'customField36' => 'Extra36',
                        'customField37' => 'Extra37',
                        'customField38' => 'Extra38',
                        'customField39' => 'Extra39',
                        'customField40' => 'Extra40',
                        'customField41' => 'Extra41',
                        'customField42' => 'Extra42',
                        'customField43' => 'Extra43',
                        'customField44' => 'Extra44',
                        'customField45' => 'Extra45',
                        'customField46' => 'Extra46',
                        'customField47' => 'Extra47',
                        'customField48' => 'Extra48',

                        'customField49' => 'Extra49',
                        'customField50' => 'Extra50',
                        'customField51' => 'Extra51',
                        'customField52' => 'Extra52',
                        'customField53' => 'Extra53',
                        'customField54' => 'Extra54',
                        'customField55' => 'Extra55',
                        'customField56' => 'Extra56',
                        'customField57' => 'Extra57',
                        'customField58' => 'Extra58',
                        'customField59' => 'Extra59',
                        'customField60' => 'Extra60',
                        'customField61' => 'Extra61',
                        'customField62' => 'Extra62',
                        'customField63' => 'Extra63',
                        'customField64' => 'Extra64',

                        'Address' => 'Address',
                        'enddate' => 'enddate',
                        'weightage' => 'weightage',
                        'marksobtained' => 'marksobtained',
                        'totalmarks' => 'totalmarks',
                        'Phone' => 'Phone',
                        'subject' => 'subject',
                        'startdate' => 'startdate',
                        'assignedTo' => 'Owner'
                    );
                    $settingsID = $db->insert("{$dbPre}siteSettings", $vals);
                }
            
                // drop Sort table if exists
                $sql = "DROP TABLE IF EXISTS `{$dbPre}sortOrder`;";
                $dropSort = $db->extQuery($sql);

                // Sort Order table
                $sql = "CREATE TABLE IF NOT EXISTS `{$dbPre}sortOrder` ("
                     . "`id` int(11) NOT NULL AUTO_INCREMENT,"
                     . "`setName` varchar(255) NOT NULL,"
                     . "`columnName` varchar(255) NOT NULL,"
                     . "`orderSet` int(11) NOT NULL,"
                     . "`used` int(11) NOT NULL COMMENT 'Used or Not',"
                     . "PRIMARY KEY (`id`)"
                     . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
                $installSort = $db->extQuery($sql);


                // alter and convert to utf-8 for other language support
                $sql = "ALTER TABLE {$dbPre}sortOrder CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
                $convert = $db->extQuery($sql);

                $sql = "select * from {$dbPre}sortOrder";
                $exists = $db->extQueryRowObj($sql);
                if (!$exists) {
                    $sql = "INSERT INTO `{$dbPre}sortOrder` (`id`, `setName`, `columnName`, `orderSet`, `used`) VALUES"
                         . "(1, 'Name', 'lastName', 1, 1),"
                         . "(2, 'Address', 'Address', 4, 1),"
                         . "(3, 'Phone', 'Phone', 2, 1),"
                         . "(4, 'Primary Email', 'Email', 3, 1),"
                         . "(5, 'Source', 'sourceName', 6, 0),"
                         . "(6, 'Type', 'typeName', 7, 1),"
                         . "(7, 'subject', 'subject', 9, 1),"
                         . "(8, 'start date', 'startdate', 8, 1),"
                         . "(9, 'end date', 'enddate', 12, 1),"
                         . "(10, 'weightage', 'weightage', 14, 1),"
                         . "(11, 'marks obtained', 'marksobtained', 13, 1),"
                         . "(12, 'total marks', 'totalmarks', 5, 1),"
                         . "(13, 'Date Added', 'dateAdded', 11, 0),"
                         . "(14, 'customField', 'customField', 10, 0),"
                         . "(15, 'customField2', 'customField2', 15, 0),"
                         . "(16, 'customField3', 'customField3', 16, 0),"
                         . "(17, 'customField4', 'customField4', 15, 0),"
                         . "(18, 'customField5', 'customField5', 15, 0),"
                         . "(19, 'customField6', 'customField6', 16, 0),"
                         . "(20, 'customField7', 'customField7', 15, 0),"
                         . "(21, 'customField8', 'customField8', 15, 0),"
                         . "(22, 'customField9', 'customField9', 16, 0),"
                         . "(23, 'customField10', 'customField10', 15, 0),"
                         . "(24, 'customField11', 'customField11', 15, 0),"
                         . "(25, 'customField12', 'customField12', 16, 0),"
                         . "(26, 'customField13', 'customField13', 15, 0),"
                         . "(27, 'customField14', 'customField14', 15, 0),"
                         . "(28, 'customField15', 'customField15', 16, 0),"
                         . "(29, 'customField16', 'customField16', 16, 0),"
                         . "(30, 'Owner', 'assignedTo', 17, 0),"

                         
                         . "(32, 'customField17', 'customField17', 32, 0),"
                         . "(33, 'customField18', 'customField18', 33, 0),"
                         . "(34, 'customField19', 'customField19', 34, 0),"
                         . "(35, 'customField20', 'customField20', 35, 0),"
                         . "(36, 'customField21', 'customField21', 36, 0),"
                         . "(37, 'customField22', 'customField22', 37, 0),"
                         . "(38, 'customField23', 'customField23', 38, 0),"
                         . "(39, 'customField24', 'customField24', 39, 0),"
                         . "(40, 'customField25', 'customField25', 40, 0),"
                         . "(41, 'customField26', 'customField26', 41, 0),"
                         . "(42, 'customField27', 'customField27', 42, 0),"
                         . "(43, 'customField28', 'customField28', 43, 0),"
                         . "(44, 'customField29', 'customField29', 44, 0),"
                         . "(45, 'customField30', 'customField30', 45, 0),"
                         . "(46, 'customField31', 'customField31', 46, 0),"
                         . "(47, 'customField32', 'customField32', 47, 0),"


                         . "(48, 'customField33', 'customField33', 48, 0),"
                         . "(49, 'customField34', 'customField34', 49, 0),"
                         . "(50, 'customField35', 'customField35', 50, 0),"
                         . "(51, 'customField36', 'customField36', 51, 0),"
                         . "(52, 'customField37', 'customField37', 52, 0),"
                         . "(53, 'customField38', 'customField38', 53, 0),"
                         . "(54, 'customField39', 'customField39', 54, 0),"
                         . "(55, 'customField40', 'customField40', 55, 0),"
                         . "(56, 'customField41', 'customField41', 56, 0),"
                         . "(57, 'customField42', 'customField42', 57, 0),"
                         . "(58, 'customField43', 'customField43', 58, 0),"
                         . "(59, 'customField44', 'customField44', 59, 0),"
                         . "(60, 'customField45', 'customField45', 60, 0),"
                         . "(61, 'customField46', 'customField46', 61, 0),"
                         . "(62, 'customField47', 'customField47', 62, 0),"
                         . "(63, 'customField48', 'customField48', 63, 0),"

                         . "(64, 'customField49', 'customField49', 64, 0),"
                         . "(65, 'customField50', 'customField50', 65, 0),"
                         . "(66, 'customField51', 'customField51', 66, 0),"
                         . "(67, 'customField52', 'customField52', 67, 0),"
                         . "(68, 'customField53', 'customField53', 68, 0),"
                         . "(69, 'customField54', 'customField54', 69, 0),"
                         . "(70, 'customField55', 'customField55', 70, 0),"
                         . "(71, 'customField56', 'customField56', 71, 0),"
                         . "(72, 'customField57', 'customField57', 72, 0),"
                         . "(73, 'customField58', 'customField58', 73, 0),"
                         . "(74, 'customField59', 'customField59', 74, 0),"
                         . "(75, 'customField60', 'customField60', 75, 0),"
                         . "(76, 'customField61', 'customField61', 76, 0),"
                         . "(77, 'customField62', 'customField62', 77, 0),"
                         . "(78, 'customField63', 'customField63', 78, 0),"
                         . "(79, 'customField64', 'customField64', 79, 0),"
                         . "(80, 'Teacher Assigned', 'assign_teacher', 80, 1),"
                         . "(81, 'Lead Stage', 'istatus', 81, 1);";
                         
                        


                    $sortInstall = $db->extQuery($sql);
                }

                // Update '0' assignedTo Leads to admin user, since they need to be assigned to someone
                $where = array (
                    'userName' => 'admin'
                );
                $admin = $db->get_value("{$dbPre}users", 'id', $where);

                $sql = "select * from {$dbPre}contacts";
                $contactMv = $db->extQuery($sql);
                foreach ($contactMv as $row => $val) {
                    if ($val->assignedTo == '0') {
                        $sql = "update {$dbPre}contacts set assignedTo='$admin' where id='$val->id'";
                        $db->extQuery($sql);
                    }
                }
                // End update assignedTo


                $configFile = createConfig($host, $database, $dbUser, $dbPassword, $dbPre);
                @$perms = chmod(dirname(__FILE__) . "/../classes", 0777);         // Attempt to make writable
                $file = dirname(__FILE__) . "/../classes/variables.php";
                @$makeFile = file_put_contents($file, $configFile, LOCK_EX);
                $jsonData['file'] = $file;
                $jsonData['error'] = 0;
                $jsonData['msg'] = "Complete...If there was a problem writing the file, download and copy variables.php"
                                 . " in the classes directory with the following link...<br />\n\r";

                
            } 
            echo json_encode($jsonData);
            break;

        case 'returnConfig':                       // just output config as download file
            $host       = $post['hostName'];
            $database   = $post['database'];
            $dbUser     = $post['dbUser'];
            $dbPassword = $post['dbPassword'];
            $dbPre      = $post['dbPre'];

            $configFile = createConfig($host, $database, $dbUser, $dbPassword, $dbPre);

            header("Cache-Control: ");
            header("Content-type: text/plain");
            header('Content-Disposition: attachment; filename="variables.php"');
            echo $configFile;
            break;


        default:
            $jsonData = array(
                'result' => 0,
                'text' => 'Unknown Method'
            );
            echo json_encode($jsonData);
    }
} else {
    echo "Nice try.";
}

/* Function to create the configuration file variables.php */
function createConfig($host, $database, $dbUser, $dbPassword, $dbPre) {   
    $configFile = <<<EOT
<?php\r
/**\r
 * Variables / Config File for the leads and contacts management tool\r
 * Filename: variables.php \r
 * Make sure it is located in classes directory\r
 *                                          lb 04-25-2013\r
**/\r
\$DB = array();\r
\$DB["host"]   = '$host';\r
\$DB["user"]   = '$dbUser';\r
\$DB["pass"]   = '$dbPassword';\r
\$DB["dbName"] = '$database';\r
\r
\$dbPre = '$dbPre';   // table prefix in database\r
\r
// Other Constants\r
define('SALT', sha1('SomeRandomPhraseThatShouldntChange')); // Password login salt,\r
                                                            // changing this value will cause all of your passwords to be invalid.
EOT;
    return $configFile;
}
