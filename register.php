<?php include_once("header.php"); ?>

<div class="container">
    <h2 class="my-3">Register new account</h2>
    <!-- Register form -->
    <form method="POST" action="process_registration.php">
        <div class="form-group">
            <label for="accountType">Registering as a:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="accountType" id="accountBuyer" value="buyer" checked>
                <label class="form-check-label" for="accountBuyer">Buyer</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="accountType" id="accountSeller" value="seller">
                <label class="form-check-label" for="accountSeller">Seller</label>
            </div>
            <small id="accountTypeHelp" class="form-text text-muted">* Required.</small>
        </div>
        <!-- username -->
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            <small id="usernameHelp" class="form-text text-muted">* Required.</small>
        </div>
        <!-- email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            <small id="emailHelp" class="form-text text-muted">* Required.</small>
        </div>

        <!-- address -->
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
            <small id="addressHelp" class="form-text text-muted">* Required.</small>
        </div>

        <!-- phone number -->
        <!-- phone number must be exactly 10 digits  -->
        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" pattern="[0-9]{10}" title="Enter a 10-digit phone number without country code" required>
            <small id="phoneNumberHelp" class="form-text text-muted">* Required.</small>
        </div>

        <!-- password -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <small id="passwordHelp" class="form-text text-muted">* Required.</small>
        </div>

        <!-- Repeat password -->
        <div class="form-group">
            <label for="passwordConfirmation">Repeat password</label>
            <input type="password" class="form-control" id="passwordConfirmation" name="passwordConfirmation" placeholder="Enter password again" required>
            <small id="passwordConfirmationHelp" class="form-text text-muted">* Required.</small>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div class="text-center">Already have an account? <a href="" data-toggle="modal" data-target="#loginModal">Login</a></div>
</div>

<?php include_once("footer.php"); ?>
