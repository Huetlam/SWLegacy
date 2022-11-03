<div class="field_wrapper">
  <?php
  include 'dbconnect.php';
  $faction_sql = "SELECT * FROM faction";
  $faction_qry = mysqli_query($dbconnect, $faction_sql);
  $faction_aa = mysqli_fetch_assoc($faction_qry);

   ?>
   <select class="" name="factionIDs[]">
     <?php
     do {
       $factionID = $faction_aa['factionID'];
       $faction = $faction_aa['faction'];

       echo "<option value='$factionID'>$faction</option>";
     } while ($faction_aa = mysqli_fetch_assoc($faction_qry));


      ?>

   </select>
   <a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="bi bi-dash-circle"></i></a>
</div>
