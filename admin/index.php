
<head>
<title>TCS - Leads</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>
<?php
/**
  * This is the header file for the LCM. 
  *
**/require_once 'header.php';

require_once 'classes/paging.php';
?>
<body>

 
<?php
require_once 'classes/paging.php';

// If the user can only access their own leads
$ownLeadsQ = '';
$ownLeadsQS = '';
$ownLeads = false;
if ($access == 2) { // user
    if ($_SESSION['ownLeadsOnly'] == 1) { //own Leads
        $ownLeadsQS = " and assignedTo='{$_SESSION['userID']}'";
        $ownLeadsQ = " and c.assignedTo='{$_SESSION['userID']}'";
        $ownLeads = true;
    }
}

// Advanced Search
$advSearch = false;
$advCheck = '';
if (isset($_GET['advSearch']) && $_GET['advSearch'] == 'true') {
    if (isset($_POST['firstNameStr'])) {
        // Clean and convert post vars for html
        foreach ($_POST as $key => $value) {
            $key = trim(htmlentities($key, ENT_QUOTES, "UTF-8"));
            $value = trim(htmlentities($value, ENT_QUOTES, "UTF-8"));  // prior to 5.4 default is iso-8859-1
            $post[$key] = $value;
        }
		if (isset($post['leadOwner']) && $post['leadOwner'] != '') {
			$ownerString = " and c.assignedTo='{$post['leadOwner']}'";
		} else {
			$ownerString = " and c.assignedTo LIKE '%{$post['leadOwner']}%'";
		}
        $searchString = " and c.firstName LIKE '%{$post['firstNameStr']}%' and c.lastName LIKE '%{$post['lastNameStr']}%'"
                  . " and c.Address LIKE '%{$post['addressStr']}%' and c.enddate LIKE '%{$post['cityStr']}%'"
                  . " and c.weightage LIKE '%{$post['stateStr']}%' and c.Country LIKE '%{$post['countryStr']}%'"
                  . " and c.totalmarks LIKE '%{$post['zipStr']}%' and c.Phone LIKE '%{$post['phoneStr']}%'"
                  . " and c.subject LIKE '%{$post['secondaryphoneStr']}%' and c.startdate LIKE '%{$post['faxStr']}%'"
                  . " and c.customField LIKE '%{$post['customStr']}%' and c.customField2 LIKE '%{$post['custom2Str']}%'"
                  . " and c.customField3 LIKE '%{$post['custom3Str']}%' and c.dateAdded LIKE '%{$post['dateAddedStr']}%'"
                  . " and c.leadSource LIKE '%{$post['leadSource']}%' and c.leadType LIKE '%{$post['leadType']}%'"
                  //. " and c.assignedTo LIKE '%{$post['leadOwner']}%'"
				  . $ownerString
                  . " and c.Email LIKE '%{$post['emailStr']}%' $ownLeadsQ";

    } elseif (isset($_SESSION['advSearchRet']) && $_SESSION['advSearchRet'] == true) {
        $searchString = $_SESSION['searchString'];
    }
    $advSearch = true;
    $searchVal = '';
    $searchCol = '';
    $secondaryEmails = false;
    $advCheck = 'checked="checked"';

// Normal Search
} elseif ( isset($_GET['search'])
    && $_GET['search'] != '') {
    if ($_GET['searchCol'] == 'secondaryEmails') {          // Secondary Emails
        $searchVal = trim(htmlentities($_GET['search'], ENT_QUOTES, "UTF-8"));
        $searchCol = trim(htmlentities($_GET['searchCol'], ENT_QUOTES, "UTF-8"));
        $secondaryEmails = true;

    } elseif ($_GET['searchCol'] == 'leadSource'            // Cannot do like clauses on ids, get extra matches
        || $_GET['searchCol'] == 'leadType'
		|| $_GET['searchCol'] == 'assignedTo' ) {
        $searchCol = trim(htmlentities($_GET['searchCol'], ENT_QUOTES, "UTF-8"));
        $searchVal = trim(htmlentities($_GET['search'], ENT_QUOTES, "UTF-8"));
        $search = "and c.$searchCol='$searchVal'";
        $searchCount = "and $searchCol='$searchVal'";
        $secondaryEmails = false;

    } else {
        $searchCol = trim(htmlentities($_GET['searchCol'], ENT_QUOTES, "UTF-8"));
        $searchVal = trim(htmlentities($_GET['search'], ENT_QUOTES, "UTF-8"));
        $search = "and c.$searchCol LIKE '%$searchVal%'";
        $searchCount = "and $searchCol LIKE '%$searchVal%'";
        $secondaryEmails = false;
    }
} else {
    $search = '';
    $searchCount = '';
    $searchCol = '';
    $searchVal = '';
    $secondaryEmails = false;
}


