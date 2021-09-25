<div class="topBanner">
    <div class="logo">
       <a href="index.php"> <img class="logo" src="img/TCS Crm.png" alt="LCM - Leads and Contacts Manager"/></a>
    </div>
    <div class="topMenu">
    <?php
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 'yes') {
    ?>
      <div class="hello">
        <u>Hello <?php echo $_SESSION['firstName']; ?></u>
        <div id="notification_box">
         <ul id="notify">
            <li id="notifications_container">
               <div id="notifications_counter">2</div>
               <div id="notifications_button">
                  <div class="notifications_bell white"></div>
               </div>
               <div id="notifications">
                  <h4>Notifications</h4>
                  <div style="height:300px;" id="show_notification">
			
                     <p><strong>raja</strong> message good</p>
					 
                  </div>
               </div>
            </li>
		
         </ul>
      </div>
      </div>
    <?php } ?>
      <ul>
        <?php
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 'yes') {
        ?>
        <li>
          <a href="logout.php"><img src='img/power.png' alt="Logout" /> Logout</a>
        </li>
        <?php
            if (isset($access) && $access == 1 || ($access==2 && $_SESSION['ownLeadsOnly']==0 )) {  //Admin
        ?>
        <li class="<?php echo ($currPage == 'config.php') ? 'active' : ''; ?>"><a href="config.php" >
          <img src='img/gear.png' alt="Settings" /> Settings</a>
          <ul>
           
            <li><a href="config.php?page=users"><span>Users</span></a></li>
            <li><a href="config.php?page=siteSettings"><span>Site Settings</span></a></li>
            <li><a href="config.php?page=logging"><span>Logging</span></a></li>
          </ul>
        </li>
        <?php   } ?>
        <?php
            if (isset($access) && $access == 1 || ($access==2 && $_SESSION['ownLeadsOnly']==0 ) || ($access==2 && $_SESSION['ownLeadsOnly']==1 )) {  //Admin
        ?>
        <li class="<?php echo ($currPage == 'task_calender.php') ? 'active' : ''; ?>"><a href="task_calender.php" >
          <img src='img/ekg.png' alt="Statistics" /> schedule</a>
        </li>
        <li class="<?php echo ($currPage == 'stats.php') ? 'active' : ''; ?>"><a href="stats.php" >
          <img src='img/ekg.png' alt="Statistics" /> Statistics</a>
        </li>

        <?php } ?>
        
        <li class="<?php echo ($currPage == 'index.php') ? 'active' : ''; ?>"><a href="index.php">
          <img src='img/group.png' alt="Leads & Contacts" /> Leads</a>
          <?php
            if (isset($access) && $access == 1 || ($access==2 && $_SESSION['ownLeadsOnly']==0 ) || ($access==2 && $_SESSION['ownLeadsOnly']==1 )) {  //Admin
        ?>
          <ul>
           
          <li><a href="tcs_name_sub.php">TCS Name & Subject</a></li>
           <li><a href="tcs_personal_info.php">TCS Personal Info</a></li>
           <li><a href="tcs_pay_info.php">TCS Payment Info</a></li>
           <li><a href="tcs_due_dates.php">TCS Due Dates</a></li>
         </ul>
         <?php } ?>
        </li>
        
        <?php } elseif ($currPage == 'login.php') { ?>
          <li class="active"><a href="#">Please Login</a></li>
        <?php } elseif ($currPage == 'install.php') {?>
          <li class="active"><a href="#">Install LCM</a></li>
        <?php } ?>      
      </ul>
    </div>
</div>



      <script>
      $(document).ready(function () {
          $('.hello').click(function () {
              jQuery.ajax({
			//	url:'update_message_status.php',
				success:function(){
					$('#notifications').fadeToggle('fast', 'linear');
					$('#notifications_counter').fadeOut('slow');
				}
			  })
              return false;
          });
          $(document).click(function () {
              $('#notifications').hide(); 
          });
      });
   </script>