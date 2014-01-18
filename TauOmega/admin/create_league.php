<?php //var_dump($_POST); 
?>
<h2>Create A League</h2>
<h4>EuroFIFA Online League Managemant System</h4>
<p>
    Lets create your own league.
</p>
<form action="admin.php?page=create-league" method="post" class="stuffbox" style="padding: 25px;">
    <table class="form-table">    
        <tr valign="top">
            <th scope="row"><label for="leaguename">Name of League</label></th>
            <td><input name="leaguename" type="text" id="blogname" value="" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="leagueslug">Slug (autofill if empty)</label></th>
            <td><input name="leagueslug" type="text" id="blogname" value="" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="game">Game</label></th>
            <td>
                <select name="game" id="blogname" class="regular-text">
                    <option>FIFA 14</option>
                    <option>FIFA 13</option>
                    <option>FIFA 12</option>
                    <option>FIFA World Cup '14</option>
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
                                 echo '<option>'.$key.'</option>';
                         }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="platform">Platform</label></th>
            <td>
                <select name="platform" id="blogname" class="regular-text">
                    <option>PS3</option>
                    <option>PS4</option>
                    <option>Xbox360</option>
                    <option>Xbox One</option>
                    <option>PC</option>
                    <option>MAC</option>
                    <option>iOS</option>
                    <option>Android</option>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="contestants">Contestants</label></th>
            <td>
                <select name="contestants" id="blogname" class="regular-text">
                    <option>8</option>
                    <option>16</option>
                    <option>32</option>
                    <option>64</option>
                    <option>128</option>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="status">Status</label></th>
            <td>
                <select name="status" id="blogname" class="regular-text">
                    <option>OPEN</option>
                    <option>CLOSED</option>
                    <option>AUTO</option>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="start">Start</label></th>
            <td><input name="start" type="datetime" id="blogname" value="" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="end">End</label></th>
            <td><input name="end" type="datetime" id="blogname" value="" class="regular-text"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="rules">Rules</label></th>
            <td><?php the_editor('','rules','rules'); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="rewards">Rewards</label></th>
            <td><?php the_editor('','rewards','rewards'); ?></td>
        </tr>
    </table>
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Create League">
</form>