// get the page query into a session for returning
if ($advSearch == true) { // remove query for advanced search
    $_SESSION['leadsQ'] = 'advSearch=true';
    $_SESSION['searchString'] = $searchString;
    $_SESSION['advSearchRet'] = true;
} else {
    $_SESSION['leadsQ'] = $_SERVER['QUERY_STRING'];
    unset($_SESSION['advSearchRet']);
    unset($_SESSION['searchString']);
}

if ( isset($_GET['status']) && $_GET['status'] != '' ) {
    $statusSelect =intval($_GET['status']);
    $searchStatus = "and c.istatus='$statusSelect'";
    $statusCount = "and istatus='$statusSelect'";
} else {
    $statusSelect = '';
    $searchStatus = '';
    $statusCount = '';
}

// Pagination and sort queries
if ($secondaryEmails == true) {        // Searching Other emails
    $sql = "select count(*) as 'count' from {$dbPre}contacts c, {$dbPre}otherEmails oe"
         . " where oe.contact=c.id and oe.email like '%$searchVal%' $ownLeadsQ group by c.id";
    $tempT = $db->extQuery($sql);
    $clientC = count($tempT);

} elseif ($advSearch == true) {        // Advanced Search
     $sql = "select count(*) as 'count' from {$dbPre}contacts c where 1 $searchString";
   
   $totalC = $db->extQueryRowObj($sql);
    $clientC = $totalC->count;

} else {
    $sql = "select count(*) as 'count' from {$dbPre}contacts where 1 $searchCount $statusCount $ownLeadsQS";
     $totalC = $db->extQueryRowObj($sql);

    $clientC = $totalC->count;
}
// Get the results per page from siteSettings
$sql = "select * from {$dbPre}siteSettings";
$siteSettings = $db->extQueryRowObj($sql);
$rpp = $siteSettings->pageResults;

if ($advSearch == true) {   // Override for advanced search and send all to screen
    $rpp = $clientC;
}

if ( isset($_GET['sort']) && !empty($_GET['sort']) ) {
    $sort = trim(htmlspecialchars($_GET['sort']));
    if ($sort == 'Source') {        // convert source and type sort selections
        $sort = 'ls.sourceName';
    } elseif ( $sort == 'leadType') {
        $sort = 'lt.typeName';
    }
    $dir = trim(htmlspecialchars($_GET['dir']));
    if ($dir == 'asc') {
        $dirLink = 'desc';
        $arrow = '<img src="img/arrow-down.png" />';
    } else {
        $dirLink = 'asc';
        $arrow = '<img src="img/arrow-up.png" />';
    }
    $orderBy = "order by $sort $dir";
} else {
    $sort = '';
    $dir = '';
    $dirLink = 'asc';  // default
    $arrow = '';
    $orderBy = "order by lastName asc";
}
$reload = "index.php?status=$statusSelect&amp;sort=$sort&amp;dir=$dir&amp;search=$searchVal&amp;searchCol=$searchCol";
if (isset($_GET["pages"])) {
    $pages = intval($_GET["pages"]);
} else {
    $pages = 1;
}
$tpages = ($clientC) ? ceil($clientC/$rpp) : 1;
$adjacents = '3';
$startLimit = ($pages -1) * $rpp;
// End pagination work

