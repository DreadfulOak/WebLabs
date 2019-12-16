<?php 
    $dbc = mysqli_connect('localhost', 'root', '', 'table1');
    session_start();
    $userID = $_SESSION['userID'];
    if(isset($_POST['upload'])){
        $file = $_FILES['photo'];

        $fileName = $_FILES['photo']['name'];
        $fileTmpName = $_FILES['photo']['tmp_name'];
        $fileSize = $_FILES['photo']['size'];
        $fileError = $_FILES['photo']['error'];
        $fileType = $_FILES['photo']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'public/images/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "UPDATE signup 
                              SET photo = '$fileDestination'
                              WHERE id = '$userID';";
                    $data = mysqli_query($dbc, $query);
                    if(mysqli_num_rows($data) == 1){
                        $field = mysqli_fetch_array($data);
                        $_SESSION['photo'] = $field['photo'];
                    }
                }
            }
        }
        echo "<script language=javascript>document.location.href='user-profile.php'</script>";
    }
?>