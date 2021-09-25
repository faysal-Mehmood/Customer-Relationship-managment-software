

<?php
/**
  * This is the main page for the LCM. 
  *
**/
require_once 'header.php';


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

      <li><a href="#" class="manageExp sections selected">Import / Export</a></li>
 
    </ul>
  </div>



  <div class="exportDisplay section ">
    <div id="tabs">
      <ul>
        <li><a href="#imports">Import Leads</a></li>
        <li><a href="#exports">Export Leads</a></li>
      </ul>
      
      <div id="imports">
        <h3 class="modalH">Import Leads</h3>
        <div class="importSteps">
          <b>Step 1.</b> Import Leads from a file containing data.<br />
          Important Notes: 
          <ul>
            <li>Supported formats are csv, xlsx, xls. </li>
            <li>Be sure to at least have a first and last name field in your data or it will be ignored.</li>
            <li>Email addresses must either be valid or blank or the entry will be rejected.</li>
            <li>Import Data must have a header row so you can line up fields correctly.</li>
          </ul>
          <br />
          <form method="post" enctype="multipart/form-data" id="UploadForm">
             <input id="fileToUpload" type="file" name="fileToUpload" class="input">
             <button class="buttons blueButton uploadContacts" id="buttonUpload" onclick="return ajaxFileUpload();">Upload</button>
             <img id="loading" src="img/loaderb32.gif" alt="Loading" style="float:right; display:none;">  </form>
        </div>
      </div>

      <div id="exports">
        <h3 class="modalH">Export Leads</h3>
        <ul>
          <li>
            <form action="ajax/exportDirect.php" method="post">
              Export as <a href="#" onclick="$(this).closest('form').submit()" class="exportExcel">Excel Spreadsheet</a>
              <input type="hidden" name="type" value="excel" />
            </form>
          </li>
          <li>
            <form action="ajax/exportDirect.php" method="post">
              Export as <a href="#" onclick="$(this).closest('form').submit()" class="exportCSV">CSV</a>
              <input type="hidden" name="type" value="csv" />
            </form>
          </li>
        </ul>
        <div class="results"></div>
      </div>
    </div>
  </div>




</div>
<div class="push"></div>
<script>
// Trigger events
   
    if (page == 'import') {
        $('.manageExp').trigger('click');
    }
   
</script>