// Main Queries
if ($secondaryEmails == true) {  // Searching Other Emails
    $sql = "select oe.email as 'second', c.*, ls.sourceName, lt.typeName, CONCAT(u.first, ' ', u.last) as 'Owner'"
         . " from {$dbPre}otherEmails oe, {$dbPre}contacts c, {$dbPre}leadSource ls, {$dbPre}leadType lt, {$dbPre}users u" 
         . " where oe.contact=c.id and oe.email like '%$searchVal%' and"
         . " c.leadSource=ls.sourceID and"
         . " c.leadType=lt.typeID and"
         . " c.assignedTo=u.id"
         . " $ownLeadsQ group by c.id $orderBy LIMIT $startLimit, $rpp";

} elseif ($advSearch == true) {  // Advanced Search
    $sql = "select c.*, ls.sourceName, lt.typeName, CONCAT(u.first, ' ', u.last) as 'Owner'"
         . " from {$dbPre}contacts c, {$dbPre}leadSource ls, {$dbPre}leadType lt, {$dbPre}users u"
         . " where c.leadSource=ls.sourceID and"
         . " c.leadType=lt.typeID and"
         . " c.assignedTo=u.id"
         . " $searchString $orderBy";

} else {
    $sql = "select c.*, ls.sourceName, lt.typeName, CONCAT(u.first, ' ', u.last) as 'Owner'"
         . " from {$dbPre}contacts c, {$dbPre}leadSource ls, {$dbPre}leadType lt, {$dbPre}users u"
         . " where c.leadSource=ls.sourceID and"
         . " c.leadType=lt.typeID and"
         . " c.assignedTo=u.id $search $searchStatus $ownLeadsQ"
         . " $orderBy LIMIT $startLimit, $rpp";
}

//filter search
/*
$filtertext='';
if ( isset($_GET['search'])
    && $_GET['search'] != '') {
if(isset($_GET['link'])){
   $link=$_GET['link'];
   if($link=='1')
   {
    $filtertext= trim(htmlentities($_GET['search'], ENT_QUOTES, "UTF-8"));
   }else{
   $filtertext='';
   }
}}
*/
$leads = $db->extQuery($sql);

$sql = "select * from {$dbPre}leadSource order by sourceName asc";
$leadSource = $db->extQuery($sql);
$sql = "select * from {$dbPre}leadType order by typeName asc";
$leadType = $db->extQuery($sql);
$sql = "select * from {$dbPre}leadStatus order by statusName asc";
$leadStatus = $db->extQuery($sql);
$sql = "select * from {$dbPre}sortOrder where used='1' order by orderSet asc";
$sortOrder = $db->extQuery($sql);

if ($ownLeads == true) {
    $sql = "select * from {$dbPre}users where id='{$_SESSION['userID']}'";
} else {
    $sql = "select * from {$dbPre}users order by last asc";
}
$Owners = $db->extQuery($sql);
?>

<script>
// globals
var token = "<?php echo $token; ?>";
var statusSelect = "<?php echo $statusSelect; ?>"; 
var access = "<?php echo $access; ?>";
var leadSources = {};
leadSources = ( <?php echo json_encode($leadSource);?> );

var leadTypes = {};
leadTypes = ( <?php echo json_encode($leadType);?> );

var leadStatuss = {};
leadStatuss = ( <?php echo json_encode($leadStatus);?> );

var Owners = {};
Owners = ( <?php echo json_encode($Owners);?> );

var siteSettings = {};
siteSettings = ( <?php echo json_encode($siteSettings);?> );

</script>


