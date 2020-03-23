<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SmartShop - Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="<?php echo URLROOT; ?>/users/login" method="post">
            <div class="form-group">
            <label for="email">Email: </label>
            <input type="text" name="email" id="" class="form-control">
            </div>
            <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" name="password" id="" class="form-control">
            </div>
            <div class="row">
            <div class="col">
                <input type="submit" value="Login" class="btn btn-success btn-block">
            </div>
            <div class="col">
                <button class="btn btn-light btn-block">You don't have account?</button>
            </div>
            </div>

        </form>
        </div>
    </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SmartShop - Register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="<?php echo URLROOT; ?>/users/register" method="post">
        <div class="row">
            <div class="form-group col">
                <label for="first_name">First Name: </label>
                <input type="text" name="first_name" id="" class="form-control">
            </div>
            <div class="form-group col">
                <label for="last_name">Last Name: </label>
                <input type="text" name="last_name" id="" class="form-control">
            </div>
        </div>
        
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="text" name="email" id="" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" name="password" id="" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Confirm Password: </label>
            <input type="password" name="confirm_password" id="" class="form-control">
        </div>
        <div class="row">
            <div class="col">
            <input type="submit" value="Register" class="btn btn-primary btn-block">
            </div>
            <div class="col">
            <button class="btn btn-light btn-block">Already have an account?</button>
            </div>
        </div>

        </form>
    </div>
    </div>
</div>
</div>