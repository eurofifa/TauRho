<h2>Edit A League</h2>
<h4>EuroFIFA Online League Managemant System</h4>
<p>
    Lets edit your own league.
</p>
<p class="update-nag">
    <a class="button button-primary" href="admin.php?page=manage-league&m=load_manage_league_progress&v=<?php echo $result['id'];?>">Manage Progress</a>
</p>
<div class="stuffbox">
<form action="admin.php?page=manage-league" method="post" class="major-publishing-actions" style="padding: 25px">
    <table class="form-table">    
        <tr valign="top">
            <th scope="row"><label for="leaguename">Name of League</label></th>
            <td><input name="leaguename" type="text" id="blogname" value="<?php echo $result["name"]; ?>" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="leagueslug">Slug (autofill if empty)</label></th>
            <td><input name="leagueslug" type="text" id="blogname" value="<?php echo $result["slug"]; ?>" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="game">Game</label></th>
            <td>
                <select name="game" id="blogname" class="regular-text">
                    <?php 
                         $games = array("FIFA 14", "FIFA 13", "FIFA 12", "FIFA 11", "FIFA Would Cup '14", "FIFA 15");
                         foreach ($games as $key){   
                             if($key == $result["game"]){ 
                                 echo '<option selected>'.$key.'</option>';
                             }else{ 
                                 echo '<option>'.$key.'</option>';
                             }  
                         }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="platform">Platform</label></th>
            <td>
                <select name="platform" id="blogname" class="regular-text">
                    <?php 
                         $platform = array("PS3", "PS4", "Xbox360", "Xbox One", "PC", "MAC", "iOS", "Android");
                         foreach ($platform as $key){   
                             if($key == $result["platform"]){ 
                                 echo '<option selected>'.$key.'</option>';
                             }else{ 
                                 echo '<option>'.$key.'</option>';
                             }  
                         }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="leaguetype">Type</label></th>
            <td>
                <select name="leaguetype" id="blogname" class="regular-text">
                      <?php 
                         $types = array("Knockout", "Tournament", "Tournament & K/O");
                         foreach ($types as $key){   
                             if($key == $result["type"]){ 
                                 echo '<option selected>'.$key.'</option>';
                             }else{ 
                                 echo '<option>'.$key.'</option>';
                             }  
                         }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="contestants">Contestants</label></th>
            <td>
                <select name="contestants" id="blogname" class="regular-text">
                      <?php 
                         $players = array(8,16,32,64,128);
                         foreach ($players as $key){   
                             if($key == $result["players"]){ 
                                 echo '<option selected>'.$key.'</option>';
                             }else{ 
                                 echo '<option>'.$key.'</option>';
                             }  
                         }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="status">Status</label></th>
            <td>
                <select name="status" id="blogname" class="regular-text">
                      <?php 
                         $status = array("OPEN", "CLOSED", "AUTO");
                         foreach ($status as $key){ 
                             if($result["status"] == "IN PROGRESS"){
                                     echo '<option selected>IN PROGRESS</option>';
                                     echo '<option>CLOSED</option>';
                                     break;
                             }
                             if($key == $result["status"]){
                                 echo '<option selected>'.$key.'</option>';
                             }else{ 
                                 echo '<option>'.$key.'</option>';
                             }  
                         }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="start">Start</label></th>
            <td><input name="start" type="datetime" id="blogname" value="<?php echo $result["start_date"]; ?>" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="end">End</label></th>
            <td><input name="end" type="datetime" id="blogname" value="<?php echo $result["end_date"]; ?>" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="rules">Rules</label></th>
            <td><?php the_editor($result["rules"],'rules','rules'); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="rewards">Rewards</label></th>
            <td><?php the_editor($result["rewards"],'rewards','rewards'); ?></td>
        </tr>
    </table>
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
</form>
</div>