<div class="outer">
<?php
if($access!=3){
    ?>
  <div class="statusSelect" style="background-color:#3e4750">
  
  <div class="dropdown_list" style="margin-left:0px">
			<span class="dropdown" style="color:white;">Lead Status <i class="fa fa-angle-double-down" style="font-size:18px;margin-left:10px;"></i></span>
			
            <ul class="drop">
            <li><a <?php echo ($statusSelect == '') ? 'class="selected"' : '';?> href="index.php">All Status</a></li>
        <?php
        foreach ($leadStatus as $row => $leadStat) {
        if ($leadStat->id == $statusSelect) {
            $selected = 'class="selected"'; 
        } else { 
            $selected = '';
        }
         ?>
      <li>  
        <a href="index.php?status=<?php echo $leadStat->id;?>" <?php echo $selected; ?>><?php echo $leadStat->statusName;?></a>
      </li>
         <?php } ?> 
         
         
			</ul>

            


            
            
   </div>


   
  
  </div>

  <?php
}
?>

  
  <script type="text/javascript" src="js/leads.js"></script>
 
  <div class="leadsMenu">
  <?php
  if($access!=3){
      ?>
    <span class="leadsTitle">Leads </span> <span class="smallFont">(<?php echo $clientC; ?> Total)</span>
    <span class="addNewSpan">
      <?php 
      if ($access == 0) { // disable add new
          $disabled = ' disabled="disabled"';
      } else {
          $disabled = '';
      }
      ?>
      <button class="button smallButtons blueButton addEditContact" title="Add a new Lead." <?php echo $disabled;?>>
       <span class="centerImg"><img src="img/add.png" alt="Add" /></span>Add New
      </button>
    </span>
    <?php
    $sql = "select * from {$dbPre}siteSettings";
    $siteSettings = $db->extQueryRowObj($sql);
    ?>
     
    <!--import leads///-->
    <a class="button smallButtons blueButton" href="imp-exp-leads.php?page=import"><span class="centerImg"><img src="img/add.png" alt="Add" /></span><span>Import/Export</span></a>
      
   
    
    
         Results Per Page: 
         <input type="text" class="pageResults lnField" size="10" value="<?php echo $siteSettings->pageResults; ?>" />
         <button class="buttons blackButton savePageResults">Save</button>
    
    <!-- Search -->
    <span class="searchLeads">
      <?php 
      if($searchCol == 'leadType' || $searchCol == 'leadSource' || $searchCol == 'assignedTo') { 
          $hide = 'hidden';
          $text = '';
      } else {
          $hide = '';
          $text = $searchVal;
      }
      ?>
      Search For:  <input style="width:130px" type="text" class="searchText <?php echo $hide; ?>" value="<?php echo $text; ?>">
       
      <select class="leadSources <?php echo ($searchCol == 'leadSource') ? '': 'hidden'; ?>">
        <option value="">--Select--</option>
        <?php
        foreach ($leadSource as $row => $source) {
            if ($searchCol == 'leadSource'
               && $searchVal == $source->sourceID ) {
                $selectText = ' selected="selected"';
            } else {
                $selectText = '';
            }
        ?>
            <option value="<?php echo $source->sourceID;?>"<?php echo $selectText; ?>><?php echo $source->sourceName;?></option>
        <?php 
        }
        ?>
      </select>

      <select class="leadTypes <?php echo ($searchCol == 'leadType') ? '': 'hidden'; ?>">
        <option value="">--Select--</option>
        <?php  
        foreach ($leadType as $row => $type) {
            if ($searchCol == 'leadType'
               && $searchVal == $type->typeID ) {
                $selectText = ' selected="selected"';
            } else {
                $selectText = '';
            }
        ?>
            <option value="<?php echo $type->typeID;?>"<?php echo $selectText;?>><?php echo $type->typeName;?></option>
        <?php
        }
        ?>
      </select>

      <select class="Owners <?php echo ($searchCol == 'assignedTo') ? '': 'hidden'; ?>">
        <option value="">--Select--</option>
        <?php
        foreach ($Owners as $row => $own) {
            if ($searchCol == 'assignedTo'
               && $searchVal == $own->id ) {
                $selectText = ' selected="selected"';
            } else {
                $selectText = '';
            }
        ?>
            <option value="<?php echo $own->id;?>"<?php echo $selectText; ?>><?php echo $own->first . ' ' . $own->last?></option>
        <?php 
        }
        ?>
      </select>

        In:  
      <?php $selectText = 'selected="selected"'; ?>
      <select class="searchColumn">
        <option value="firstName" <?php echo ($searchCol == 'firstName') ? $selectText: ''; ?>>First Name</option>
        <option value="lastName" <?php echo ($searchCol == 'lastName') ? $selectText: ''; ?>>Last Name</option>
        <option value="Address" <?php echo ($searchCol == 'Address') ? $selectText: ''; ?>>
        <?php echo $siteSettings->Address; ?></option>
        <option value="enddate" <?php echo ($searchCol == 'enddate') ? $selectText: ''; ?>><?php echo $siteSettings->enddate; ?></option>
        <option value="weightage" <?php echo ($searchCol == 'weightage') ? $selectText: ''; ?>><?php echo $siteSettings->weightage; ?></option>
        <option value="marksobtained" <?php echo ($searchCol == 'marksobtained') ? $selectText: ''; ?>>
        <?php echo $siteSettings->marksobtained; ?></option>
        <option value="totalmarks" <?php echo ($searchCol == 'totalmarks') ? $selectText: ''; ?>><?php echo $siteSettings->totalmarks; ?></option>
        <option value="Phone" <?php echo ($searchCol == 'Phone') ? $selectText: ''; ?>><?php echo $siteSettings->Phone; ?></option>
        <option value="subject" <?php echo ($searchCol == 'subject') ? $selectText: ''; ?>>
        <?php echo $siteSettings->subject; ?></option>
        <option value="startdate" <?php echo ($searchCol == 'startdate') ? $selectText: ''; ?>><?php echo $siteSettings->startdate; ?></option>
        <option value="Email" <?php echo ($searchCol == 'Email') ? $selectText: ''; ?>>Primary Email</option>
        <option value="secondaryEmails" <?php echo ($searchCol == 'secondaryEmails') ? $selectText: ''; ?>>Secondary Email</option>
        <option value="leadSource" <?php echo ($searchCol == 'leadSource') ? $selectText: ''; ?>>Source</option>
        <option value="leadType" <?php echo ($searchCol == 'leadType') ? $selectText: ''; ?>>Type</option>
        <option value="dateAdded" <?php echo ($searchCol == 'dateAdded') ? $selectText: ''; ?>>Date Added</option>
        <option value="customField" <?php echo ($searchCol == 'customField') ? $selectText: ''; ?>>
         <?php echo $siteSettings->customField1; ?></option>
        <option value="customField2" <?php echo ($searchCol == 'customField2') ? $selectText: ''; ?>>
         <?php echo $siteSettings->customField2; ?></option>
        <option value="customField3" <?php echo ($searchCol == 'customField3') ? $selectText: ''; ?>>
         <?php echo $siteSettings->customField3; ?></option>
        <option value="assignedTo" <?php echo ($searchCol == 'assignedTo') ? $selectText: ''; ?>>
         <?php echo $siteSettings->assignedTo; ?></option>
      </select>
      <button class="goSearch smallButtons greenButton">Search</button>
      &nbsp;&nbsp;&nbsp;&nbsp;Advanced Search: <input type="checkbox" class="advSearch" <?php echo $advCheck;?>>
    </span>
    <?php
  }
  ?>
  </div>
  <?php
  $teacher_id=$_SESSION['userID'];;
