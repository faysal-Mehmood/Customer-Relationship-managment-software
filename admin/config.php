<?php
/**
  * This is the main page for the LCM. 
  *
**/
require_once 'header.php';
if ($_SESSION['access'] != '1') {        // Only admins have access to config area
    header('Location: index.php');
}

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
<script>
    var token = "<?php echo $token; ?>";
    var page = "<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>";

    var siteSettings = {};
    siteSettings = ( <?php echo json_encode($siteSettings);?> );
</script>
<!-- Settings specific js file -->
<script type="text/javascript" src="js/config.js"></script>

<div class="outer">
  <div class="statusSelect">
    <ul>
      <li><a href="#" class="manageSource sections selected">Sources</a></li>
      <li><a href="#" class="manageType sections">Types</a></li>
      <li><a href="#" class="manageStatus sections">Status</a></li>
      <li><a href="#" class="manageUsers sections">Users</a></li>
      
      <li><a href="#" class="manageSite sections">Site Settings</a></li>
      <li><a href="#" class="emptyDatabase sections">Empty Database</a></li>
      <li><a href="#" class="showLogging sections">Activity Log</a></li>
    </ul>
  </div>

  <div class="sourceDisplay section">

    <div class="configLeft">
      <br />
      <h3 class="secTitle">Manage Your Lead Sources/teacher.</h3>
      <hr class="thinLine">
      <br /><br />
      <table class="configure">
      <?php 
      foreach ($leadSource as $row => $source) {
          if ($source->sourceName != 'None') {   // Do not display None group to edit
      ?>
        <tr class="entryItem <?php echo $source->sourceID;?>">
          <td>Name: </td>
          <td class="itemName">
            <input type="text" class="name lnField" size="50" value="<?php echo $source->sourceName; ?>" />
          </td>
          <td>Description:</td>
          <td class="notes"><input type="text" class="description lnDesc" value="<?php echo $source->description; ?>" />
          </td>
          <td><button class="smallButtons blueButton saveSource">Save</button>&nbsp;
              <button class="smallButtons redButton removeSource">Delete</button>
          </td>
        </tr>
          <?php } ?>
      <?php } ?>
      </table>
    </div>
    <div class="configRight">
      <br /><br /><br /><br />
      Add A New Source/teacher?
      <hr class="thinLine">
      <table class="addNewSource">
      <tr>
        <td>Name:</td><td><input type="text" class="newLeadSource lnField" /></td>
      </tr>
      <tr>
        <td>Description:</td><td><input type="text" class="newLeadDesc lnDesc" /></td>
      </tr>
      <tr>
        <td></td><td><button class="buttons yellowButton saveNewSource">Save</button></td>
      </tr>
      </table>
    </div>
  </div>

  <div class="typeDisplay section hidden">
    <div class="configLeft">
      <br />
      <h3 class="secTitle">Manage Your Lead Types.</h3>
      <hr class="thinLine">
      <br /><br />
      <table class="configureT">
    <?php 
    foreach ($leadType as $row => $type) {
        if ($type->typeName != 'None') {   // Do not display None group to edit
    ?>
        <tr class="entryItem <?php echo $type->typeID;?>">
          <td>Name: </td>
          <td class="itemName">
            <input type="text" class="name lnField" size="50" value="<?php echo $type->typeName; ?>" />
          </td>
          <td>Description:</td>
          <td class="notes"><input type="text" class="description lnDesc" value="<?php echo $type->description; ?>" />
          </td>
          <td><button class="smallButtons blueButton saveType">Save</button>&nbsp;
              <button class="smallButtons redButton removeType">Delete</button>
          </td>
        </tr>
          <?php } ?>
      <?php } ?>
      </table>
    </div>
    <div class="configRight">
      <br /><br /><br /><br />
      Add A New Type? 
      <hr class="thinLine">
      <table class="addNewType">
      <tr>
        <td>Name:</td>
        <td><input type="text" class="newLeadType lnField" /></td>
      </tr>
      <tr>
        <td>Description:</td><td><input type="text" class="newLeadDesc lnDesc" /></td>
      </tr>
      <tr>
        <td></td><td><button class="buttons yellowButton saveNewType">Save</button></td>
      </tr>
      </table>
    </div>

  </div>

  <div class="statusDisplay section hidden">

    <div class="configLeft">
      <br />
      <h3 class="secTitle">Manage Your Lead Status.</h3>
      <hr class="thinLine">
      <br /><br />
      <table class="configureS">
    <?php
    foreach ($leadStatus as $row => $status) {
        if ($status->statusName != 'None') {   // Do not display None group to edit
    ?>
        <tr class="entryItem <?php echo $status->id;?>">
          <td>Name: </td>
          <td class="itemName">
            <input type="text" class="name lnField" size="50" value="<?php echo $status->statusName; ?>" />
          </td>
          <td>Description:</td>
          <td class="notes"><input type="text" class="description lnDesc" value="<?php echo $status->description; ?>" />
          </td>
          <td><button class="smallButtons blueButton saveStatus">Save</button>&nbsp;
              <button class="smallButtons redButton removeStatus">Delete</button>
          </td>
        </tr>
          <?php } ?>
      <?php } ?>
      </table>
    </div>
    <div class="configRight">
      <br /><br /><br /><br />
      Add A New Status?
      <hr class="thinLine">
      <table class="addNewStatus">
      <tr>
        <td>Name:</td>
        <td><input type="text" class="newLeadStatus lnField" /></td>
      </tr>
      <tr>
        <td>Description:</td><td><input type="text" class="newLeadDesc lnDesc" /></td>
      </tr>
      <tr>
        <td></td><td><button class="buttons yellowButton saveNewStatus">Save</button></td>
      </tr>
      </table>
    </div>
  </div>

  <div class="usersDisplay section hidden">
    <div class="configLeft">
      <br />
      <h3 class="secTitle">Manage Users.</h3>
      <hr class="thinLine">
      <br /><br />
      <table class="currentUsers">
      <tr><th></th><th>User</th><th>User Name</th><th>Email</th><th>Created</th><th>Role</th><th>Edit</th></tr>
        <?php
        $i = 0;
        foreach ($users as $row => $user) {
            $created = strtotime($user->created);
            $created = date('m-d-Y h:m:s', $created);
            if ($user->isAdmin == '1') {
                $adminUser = 'Admin';
            } elseif ($user->isAdmin =='2') {
                $adminUser = 'Manager';
            } elseif ($user->isAdmin == '0') {
                $adminUser = 'Student';
            }
            elseif ($user->isAdmin == '3') {
              $adminUser = 'Teacher';
          }
            if ($adminUser == 'User' && $user->ownLeadsOnly == 1) { // User manages only their own leads
                $ownLeads = 'ownLeads';
            } else {
                $ownLeads = '';
            }
            $i++;
        ?>
        <tr>
          <td><?php echo $i;?>).
          <td><?php echo $user->first . ' ' . $user->last;?></td>
          <td><?php echo $user->userName;?></td>
          <td><?php echo $user->email;?></td>
          <td><?php echo $created; ?></td>
          <td class="<?php echo $ownLeads;?>"><?php echo $adminUser; ?></td>
          <td>
          <?php
              if ($_SESSION['firstName'] == 'Demo') {
                  $disabled = 'disabled="disabled"';
                  $message = '<p style="color: #569a46; font-weight: bold;">User Functions have been disabled in Demo mode.</p>';
              } else {
                  $disabled = '';
                  $message = '';
              }
            ?>
            <button class="smallButtons blackButton changeAccount <?php echo $user->id;?>" <?php echo $disabled;?>>Update</button>&nbsp;
            <button class="smallButtons redButton removeUser <?php echo $user->id;?>" <?php echo $disabled;?>>Delete</button>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

    <div class="configRight">
      <br /><br /><br /><br />
      <table class="addNewUser">
      <tr class="addUser">
        <td><button class="buttons yellowButton addNewUser" <?php echo $disabled;?>>Add A New User</button></td>
      </tr>
      </table>
      <?php echo $message;?>
    </div>

  </div>
  <div class="siteDisplay section hidden">

    <div class="configLeft">
      <br />
      <h3 class="secTitle">Manage Your Site Settings.</h3>
      <hr class="thinLine">
      <br /><br />
      
      <h3 class="secTitle">1.) Pagination</h3> 
      <p>Choose how many results to display per page on sections of the site that are paginated. </p>
      <p class="pageResultsP">
         Results Per Page: 
         <input type="text" class="pageResults lnField" size="10" value="<?php echo $siteSettings->pageResults; ?>" />
         <button class="buttons blackButton savePageResults">Save</button>
      </p>
      <hr class="thinLine">
      <br />
      <h3 class="secTitle">2.) Name your Fields</h3>
      <p>Customize your leads and change the name of the following fields to your liking, including the 3 extra (custom) fields.</p>
      <table class="fieldNames">
        <tr>
          <td class="addresstd">
            <span class="fieldNameC">Address:</span>
            <input type="text" class="Address lnField" size="12" value="<?php echo $siteSettings->Address; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="citytd">
            <span class="fieldNameC">End date:</span>
            <input type="text" class="City lnField" size="12" value="<?php echo $siteSettings->enddate; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="statetd">
            <span class="fieldNameC">weightage:</span>
            <input type="text" class="State lnField" size="12" value="<?php echo $siteSettings->weightage; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="countrytd">
            <span class="fieldNameC">Marks obtained:</span>
            <input type="text" class="Country lnField" size="12" value="<?php echo $siteSettings->marksobtained; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
        </tr>
        <tr>
         
          <td class="ziptd">
            <span class="fieldNameC">Total marks:</span>
            <input type="text" class="Zip lnField" size="12" value="<?php echo $siteSettings->totalmarks; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="phonetd">
            <span class="fieldNameC">Phone:</span>
            <input type="text" class="Phone lnField" size="12" value="<?php echo $siteSettings->Phone; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="secondaryPtd">
            <span class="fieldNameC">Subject:</span>
            <input type="text" class="secondaryPhone lnField" size="12" value="<?php echo $siteSettings->subject; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="faxtd">
            <span class="fieldNameC">Start date:</span>
            <input type="text" class="Fax lnField" size="12" value="<?php echo $siteSettings->startdate; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
           
        </tr>
        
            
       <tr> <td><span class="fieldNameC"><h4 >Extra Fields</h4>  </span></td></tr>
        <tr>
        
          <td class="customFieldP">
        
            <span class="fieldNameC">Extra1:</span>
            <input type="text" class="customField1 lnField" size="12" value="<?php echo $siteSettings->customField1; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="customField2td">
            <span class="fieldNameC">Extra2:</span>
            <input type="text" class="customField2 lnField" size="12" value="<?php echo $siteSettings->customField2; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="customField3td">
            <span class="fieldNameC">Extra3:</span>
            <input type="text" class="customField3 lnField" size="12" value="<?php echo $siteSettings->customField3; ?>" />
            <button class="buttons blackButton saveField">Save</button>
          </td>
          <td class="customField4td">
            <span class="fieldNameC">Extra4:</span>
            <input type="text" class="customField4 lnField" size="12" value="<?php echo $siteSettings->customField4; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
       
        <td class="customField5td">
            <span class="fieldNameC">Extra5:</span>
            <input type="text" class="customField5 lnField" size="12" value="<?php echo $siteSettings->customField5; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField6td">
            <span class="fieldNameC">Extra6:</span>
            <input type="text" class="customField6 lnField" size="12" value="<?php echo $siteSettings->customField6; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField7td">
            <span class="fieldNameC">Extra7:</span>
            <input type="text" class="customField7 lnField" size="12" value="<?php echo $siteSettings->customField7; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField8td">
            <span class="fieldNameC">Extra8:</span>
            <input type="text" class="customField8 lnField" size="12" value="<?php echo $siteSettings->customField8; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
       
        <td class="customField9td">
            <span class="fieldNameC">Extra9:</span>
            <input type="text" class="customField9 lnField" size="12" value="<?php echo $siteSettings->customField9; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField10td">
            <span class="fieldNameC">Extra10:</span>
            <input type="text" class="customField10 lnField" size="12" value="<?php echo $siteSettings->customField10; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField11td">
            <span class="fieldNameC">Extra11:</span>
            <input type="text" class="customField11 lnField" size="12" value="<?php echo $siteSettings->customField11; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField12td">
            <span class="fieldNameC">Extra12:</span>
            <input type="text" class="customField12 lnField" size="12" value="<?php echo $siteSettings->customField12; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        
        <tr>
        <td class="customField13td">
            <span class="fieldNameC">Extra13:</span>
            <input type="text" class="customField13 lnField" size="12" value="<?php echo $siteSettings->customField13; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField14td">
            <span class="fieldNameC">Extra14:</span>
            <input type="text" class="customField14 lnField" size="12" value="<?php echo $siteSettings->customField14; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField15td">
            <span class="fieldNameC">Extra15:</span>
            <input type="text" class="customField15 lnField" size="12" value="<?php echo $siteSettings->customField15; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField16td">
            <span class="fieldNameC">Extra16:</span>
            <input type="text" class="customField16 lnField" size="12" value="<?php echo $siteSettings->customField16; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>


        <tr>
        <td class="customField17td">
            <span class="fieldNameC">Extra17:</span>
            <input type="text" class="customField17 lnField" size="12" value="<?php echo $siteSettings->customField17; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField18td">
            <span class="fieldNameC">Extra18:</span>
            <input type="text" class="customField18 lnField" size="12" value="<?php echo $siteSettings->customField18; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField19td">
            <span class="fieldNameC">Extra19:</span>
            <input type="text" class="customField19 lnField" size="12" value="<?php echo $siteSettings->customField19; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField20td">
            <span class="fieldNameC">Extra20:</span>
            <input type="text" class="customField20 lnField" size="12" value="<?php echo $siteSettings->customField20; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>


        <tr>
        <td class="customField21td">
            <span class="fieldNameC">Extra21:</span>
            <input type="text" class="customField21 lnField" size="12" value="<?php echo $siteSettings->customField21; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField22td">
            <span class="fieldNameC">Extra22:</span>
            <input type="text" class="customField22 lnField" size="12" value="<?php echo $siteSettings->customField22; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField23td">
            <span class="fieldNameC">Extra23:</span>
            <input type="text" class="customField23 lnField" size="12" value="<?php echo $siteSettings->customField23; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField24td">
            <span class="fieldNameC">Extra24:</span>
            <input type="text" class="customField24 lnField" size="12" value="<?php echo $siteSettings->customField24; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
        <td class="customField25td">
            <span class="fieldNameC">Extra25:</span>
            <input type="text" class="customField25 lnField" size="12" value="<?php echo $siteSettings->customField25; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField26td">
            <span class="fieldNameC">Extra26:</span>
            <input type="text" class="customField14 lnField" size="12" value="<?php echo $siteSettings->customField26; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField27td">
            <span class="fieldNameC">Extra27:</span>
            <input type="text" class="customField15 lnField" size="12" value="<?php echo $siteSettings->customField27; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField28td">
            <span class="fieldNameC">Extra28:</span>
            <input type="text" class="customField28 lnField" size="12" value="<?php echo $siteSettings->customField28; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>

        <tr>
        <td class="customField29td">
            <span class="fieldNameC">Extra29:</span>
            <input type="text" class="customField29 lnField" size="12" value="<?php echo $siteSettings->customField29; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField30td">
            <span class="fieldNameC">Extra30:</span>
            <input type="text" class="customField30 lnField" size="12" value="<?php echo $siteSettings->customField30; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField31td">
            <span class="fieldNameC">Extra31:</span>
            <input type="text" class="customField31 lnField" size="12" value="<?php echo $siteSettings->customField31; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField32td">
            <span class="fieldNameC">Extra32:</span>
            <input type="text" class="customField32 lnField" size="12" value="<?php echo $siteSettings->customField32; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>

        <tr>
        <td class="customField33td">
            <span class="fieldNameC">Extra33:</span>
            <input type="text" class="customField33 lnField" size="12" value="<?php echo $siteSettings->customField33; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField34td">
            <span class="fieldNameC">Extra34:</span>
            <input type="text" class="customField34 lnField" size="12" value="<?php echo $siteSettings->customField34; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField35td">
            <span class="fieldNameC">Extra35:</span>
            <input type="text" class="customField35 lnField" size="12" value="<?php echo $siteSettings->customField35; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField36td">
            <span class="fieldNameC">Extra36:</span>
            <input type="text" class="customField36 lnField" size="12" value="<?php echo $siteSettings->customField36; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>

        <tr>
        <td class="customField37td">
            <span class="fieldNameC">Extra37:</span>
            <input type="text" class="customField37 lnField" size="12" value="<?php echo $siteSettings->customField37; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField38td">
            <span class="fieldNameC">Extra38:</span>
            <input type="text" class="customField38 lnField" size="12" value="<?php echo $siteSettings->customField38; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField39td">
            <span class="fieldNameC">Extra39:</span>
            <input type="text" class="customField39 lnField" size="12" value="<?php echo $siteSettings->customField39; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField40td">
            <span class="fieldNameC">Extra40:</span>
            <input type="text" class="customField40 lnField" size="12" value="<?php echo $siteSettings->customField40; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>

        <tr>
        <td class="customField41td">
            <span class="fieldNameC">Extra41:</span>
            <input type="text" class="customField41 lnField" size="12" value="<?php echo $siteSettings->customField41; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField42td">
            <span class="fieldNameC">Extra42:</span>
            <input type="text" class="customField42 lnField" size="12" value="<?php echo $siteSettings->customField42; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField43td">
            <span class="fieldNameC">Extra43:</span>
            <input type="text" class="customField43 lnField" size="12" value="<?php echo $siteSettings->customField43; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField44td">
            <span class="fieldNameC">Extra44:</span>
            <input type="text" class="customField44 lnField" size="12" value="<?php echo $siteSettings->customField44; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
        <td class="customField45td">
            <span class="fieldNameC">Extra45:</span>
            <input type="text" class="customField45 lnField" size="12" value="<?php echo $siteSettings->customField45; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField46td">
            <span class="fieldNameC">Extra46:</span>
            <input type="text" class="customField46 lnField" size="12" value="<?php echo $siteSettings->customField46; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField47td">
            <span class="fieldNameC">Extra47:</span>
            <input type="text" class="customField47 lnField" size="12" value="<?php echo $siteSettings->customField47; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField48td">
            <span class="fieldNameC">Extra48:</span>
            <input type="text" class="customField48 lnField" size="12" value="<?php echo $siteSettings->customField48; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
        <td class="customField49td">
            <span class="fieldNameC">Extra49:</span>
            <input type="text" class="customField49 lnField" size="12" value="<?php echo $siteSettings->customField49; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField50td">
            <span class="fieldNameC">Extra50:</span>
            <input type="text" class="customField50 lnField" size="12" value="<?php echo $siteSettings->customField50; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField51td">
            <span class="fieldNameC">Extra51:</span>
            <input type="text" class="customField51 lnField" size="12" value="<?php echo $siteSettings->customField51; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField52td">
            <span class="fieldNameC">Extra52:</span>
            <input type="text" class="customField52 lnField" size="12" value="<?php echo $siteSettings->customField52; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
        <td class="customField53td">
            <span class="fieldNameC">Extra53:</span>
            <input type="text" class="customField53 lnField" size="12" value="<?php echo $siteSettings->customField53; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField54td">
            <span class="fieldNameC">Extra54:</span>
            <input type="text" class="customField54 lnField" size="12" value="<?php echo $siteSettings->customField54; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField55td">
            <span class="fieldNameC">Extra55:</span>
            <input type="text" class="customField55 lnField" size="12" value="<?php echo $siteSettings->customField55; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField56td">
            <span class="fieldNameC">Extra56:</span>
            <input type="text" class="customField56 lnField" size="12" value="<?php echo $siteSettings->customField56; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>
        <tr>
        <td class="customField57td">
            <span class="fieldNameC">Extra57:</span>
            <input type="text" class="customField57 lnField" size="12" value="<?php echo $siteSettings->customField57; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField58td">
            <span class="fieldNameC">Extra58:</span>
            <input type="text" class="customField58 lnField" size="12" value="<?php echo $siteSettings->customField58; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField59td">
            <span class="fieldNameC">Extra59:</span>
            <input type="text" class="customField59 lnField" size="12" value="<?php echo $siteSettings->customField59; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField60td">
            <span class="fieldNameC">Extra60:</span>
            <input type="text" class="customField60 lnField" size="12" value="<?php echo $siteSettings->customField60; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>

        <tr>
        <td class="customField61td">
            <span class="fieldNameC">Extra61:</span>
            <input type="text" class="customField61 lnField" size="12" value="<?php echo $siteSettings->customField61; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField62td">
            <span class="fieldNameC">Extra62:</span>
            <input type="text" class="customField62 lnField" size="12" value="<?php echo $siteSettings->customField62; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField63td">
            <span class="fieldNameC">Extra63:</span>
            <input type="text" class="customField63 lnField" size="12" value="<?php echo $siteSettings->customField63; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        <td class="customField64td">
            <span class="fieldNameC">Extra64:</span>
            <input type="text" class="customField64 lnField" size="12" value="<?php echo $siteSettings->customField64; ?>" />
            <button class="buttons blackButton saveField">Save</button>
        </td>
        </tr>







        
      </table>
      <hr class="thinLine">
      <br />

      <h3 class="secTitle">3.) Sort Results</h3>
      <p>Choose the Fields and the order displayed in the overall view of Leads.  The top list are the
      Columns that will be used, the bottom are the Columns not to be used on the leads page.  Drag and Drop to place them.
      
      </p>
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
        <p class="buttonRow"><button class="buttons blueButton saveOrder">Save Order</button></p>
      </div>
    </div>
  </div>


  <div class="emptyDBDisplay section hidden">
    <div class="configLeft">
      <br />
      <h3 class="secTitle">Remove Lead data from database</h3>
      <hr class="thinLine">
      <br /><br />
      <p>You can choose to remove all lead data from the database for fast removal of data.</p>
      <p><b>Warning!!</b> This will delete all leads from the database!  If you are sure you want to do this proceed.</p>
      <br /><br />
	  <button class="buttons redButton emptyDB" <?php echo $disabled; ?>>Remove all Leads from Database</button>
	  <?php if ($_SESSION['firstName'] == 'Demo') { ?>
	  <p style="color: #569a46; font-weight: bold;">This has been disabled in Demo mode.</p>
	  <?php } ?>
    </div>
  </div>

  <div class="loggingDisplay section hidden">
    <div class="configLeft">
      <br />
      <h3 class="secTitle">Activity Log</h3> Current Server Time: <?php echo date('Y-m-d H:i:s'); ?>
      <hr class="thinLine">
      <br /><br />
      <div class="activityLog">
      </div>
    </div>
    <div class="configRight">
        <br /><br /><br /><br />
        <p class="buttonRow"><button class="buttons blueButton showLogging">Refresh List</button></p>
    </div>
  </div>


</div>
<div class="push"></div>
</div>
<script>
// Trigger events
    if (page == 'users') {
        $('.manageUsers').trigger('click');
    }
   
    if (page == 'logging') {
        $('.showLogging').trigger('click');
    }
    if (page == 'siteSettings') {
        $('.manageSite').trigger('click');
    }
</script>





<?php
require_once 'footer.php';
?>
