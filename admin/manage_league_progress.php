<h2>Manage Progress</h2>
<h4>EuroFIFA Online League Managemant System</h4>
<p>
    This screen allows you to manage the progress of your league. You might add or kick players to the league.
</p>
<form action="" method="post" class="stuffbox" style="padding: 25px">
    <table class="form-table">    
        <tr valign="top">
            <th scope="row"><label for="leaguename">Name of League</label></th>
            <td>   <input type="text" name="ID" value="<?php echo $result['id']; ?>" hidden />
                <input name="leaguename" type="text" id="blogname" value="<?php echo $result["name"]; ?>" class="regular-text" disabled></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="stage">Stage</label></th>
            <td>
                <select name="stage" id="blogname" class="regular-text" disabled>
                    <?php 
                         $games = array("Registered", "Stage 1", "Stage 2", "Stage 3", "Stage 4", "Stage 5", "Stage 6", "Stage 7", "Stage 8", "Semi-Final", "Final", "Bronze");
                         foreach ($games as $key){   
                             if($key == $result["stage"]){ 
                                 echo '<option selected>'.$key.'</option>';
                             }else{ 
                                 echo '<option>'.$key.'</option>';
                             }  
                         }
                    ?>
                </select>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Next Stage">
            </td>
        </tr>
    </table> 
</form>
<div class="meta-box-sortables ui-sortable">
        <div id="linksubmitdiv" class="postbox closed" style="margin:10px 0;">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle" style="padding: 5px;"><span>Add Players</span></h3>
            <div class="inside">
                <p><?php echo $data['users']; ?></p>
            </div>
        </div>
        <div id="linksubmitdiv" class="postbox " style="margin:10px 0;">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle" style="padding: 5px;"><span>Kick Players</span></h3>
            <div class="inside">
                <div id="major-publishing-actions">
                    <div id="publishing-action">
                        <input name="save" type="submit" class="button-primary" id="publish" value="Add Link">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>     
</div>