if($access==3){
    $sql="select * from {$dbPre}contacts where  assign_teacher='$teacher_id'";
    $leads = $db->extQuery($sql);
?>


  <div class="allLeadsHolder">
  <table class="allLeads" id="table-id">
  <thead>
    <tr class="topRow">
<?php    
    $extra = "&amp;searchCol=$searchCol";
    if ($advSearch == true) {
        $extra .= "&amp;advSearch=true";
    }
    require_once 'classes/general.php';
    $GEN = new GEN();
    foreach ($sortOrder as $row => $field) {
        $printName = $GEN->nameField($field->setName, $siteSettings);
        if($printName=='Name'||$printName=='subject'||$printName=='start date'||$printName=='end date'||$printName=='Lead Stage'){
?>
      <th>
        <a id="filtercol" class="sort"><?php echo $printName; ?><?php echo ($sort == $field->columnName) ? $arrow : ''; ?></a>
      
  <div class="dropdown">
  <button class="dropbtn"><i class="fa fa-filter"></i></button>
  <div class="dropdown-content">
  <a  style="color:black;font-weight: normal " href="<?php echo "?status=$statusSelect&amp;sort=$field->columnName&amp;dir=$dirLink&amp;search=$searchVal" . $extra; ?>"
        class="sort">A to Z / Z to A<?php echo ($sort == $field->columnName) ? $arrow : ''; ?></a>
        <a style="color:black;font-weight: normal " href="index.php">Clear Filter</a>
        <div class="dropdown1">
  <button class="dropbtn1" style="background-color:#f1f1f1;color:black;color:black;font-weight: bold ">Text Filter <i class="fa fa-angle-double-down"></i></button>
  <div class="dropdown-content1">
  <input type="text" id="searchfilter" value="<?php echo $text;?>">
  <a  style="color:black;font-weight: normal"  class="equalfilter" href="">Equals</a>
        <a style="color:black;font-weight: normal " href="#">Begin with</a>
    <a  style="color:black;font-weight: normal " href="#">End with</a>
    <a  style="color:black;font-weight: normal " href="#">contains</a><br>
  </div>
</div><br><br>
<div style="border:1px solid grey;margin-left:10px;margin-right:10px">
<a ><input type="text" placeholder="Search"></a>
<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
<label for="vehicle1"> col val 1</label><br>
<input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
<label for="vehicle2"> col val 2</label><br>
<input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
<label for="vehicle3"> col val 3</label><br>
    </div><br>
  </div>
</div>
      </th>
<?php 
    }
else
{
    continue;
}
} 
?>

    </tr>
</thead>
  
  <tbody>   
<?php
 
$i = 0;
foreach ($leads as $row => $lead) {
    $i++;
    $trClass = 'trClass' . ($i & 1);
    echo "<tr class='$trClass'>";
    
    foreach ($sortOrder as $row => $field) {
        $printName = $GEN->nameField($field->setName, $siteSettings);
        $columnName = $field->columnName;
        if ($field->setName == 'Name') {
          //  if ($access != 0) { // All but read only
            if ($access == 1 || ($access==2 && $_SESSION['ownLeadsOnly']==0 )) { 
                $editDelete = "<a href='#' class='addEditContact exists lead$lead->id'><img src='img/table_edit.png'"
                   . "alt='Edit' title='Edit' /></a>&nbsp;&nbsp;"
                   . "<a href='#' class='deleteLead lead$lead->id'><img src='img/delete.png' alt='Delete' title='Delete' /></a>"
                   . "&nbsp;&nbsp;";
            } else if ($access == 2) {
                $editDelete = "<a href='#' class='addEditContact exists lead$lead->id'><img src='img/table_edit.png'"
                . "alt='Edit' title='Edit' /></a>&nbsp;&nbsp;";
            }
                else{
                $editDelete = '';
            }
            echo "<td>$editDelete"
               . "&nbsp;&nbsp;<a href='lead.php?lead=$lead->id' class='viewLead'"
               . " title='Go view this Contact'>$lead->firstName $lead->lastName</a>"
               . "</td>";
        }  
        else if ($printName =='start date') {
            echo "<td>" . html_entity_decode($lead->{"$columnName"}) . "</td>";
        }
        else if ($printName =='Lead Stage') {

            
            echo "<td> <button class='up-id exists lead$lead->id'>update</button> <select  class='status-id'> ";
            foreach($leadStatus as $row => $leadStat) { 
                 
                if($leadStat->id==(html_entity_decode($lead->{"$columnName"}))){
                     $selected='selected="selected"';
                 }
                 else{
                     $selected='';
                 }
               echo  "<option  class='status exists lead$leadStat->id'  value='$leadStat->id' $selected>";
                echo $leadStat->statusName;
                
                "</option></select> </td>";
                
            }
        } 
        else if ($printName =='subject') {
            echo "<td>" . html_entity_decode($lead->{"$columnName"}) . "</td>";
        }
        else if ($printName =='end date') {
            echo "<td>" . html_entity_decode($lead->{"$columnName"}) . "</td>";
        }
        else{
            continue;
        }
        
   }
   
}
echo "</tr>";
?>
<tbody>
  </table>
 
</div>

<?php
}else
{
    ?>
  <div class="allLeadsHolder">
  <table class="allLeads" id="table-id">
  <thead>
    <tr class="topRow">
<?php    
    $extra = "&amp;searchCol=$searchCol";
    if ($advSearch == true) {
        $extra .= "&amp;advSearch=true";
    }
    require_once 'classes/general.php';
    $GEN = new GEN();
    foreach ($sortOrder as $row => $field) {
        $printName = $GEN->nameField($field->setName, $siteSettings);
?>
      <th>
        <a id="filtercol" class="sort"><?php echo $printName; ?><?php echo ($sort == $field->columnName) ? $arrow : ''; ?></a>
      
  <div class="dropdown">
  <button class="dropbtn"><i class="fa fa-filter"></i></button>
  <div class="dropdown-content">
  <a  style="color:black;font-weight: normal " href="<?php echo "?status=$statusSelect&amp;sort=$field->columnName&amp;dir=$dirLink&amp;search=$searchVal" . $extra; ?>"
        class="sort">A to Z / Z to A<?php echo ($sort == $field->columnName) ? $arrow : ''; ?></a>
        <a style="color:black;font-weight: normal " href="index.php">Clear Filter</a>
        <div class="dropdown1">
  <button class="dropbtn1" style="background-color:#f1f1f1;color:black;color:black;font-weight: bold ">Text Filter <i class="fa fa-angle-double-down"></i></button>
  <div class="dropdown-content1">
  <input type="text" id="searchfilter" value="<?php echo $text;?>">
  <a  style="color:black;font-weight: normal"  class="equalfilter" href="">Equals</a>
        <a style="color:black;font-weight: normal " href="#">Begin with</a>
    <a  style="color:black;font-weight: normal " href="#">End with</a>
    <a  style="color:black;font-weight: normal " href="#">contains</a><br>
  </div>
</div><br><br>
<div style="border:1px solid grey;margin-left:10px;margin-right:10px">
<a ><input type="text" placeholder="Search"></a>
<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
<label for="vehicle1"> col val 1</label><br>
<input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
<label for="vehicle2"> col val 2</label><br>
<input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
<label for="vehicle3"> col val 3</label><br>
    </div><br>
  </div>
</div>
      </th>
<?php } ?>
<th  style="width:2px" >
<button href='#' class='assignLead'>Assign </button> <a>All<input value="ALL" type="checkbox" id="checkall" ></a>
</th>
<th  style="width:2px" >
<a href="" class=" col_setting" title="set your favourite column." <?php echo $disabled;?>>
<i class="fa fa-gear" style="font-size:20px"></i>
    </a>
</th>
    </tr>
</thead>
  
  <tbody>   
<?php
 
$i = 0;
foreach ($leads as $row => $lead) {
    $i++;
    $trClass = 'trClass' . ($i & 1);
    echo "<tr class='$trClass'>";
    
    foreach ($sortOrder as $row => $field) {
        $columnName = $field->columnName;
        if ($field->setName == 'Name') {
          //  if ($access != 0) { // All but read only
            if ($access == 1 || ($access==2 && $_SESSION['ownLeadsOnly']==0 )) { 
                $editDelete = "<a href='#' class='addEditContact exists lead$lead->id'><img src='img/table_edit.png'"
                   . "alt='Edit' title='Edit' /></a>&nbsp;&nbsp;"
                   . "<a href='#' class='deleteLead lead$lead->id'><img src='img/delete.png' alt='Delete' title='Delete' /></a>"
                   . "&nbsp;&nbsp;";
            } else if ($access == 2) {
                $editDelete = "<a href='#' class='addEditContact exists lead$lead->id'><img src='img/table_edit.png'"
                . "alt='Edit' title='Edit' /></a>&nbsp;&nbsp;";
            }
                else{
                $editDelete = '';
            }
            echo "<td>$editDelete"
               . "&nbsp;&nbsp;<a href='lead.php?lead=$lead->id' class='viewLead'"
               . " title='Go view this Contact'>$lead->firstName $lead->lastName</a>"
               . "</td>";
        } else if ($field->setName == 'Owner') {
            echo "<td>" . $lead->Owner . "</td>";
        } 
        else if ($field->setName == 'Teacher Assigned') {
            foreach ($Owners as $row => $own) {
                if((html_entity_decode($lead->{"$columnName"}))==$own->id){
            $ans=$own->first;
            break;
            }
            else{
                $ans="none";
                
                 
            }
             
        }
    
        echo "<td>" .$ans. "</td>";
     }
        else if ($field->setName =='Lead Stage') {

            
            echo "<td>  <select  class='status-id'> ";
            foreach($leadStatus as $row => $leadStat) { 
                 
                if($leadStat->id==(html_entity_decode($lead->{"$columnName"}))){
                     $selected='selected="selected"';
                 }
                 else{
                     $selected='';
                 }
               echo  "<option  class='status exists lead$leadStat->id'  value='$leadStat->id' $selected>";
                echo $leadStat->statusName;
                
                "</option></select> </td>";
                
            }
        } 
        else {
            echo "<td>" . html_entity_decode($lead->{"$columnName"}) . "</td>";
        }
        
   }
   echo '<td><input type="checkbox"  value= '.$lead->id.'  name="assign-teacher" class="checkSingle" ></td>';
  
}
echo "</tr>";
?>
<tbody>
  </table>
 
</div>
<?php
}
?>
<br>
<!-- Pagination links -->
<div class="paginate">
    <?php 
    $paging = new paging($reload, $pages, $tpages, $adjacents);
    echo $paging->getDiv();
    ?>
    </div>
