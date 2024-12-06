<?php
$isModif = isset($_SESSION['modif']) && $_SESSION['modif'] === true;
$formAction = $isModif ? "doModif&id=" . $user->getId() : "doCreate";
$formTitle = $isModif ? "Modifier le compte de " . $user->getFirstName() . " " . $user->getLastName() : "Create an account";
$submitLabel = $isModif ? "Modif" : "Create";

$email = isset($user) ? htmlspecialchars($user->getEmail()) : '';
$lastName = isset($user) ? htmlspecialchars($user->getLastName()) : '';
$firstName = isset($user) ? htmlspecialchars($user->getFirstName()) : '';
?>

<section id="main-section">
    <div class="wrapper-50 margin-auto center">
        <h2><?php echo $formTitle; ?></h2>
        <form class="form" action="index.php?ctrl=user&action=<?php echo $formAction; ?>" method="POST">
            <input type="email" name="email" placeholder="Mail" value="<?php echo $email; ?>" required /><br>
            <input
                type="password"
                name="password"
                placeholder="Password"
                <?php echo !$isModif ? 'required' : ''; ?> /><br>
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>" required /><br>
            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>" required /><br>
            <p>
                <input type="submit" class="submit-btn" value="<?php echo $submitLabel; ?>">
            </p>
        </form>
    </div>
</section>