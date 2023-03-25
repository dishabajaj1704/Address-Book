<!DOCTYPE html>
<html>
<?php
    require_once('./includes/functions.inc.php');
    $error=false;
    if(isset($_POST['action'])){
        $first_name=sanitize($_POST['first_name']);
        $last_name=sanitize($_POST['last_name']);
        $email=sanitize($_POST['email']);
        $birthdate=date('Y-m-d',strtotime(sanitize($_POST['birthdate'])));
        $telephone=sanitize($_POST['telephone']);
        $address=sanitize($_POST['address']);
        // print_r("$_FILES");
        if(!$first_name || !$last_name || !$email || !$birthdate || !$telephone || !$address || !isset($_FILES['pic']['name'])) {
            $error=true;
        }else{
            //We would validates values,which can directly insert in database!

            //pic is the name of input file = <input type="file" name="pic" id="pic" data-error=".pic_error">
            // print_r($_FILES['pic']);
            // ArrayArray ( [name] => 1.jpg [full_path] => 1.jpg [type] => image/jpeg [tmp_name] => C:\xampp\tmp\php6D0B.tmp [error] => 0 [size] => 4726 )
            $tmp_file_name=$_FILES['pic']['name'];
            $tmp_file_path=$_FILES['pic']['tmp_name'];
            $file_name_as_array=explode(".",$tmp_file_name);
            $ext=end($file_name_as_array);

            $data['first_name']=$first_name;
            $data['last_name']=$last_name;
            $data['birthdate']=$birthdate;
            $data['telephone']=$telephone;
            $data['email']=$email;
            $data['address']=$address;
            $data['image_name']=$ext;
            $query=prepare_insert_query("contacts",$data);
            db_query($query);
            $id=get_last_insert_id();
            $file_name="$id.$ext";
            move_uploaded_file($tmp_file_path,"images/users/$file_name");
            //heade redirect us to first page
            header('Location: index.php?op=add&status=success');
        }
        
    }
?>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Add Contact</title>
</head>

<body>
    <!--NAVIGATION BAR-->
    <nav>
        <div class="nav-wrapper">
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="#!">Profile</a></li>
                <li><a href="#!">Signout</a></li>
            </ul>
            <nav>
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo center">Contact Info</a>
                    <ul class="right hide-on-med-and-down">

                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i
                                    class="material-icons right">more_vert</i></a></li>
                    </ul>
                </div>
            </nav>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <!--/NAVIGATION BAR-->
    <div class="container">
        <div class="row mt50">
            <h2>Add New Contact</h2>
        </div>
        <?php
        if($error):
        ?>
            <div class="materialert error">
                <div class="material-icons">error_outline</div>
                OOPS!Something missing from your side!Please fill in the complete details!
                <button type="button" class="close-alert">×</button>
            </div>
        <?php   
            endif;
        ?>
      
        <div class="row">
            <form class="col s12 formValidate" action="<?=$_SERVER['PHP_SELF'];?>" id="add-contact-form" method="POST"enctype="multipart/form-data">
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" class="validate"
                            data-error=".first_name_error" value="<?=old($_POST,'first_name')?>">
                        <label for="first_name">First Name</label>
                        <div class="first_name_error "></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text" class="validate"
                            data-error=".last_name_error">
                        <label for="last_name">Last Name</label>
                        <div class="last_name_error "></div>
                    </div>
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="email" name="email" type="email" class="validate" data-error=".email_error" value="<?=old($_POST,'email')?>">
                        <label for="email">Email</label>
                        <div class="email_error "></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="birthdate" name="birthdate" type="text" class="datepicker"
                            data-error=".birthday_error">
                        <label for="birthdate">Birthdate</label>
                        <div class="birthday_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <input id="telephone" name="telephone" type="tel" class="validate"
                            data-error=".telephone_error">
                        <label for="telephone">Telephone</label>
                        <div class="telephone_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea"
                            data-error=".address_error"></textarea>
                        <label for="address">Address</label>
                        <div class="address_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="pic" id="pic" data-error=".pic_error">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload Your Image">
                        </div>
                        <div class="pic_error "></div>
                    </div>
                </div>
                <button class="btn waves-effect waves-light right" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!--JQuery Library-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--JQuery Validation Plugin-->
    <script src="vendors/jquery-validation/validation.min.js" type="text/javascript"></script>
    <script src="vendors/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
    <!--Include Page Level Scripts-->
    <script src="js/pages/add-contact.js"></script>
    <!--Custom JS-->
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>