</div>
   
<div class="push"></div>
</div>




<?php
require_once 'footer.php';

/**
  * This is the main page for the LCM. 
  *
**/



$sql = "select * from {$dbPre}leadSource order by sourceName asc";
$leadSource = $db->extQuery($sql);
$sql = "select * from {$dbPre}leadType order by typeName asc";
$leadType = $db->extQuery($sql);
$sql = "select * from {$dbPre}leadStatus order by statusName asc";
$leadStatus = $db->extQuery($sql);
$sql = "select * from {$dbPre}users order by last asc";
$users = $db->extQuery($sql);
$sql = "select * from {$dbPre}siteSettings";
$siteSettings = $db->extQueryRowObj($sql);
$sql = "select * from {$dbPre}sortOrder order by orderSet";
$sortOrder = $db->extQuery($sql);
?>


<div id="mymodal" ><br>
<div class='colContainer'> 
<b>Columns Used:</b>
        <ul id="sortableCols" class="connectedSortable">
        <?php
        require_once 'classes/general.php';
        $GEN = new GEN();

        foreach ($sortOrder as $row => $field) {
            if ($field->used == 1) {
                $name = $GEN->nameField($field->setName, $siteSettings);
        ?>
          <li class="id<?php echo $field->id;?>"><?php echo $name; ?></li>
        <?php 
            } 
        }    
        ?>
        </ul>
        <br />
        <b>Columns Not Used:</b>
        <ul id="sortableCols2" class="connectedSortable">
        <?php
        foreach ($sortOrder as $row => $field) {
            if ($field->used == 0) {
                $name = $GEN->nameField($field->setName, $siteSettings);
        ?>
          <li class="id<?php echo $field->id;?>"><?php echo $name; ?></li>
        <?php 
            } 
        }    
        ?>
        </ul>
      
        <p class="buttonRow">  <button class="closeModal buttons blueButton">Cancel</button> &nbsp; <button class="buttons blueButton saveOrder">Save Order</button></p>
    </div>
