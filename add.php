<?php


    include 'configs/db_conn.php';

   // if(isset($_GET['submit'])){
      //  echo $_GET['email'];
       // echo $_GET['ingredient'];
    //}

    $email = $title = $ingredient = '';
	$errors = array('email' => '', 'title' => '', 'ingredient' => '');

    if(isset($_POST['submit'])){
        //echo htmlspecialchars( $_POST['email']);
        //echo htmlspecialchars( $_POST['title']);
        //echo htmlspecialchars( $_POST['ingredient']);
        

        //check email
        if(empty($_POST['email'])){
            $errors['email'] =  'An email is requred <br>';
        }
        else
        {
            $email = $_POST['email'];
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errors['email'] =  'must be a valid eamil address';
            }
        }

        if(empty($_POST['title'])){
            $errors['title'] = 'A title is requred <br>';
        }
        else
        {
            $title = $_POST['title'];
            if (!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] =  'must be letters and spaces only <br>';
            }
        }

        // check ingredient
		if(empty($_POST['ingredient'])){
			$errors['ingredient'] = 'At least one ingredient is required <br />';
		} else{
			$ingredient = $_POST['ingredient'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredient)){
				$errors['ingredient'] = 'Ingredient must be a comma separated list';
			}
		}
        if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredient = mysqli_real_escape_string($conn, $_POST['ingredient']);

            // create sql
			$sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredient')";

            // save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

		}

    }//end of post check
?>

<html lang="en">

<?php include 'templates/header.php'?>


<section class="container grey-text">
    <h4 class="center">Add a Pizza</h4>
    <form action="add.php" method="POST" class="white">
        <label for="">Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>
        <label for="">Pizaa title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>
        <label for="">Ingredient (comma separated)</label>
        <input type="text" name="ingredient" value="<?php echo htmlspecialchars($ingredient) ?>">
        <div class="red-text"><?php echo $errors['ingredient']; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth" >
        </div>
    </form>
</section>


<?php include 'templates/footer.php'?>

    

</html>