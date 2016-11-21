<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';
    if(!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
    // select loggedin users detail
    $res=mysqli_query($conn,"SELECT * FROM user WHERE userId=".$_SESSION['user']);
    $userRow=mysqli_fetch_array($res);

    //Inserting a new dog's information
    if(isset($_POST['submit']))
    {
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        else
        {   
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $age = mysqli_real_escape_string($conn, $_POST['age']);
            $sex = mysqli_real_escape_string($conn, $_POST['sex']);
            $purebred = mysqli_real_escape_string($conn, $_POST['purebred']);
            $energy = mysqli_real_escape_string($conn, $_POST['energy']);
            $shortbio = mysqli_real_escape_string($conn, $_POST['shortbio']);
            $mainpicture = mysqli_real_escape_string($conn, $_POST['mainpicture']);
            $longbio = mysqli_real_escape_string($conn, $_POST['longbio']);
            $total = count($_POST['pictures']);
            $catsOK = mysqli_real_escape_string($conn, $_POST['catsOK']);
            $fostered = mysqli_real_escape_string($conn, $_POST['fostered']);
            $kidsOK = mysqli_real_escape_string($conn, $_POST['kidsOK']);
            $pictures = "";
            for($i=0; $i<$total; $i++) 
            {
                $newpicture = mysqli_real_escape_string($conn, $_POST['pictures'][$i]);
                if(strlen($newpicture) > 0)
                {    
                    $pictures .= $newpicture;
                    $pictures .= ',';
                }
            }
            $pictures = rtrim($pictures, ',');
            $sql = "INSERT INTO available (name, age, sex, purebred, shortbio, mainpicture, longbio, pictures, catsOK, fostered, kidsOK, energy) 
            VALUES ('$name', '$age', '$sex', '$purebred', '$shortbio', '$mainpicture', '$longbio', '$pictures', '$catsOK', '$fostered', '$kidsOK', '$energy')";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        header('location:maintain.php');
    }

    //Editing a dog's information
    if(isset($_POST['editSubmit']))
    {
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        else
        {   
            $key = mysqli_real_escape_string($conn, $_POST['primaryKey']);
            $name = mysqli_real_escape_string($conn, $_POST['editName']);
            $age = mysqli_real_escape_string($conn, $_POST['editAge']);
            $sex = mysqli_real_escape_string($conn, $_POST['editSex']);
            $purebred = mysqli_real_escape_string($conn, $_POST['editPurebred']);
            $energy = mysqli_real_escape_string($conn, $_POST['editEnergy']);
            $shortbio = mysqli_real_escape_string($conn, $_POST['editShortbio']);
            $mainpicture = mysqli_real_escape_string($conn, $_POST['hiddenPicture']);
            $longbio = mysqli_real_escape_string($conn, $_POST['editLongbio']);
            $oldPictures = mysqli_real_escape_string($conn, $_POST['hiddenPictures']);
            $total = count($_POST['editPictures']);
            $catsOK = mysqli_real_escape_string($conn, $_POST['editCatsOK']);
            $fostered = mysqli_real_escape_string($conn, $_POST['editFostered']);
            $kidsOK = mysqli_real_escape_string($conn, $_POST['editKidsOK']);
            $pictures = "";
            for($i=0; $i<$total; $i++) 
            {
                $newpicture = mysqli_real_escape_string($conn, $_POST['editPictures'][$i]);
                if(strlen($newpicture) > 0)
                {    
                    $pictures .= $newpicture;
                    $pictures .= ',';
                }
            }
            if(strlen($oldPictures) == 0)
                $pictures = rtrim($pictures, ',');
            else
                $pictures .= $oldPictures;
            $sql = "UPDATE available SET name='$name', age='$age', sex='$sex', purebred='$purebred', shortbio='$shortbio', mainpicture='$mainpicture', longbio='$longbio', pictures='$pictures', catsOK='$catsOK', fostered='$fostered', kidsOK='$kidsOK', energy='$energy' WHERE name='$key';";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    //Deleting an available dog
    if(isset($_POST['deleteSubmit']))
    {
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        else
        {   
            $key = mysqli_real_escape_string($conn, $_POST['deleteKey']);
            $sql = "delete from available where name='$key';";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <head>
        <title>Maintain Available Dogs</title>
        <style type="text/css">
            .files {
                float: left;
                margin-right: 2px;
                margin-bottom: 7px;
                margin-top:1px;
                height: 22px;
                border-radius: 4px;
                border: 1px solid #cccccc;
                background: #ebeaea;
                border-color: #cccccc;
                cursor: pointer;
                box-shadow: inset 0 2px 0 rgba(255, 255, 255, 0.3);
                padding-left: 6px;
                padding-right: 6px;
                position: relative;
            }
        </style>
        <script>
            //Functions to add and remove pictures
            $(document).on('change', '#editMainpicture', function() {
                var fullPath = $(this).val();
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                document.getElementById('hiddenPicture').value = filename;    
            });
            
            $(document).on('click', '.removeFile', function () {
                $(this).parent().remove();
                document.getElementById("editMainpicture").required = true;
            });

            $(document).on('click', '.removeFiles', function () {
                var siblings = $(this).parent().siblings();
                var pictures = '';
                $(this).parent().remove();
                for (i = 0; i < siblings.length; i++) { 
                    pictures += siblings[i].childNodes[0].data;
                    pictures += ',';
                }
                document.getElementById('hiddenPictures').value = pictures.slice(0, pictures.length-1);
                if(pictures == '')
                {
                    document.getElementById("editPictures").required = true;
                }
            });
            
            //Function to search for a dog
            $(document).ready(function() {
                var $orig_rows = $('#available tbody tr td[class = "name"]');
                $('#input').keyup(function() {
                    var $rows = $orig_rows;
                    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                        reg = RegExp(val, 'i'),
                        text;
                    $("tr:hidden").show();
                    $rows.show().filter(function() {
                        text = $(this).text().replace(/\s+/g, ' ');
                        return !reg.test(text);
                    }).parent("tr").hide();
                });
            });
            
            
            function deleteModal(el)
            {
                $('#deleteModal').modal();
                var row = $(el).closest('tr').children('td');
                document.getElementById('deleteKey').value = row[0].innerHTML;
            }
            function editModal(el)
            {
                $("#editModal").modal();
                document.getElementById("editMainpicture").required = false;
                document.getElementById("editPictures").required = false;
                var row = $(el).closest('tr').children('td');
                console.log(row[0].innerHTML);
                document.getElementById('editName').value = row[0].innerHTML;
                document.getElementById('primaryKey').value = row[0].innerHTML;
                document.getElementById('editAge').value = row[1].innerHTML;
                if(row[2].innerHTML == 'M')
                    document.getElementById('editSex-0').checked = true;
                else
                    document.getElementById('editSex-1').checked = true;
                if(row[3].innerHTML == 'Y')
                    document.getElementById('editPurebred-0').checked = true;
                else
                    document.getElementById('editPurebred-1').checked = true;
                if(row[5].innerHTML == 'Y')
                    document.getElementById('editCatsOK-0').checked = true;
                else if(row[5].innerHTML == 'N')
                    document.getElementById('editCatsOK-1').checked = true;
                else
                    document.getElementById('editCatsOK-2').checked = true;
                if(row[4].innerHTML == 'Y')
                    document.getElementById('editFostered-0').checked = true;
                else
                    document.getElementById('editFostered-1').checked = true;
                if(row[6].innerHTML == 'Y')
                    document.getElementById('editKidsOK-0').checked = true;
                else if(row[6].innerHTML == 'N')
                    document.getElementById('editKidsOK-1').checked = true;
                else
                    document.getElementById('editKidsOK-2').checked = true;
                if(row[7].innerHTML == 'L')
                    document.getElementById('editEnergy-0').checked = true;
                else if(row[7].innerHTML == 'M')
                    document.getElementById('editEnergy-1').checked = true;
                else
                    document.getElementById('editEnergy-2').checked = true;
                document.getElementById('editShortbio').value = row[8].innerHTML;
                document.getElementById('hiddenPicture').value = row[9].innerHTML;
                $('#file').html(('<div class="files">' + row[9].innerHTML + '<a class="removeFile"><span class="glyphicon glyphicon-remove"></span></a></div>'));
                document.getElementById('editLongbio').value = row[10].innerHTML;
                document.getElementById('hiddenPictures').value = row[11].innerHTML;
                var pictures = row[11].innerHTML.split(',');
                $('#fileList').html("");
                for (var i = 0; i < pictures.length; i++) {
                    $('#fileList').append(('<div class="files">' + pictures[i] + '<a class="removeFiles"><span class="glyphicon glyphicon-remove"></span></a></div>'));
                }
            }
        </script>
    </head>
    <body>
        <h2>Hello&nbsp;<?php echo $userRow['userName']; ?>&nbsp;</h2>
        <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>
        <div id="container" class="container">	
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#insert" data-toggle="tab">Insert new</a>
                </li>
                <li>
                    <a href="#update" data-toggle="tab">Update</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="insert">
                    <form id="inputForm" class="form-horizontal" method="post" style="margin-top:5%;">
                        <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="name">Full Name</label>  
                          <div class="col-md-4">
                          <input id="name" name="name" type="text" placeholder="Rocky von Reino" class="form-control input-md" required>

                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="age">Age(in Months)</label>  
                          <div class="col-md-4">
                          <input id="age" name="age" type="text" placeholder="" class="form-control input-md" required>

                          </div>
                        </div>

                        <!-- Multiple Radios (inline) -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="sex">Sex</label>
                          <div class="col-md-4"> 
                            <label class="radio-inline" for="sex-0">
                              <input type="radio" name="sex" id="sex-0" value="M" checked="checked">
                              Male
                            </label> 
                            <label class="radio-inline" for="sex-1">
                              <input type="radio" name="sex" id="sex-1" value="F">
                              Female
                            </label>
                          </div>
                        </div>

                        <!-- Multiple Radios (inline) -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="purebred">Purebred?</label>
                          <div class="col-md-4"> 
                            <label class="radio-inline" for="purebred-0">
                              <input type="radio" name="purebred" id="purebred-0" value="Y" checked="checked">
                              Yes
                            </label> 
                            <label class="radio-inline" for="purebred-1">
                              <input type="radio" name="purebred" id="purebred-1" value="N">
                              No
                            </label>
                          </div>
                        </div>
                            
                        <!-- Multiple Radios (inline) -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="energy">Energy</label>
                          <div class="col-md-4"> 
                            <label class="radio-inline" for="energy-0">
                              <input type="radio" name="energy" id="energy-0" value="L">
                              Low
                            </label> 
                            <label class="radio-inline" for="purebred-1">
                              <input type="radio" name="energy" id="energy-1" value="M" checked="checked">
                              Medium
                            </label>
                            <label class="radio-inline" for="energy-2">
                              <input type="radio" name="energy" id="energy-2" value="H">
                              High
                            </label>
                          </div>
                        </div>
                            
                        <!-- Multiple Radios (inline) -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="fostered">Fostered?</label>
                          <div class="col-md-4"> 
                            <label class="radio-inline" for="fostered-0">
                              <input type="radio" name="fostered" id="fostered-0" value="Y" checked="checked">
                              Yes
                            </label> 
                            <label class="radio-inline" for="fostered-1">
                              <input type="radio" name="fostered" id="fostered-1" value="N">
                              No
                            </label>
                          </div>
                        </div>
                            
                        <!-- Multiple Radios (inline) -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="catsOK">Good with cats?</label>
                          <div class="col-md-4"> 
                            <label class="radio-inline" for="catsOK-0">
                              <input type="radio" name="catsOK" id="catsOK-0" value="Y" checked="checked">
                              Yes
                            </label> 
                            <label class="radio-inline" for="catsOK-1">
                              <input type="radio" name="catsOK" id="catsOK-1" value="N">
                              No
                            </label>
                            <label class="radio-inline" for="catsOK-2">
                              <input type="radio" name="catsOK" id="catsOK-2" value="U">
                              Unknown
                            </label>
                          </div>
                        </div>
                            
                        <!-- Multiple Radios (inline) -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="kidsOK">Good with kids?</label>
                          <div class="col-md-4"> 
                            <label class="radio-inline" for="kidsOK-0">
                              <input type="radio" name="kidsOK" id="kidsOK-0" value="Y" checked="checked">
                              Yes
                            </label> 
                            <label class="radio-inline" for="kidsOK-1">
                              <input type="radio" name="kidsOK" id="kidsOK-1" value="N">
                              No
                            </label>
                            <label class="radio-inline" for="kidsOK-2">
                              <input type="radio" name="kidsOK" id="kidsOK-2" value="U">
                              Unknown
                            </label>
                          </div>
                        </div>

                        <!-- Textarea -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="shortbio">Short Bio</label>
                          <div class="col-md-4">                     
                            <textarea class="form-control" id="shortbio" name="shortbio" required></textarea>
                          </div>
                        </div>

                        <!-- File Button --> 
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="mainpicture">Main picture</label>
                          <div class="col-md-4">
                            <input id="mainpicture" name="mainpicture" class="input-file" type="file" required>
                          </div>
                        </div>

                        <!-- Textarea -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="longbio">Long Bio</label>
                          <div class="col-md-4">                     
                            <textarea class="form-control" id="longbio" name="longbio" required></textarea>
                          </div>
                        </div>

                        <!-- File Button --> 
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="pictures">Pictures</label>
                            <div class="col-md-4">
                                <input id="pictures" name="pictures[]" class="input-file" type="file" required multiple>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-4">
                            <button id="submit" name="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <div class="tab-pane" id="update">
                    <form class="form-inline" style="margin-top:2%;">
                        <div class="form-group">
                            <label for="input">Search by name:</label>
                            <input class="form-control" id="input" placeholder="Enter name">
                        </div>
                    </form>
                    <div style="text-align:right;">Y - Yes, N - No, U - Unknown</div>
                    <div style="text-align:right; margin-bottom:1%;">L - Low, M - Medium, H - High</div>
                    <div class="table-responsive">
                        <table id="available" class="table available" border="1">
                            <thead>
                                <tr>
                                    <th id="name">Name</th>
                                    <th id="year">Age(in Months)</th>
                                    <th id="sex">Sex</th>
                                    <th id="purebred">Purebred?</th>
                                    <th id="fostered">Fostered?</th>
                                    <th id="catsOK">Good with cats?</th>
                                    <th id="kidsOK">Good with kids?</th>
                                    <th id="energy">Energy</th>
                                    <th id="shortbio">Short Bio</th>
                                    <th id="mainpicture">Main Picture</th>
                                    <th id="longbio">Long Bio</th>
                                    <th id="pictures">Pictures</th>
                                    <th id="timeadded">Time Added</th>
                                    <th id="options">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    } 
                                    else
                                    {
                                        $query = mysqli_query($conn, 'select * from available');
                                        $count = count($query);
                                        $i = 1;
                                        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {?>
                                            <tr>
                                                <td class="name" id='<?php echo "name".(string)$i?>'><?php echo $row['name'];?></td>
                                                <td class="age" id='<?php echo "age".(string)$i?>'><?php echo $row['age'];?></td>
                                                <td class="sex" id='<?php echo "sex".(string)$i?>'><?php echo $row['sex'];?></td>
                                                <td class="purebred" id='<?php echo "purebred".(string)$i?>'><?php echo $row['purebred'];?></td>
                                                <td class="fostered" id='<?php echo "fostered".(string)$i?>'><?php echo $row['fostered'];?></td>
                                                <td class="catsOK" id='<?php echo "catsOK".(string)$i?>'><?php echo $row['catsOK'];?></td>
                                                <td class="kidsOK" id='<?php echo "kidsOK".(string)$i?>'><?php echo $row['kidsOK'];?></td>
                                                <td class="energy" id='<?php echo "energy".(string)$i?>'><?php echo $row['energy'];?></td>
                                                <td class="shortbio" id='<?php echo "shortbio".(string)$i?>'><?php echo $row['shortbio'];?></td>
                                                <td class="mainpicture" id='<?php echo "mainpicture".(string)$i?>'><?php echo $row['mainpicture'];?></td>
                                                <td class="longbio" id='<?php echo "longbio".(string)$i?>'><?php echo $row['longbio'];?></td>
                                                <td class="pictures" id='<?php echo "pictures".(string)$i?>'><?php echo $row['pictures'];?></td>
                                                <td class="timeadded" id='<?php echo "timeadded".(string)$i?>'><?php echo $row['timeadded'];?></td>
                                                <td class="options" id='<?php echo "options".(string)$i?>'><a id="edit" onclick="editModal(this);" style="display:inline-block; margin-right:5px; margin-left:5px;"><span class="glyphicon glyphicon-pencil"></span></a><a onclick="deleteModal(this);" id="delete" style="display:inline-block; margin-right:5px; margin-left:5px;"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="editModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Information</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" class="form-horizontal" method="post" style="margin-top:5%;">
                                        <fieldset>
                                        <!-- Primary key -->
                                        <div class="form-group" style="display: none;">
                                          <div class="col-md-4">
                                            <input id="primaryKey" name="primaryKey" type="text" class="form-control input-md">
                                          </div>
                                        </div>
                                            
                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editName">Full Name</label>  
                                          <div class="col-md-8">
                                          <input id="editName" name="editName" type="text" placeholder="Rocky von Reino" class="form-control input-md" required>
                                          </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editAge">Age(in Months)</label>  
                                          <div class="col-md-8">
                                          <input id="editAge" name="editAge" type="text" placeholder="" class="form-control input-md" required>

                                          </div>
                                        </div>

                                        <!-- Multiple Radios (inline) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editSex">Sex</label>
                                          <div class="col-md-8"> 
                                            <label class="radio-inline" for="editSex-0">
                                              <input type="radio" name="editSex" id="editSex-0" value="M">
                                              Male
                                            </label> 
                                            <label class="radio-inline" for="editSex-1">
                                              <input type="radio" name="editSex" id="editSex-1" value="F">
                                              Female
                                            </label>
                                          </div>
                                        </div>

                                        <!-- Multiple Radios (inline) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editPurebred">Purebred?</label>
                                          <div class="col-md-8"> 
                                            <label class="radio-inline" for="editPurebred-0">
                                              <input type="radio" name="editPurebred" id="editPurebred-0" value="Y">
                                              Yes
                                            </label> 
                                            <label class="radio-inline" for="editPurebred-1">
                                              <input type="radio" name="editPurebred" id="editPurebred-1" value="N">
                                              No
                                            </label>
                                          </div>
                                        </div>
                                            
                                        <!-- Multiple Radios (inline) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editEnergy">Energy</label>
                                          <div class="col-md-8"> 
                                            <label class="radio-inline" for="editEnergy-0">
                                              <input type="radio" name="editEnergy" id="editEnergy-0" value="L">
                                              Low
                                            </label> 
                                            <label class="radio-inline" for="purebred-1">
                                              <input type="radio" name="editEnergy" id="editEnergy-1" value="M">
                                              Medium
                                            </label>
                                            <label class="radio-inline" for="editEnergy-2">
                                              <input type="radio" name="editEnergy" id="editEnergy-2" value="H">
                                              High
                                            </label>
                                          </div>
                                        </div>
                                            
                                        <!-- Multiple Radios (inline) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editFostered">Fostered?</label>
                                          <div class="col-md-8"> 
                                            <label class="radio-inline" for="editFostered-0">
                                              <input type="radio" name="editFostered" id="editFostered-0" value="Y">
                                              Yes
                                            </label> 
                                            <label class="radio-inline" for="editFostered-1">
                                              <input type="radio" name="editFostered" id="editFostered-1" value="N">
                                              No
                                            </label>
                                          </div>
                                        </div>
                                            
                                        <!-- Multiple Radios (inline) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editCatsOK">Good with cats?</label>
                                          <div class="col-md-8"> 
                                            <label class="radio-inline" for="editCatsOK-0">
                                              <input type="radio" name="editCatsOK" id="editCatsOK-0" value="Y">
                                              Yes
                                            </label> 
                                            <label class="radio-inline" for="editCatsOK-1">
                                              <input type="radio" name="editCatsOK" id="editCatsOK-1" value="N">
                                              No
                                            </label>
                                            <label class="radio-inline" for="editCatsOK-2">
                                              <input type="radio" name="editCatsOK" id="editCatsOK-2" value="U">
                                              Unknown
                                            </label>
                                          </div>
                                        </div>
                                            
                                        <!-- Multiple Radios (inline) -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editKidsOK">Good with kids?</label>
                                          <div class="col-md-8"> 
                                            <label class="radio-inline" for="editKidsOK-0">
                                              <input type="radio" name="editKidsOK" id="editKidsOK-0" value="Y">
                                              Yes
                                            </label> 
                                            <label class="radio-inline" for="editKidsOK-1">
                                              <input type="radio" name="editKidsOK" id="editKidsOK-1" value="N">
                                              No
                                            </label>
                                            <label class="radio-inline" for="editKidsOK-2">
                                              <input type="radio" name="editKidsOK" id="editKidsOK-2" value="U">
                                              Unknown
                                            </label>
                                          </div>
                                        </div>

                                        <!-- Textarea -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editShortbio">Short Bio</label>
                                          <div class="col-md-8">                     
                                            <textarea class="form-control" id="editShortbio" name="editShortbio" required></textarea>
                                          </div>
                                        </div>

                                        <!-- File Button --> 
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editMainpicture">Main picture</label>
                                          <div class="col-md-8">
                                            <input id="editMainpicture" name="editMainpicture" class="input-file" type="file" required>
                                              <div style="display:none;">
                                                    <input id="hiddenPicture" name="hiddenPicture" type="text" class="form-control input-md">
                                                </div>
                                            <div id="file"></div>  
                                          </div>
                                        </div>

                                        <!-- Textarea -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editLongbio">Long Bio</label>
                                          <div class="col-md-8">                     
                                            <textarea class="form-control" id="editLongbio" name="editLongbio" required></textarea>
                                          </div>
                                        </div>

                                        <!-- File Button --> 
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="editPictures">Pictures</label>
                                            <div class="col-md-8">
                                                <input id="editPictures" name="editPictures[]" class="input-file" type="file" required multiple>
                                                <div style="display:none;">
                                                    <input id="hiddenPictures" name="hiddenPictures" type="text" class="form-control input-md">
                                                </div>
                                                <div id="fileList"></div>
                                          </div>
                                        </div>

                                        <!-- Button -->
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="editSubmit"></label>
                                          <div class="col-md-4">
                                            <button id="editSubmit" name="editSubmit" class="btn btn-primary">Submit</button>
                                          </div>
                                        </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="deleteModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete information</h4>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure you want to delete this record?</p>
                            <form id="editForm" class="form-horizontal" method="post" style="margin-top:5%;">
                                <fieldset>
                                    <!-- Primary key -->
                                        <div class="form-group" style="display: none;">
                                          <div class="col-md-4">
                                            <input id="deleteKey" name="deleteKey" type="text" class="form-control input-md">
                                          </div>
                                        </div>
                                    <!-- Buttons -->
                                    <div class="form-group" style="text-align:center;">
                                        <div class="col-offset-xs-3 col-xs-3">
                                            <button id="deleteSubmit" name="deleteSubmit" class="btn btn-primary">Yes</button>
                                        </div>
                                         <div class="col-offset-xs-3 col-xs-3">
                                             <button id="noDelete" name="noDelete" class="btn btn-secondary">No</button>
                                         </div>
                                    </div>
                                </fieldset>
                              </form>
                          </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