</div> 


    <script type="text/javascript" src="js/col_order.js"></script>
<script>
var activeClass = "is-active"
var forEach = function (array, callback, scope) {
  for (var i = 0; i < array.length; i++) {
    callback.call(scope, i, array[i]); // passes back stuff we need from the array
  }
};
forEach(document.querySelectorAll(".dropdown_list span.dropdown"), function (index, value) {
  value.addEventListener('click', function() {
        //console.log(value.classList);
        if ( !value.classList.contains(activeClass) ) {
            var el = document.querySelectorAll(".dropdown_list span.dropdown");
            var i; for (i = 0; i < el.length; i++) {
                el[i].classList.remove(activeClass);
            }
            value.classList.toggle(activeClass);
        } else
        if ( value.classList.contains(activeClass) ) {
            value.classList.remove(activeClass);
        }
  })
});
document.addEventListener('click', function(e) {
  // Dropdown Select Toggle
  var el = document.querySelectorAll(".dropdown_list span.dropdown")
  var e=e? e : window.event;
    var event_element=e.target? e.target : e.srcElement;
  if (!event_element.closest(".dropdown_list")){
    //console.log(event_element.closest(".dropdown_list"));
    var i; for (i = 0; i < el.length; i++) {
      el[i].classList.remove(activeClass);
    }
  }
}, false);

$(document).on('click', '.col_setting', function(e) {
        e.preventDefault();
        $("#mymodal").css("display", "block");
            $('#mymodal').modal('show'); 
                
        $(content).modal({onOpen: function (dialog) {
            dialog.overlay.fadeIn('fast', function () {
                dialog.container.fadeIn('fast', function () {
                    dialog.data.fadeIn('fast');
                   
                });
            });
        }, minHeight:380});
        $(":input").each(function (i) { $(this).attr('tabindex', i + 1); });
        
        return false;
});




 
$("#checkall").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    
     
</script>
</body>

</html>

