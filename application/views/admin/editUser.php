<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit User ( <?php echo $user[0]["username"];?> )</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-md-4">
        <form id="validation" action="/admin/editUser/<?php echo $user[0]["id"];?>" method="post">
            <div class="form-group">
                <input class="form-control" id="username" type="text" name="username" placeholder="username" value="<?php echo $user[0]["username"];?>" />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="password" />
            </div>
            <div class="form-group">
                <select name="memberType" class="form-control">
                    <option <?php if($user[0]["memberType"]=="admin"){echo "selected";}?> value="admin">Admin</option>
                    <option <?php if($user[0]["memberType"]=="editor"){echo "selected";}?> value="editor">Editor</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="/public/validation/jquery.validate.js"></script>
<script>
    $.validator.setDefaults({
            submitHandler: function() {
                $("#validation").submit();
            }
    });
    $(document).ready(function() {
        // validate signup form on keyup and submit
        $("#validation").validate({
                rules: {
                    username: {
                            required: true,
                            minlength: 2
                    },
                    password: {
                            minlength: 5
                    }                    
                },
                messages: {
                    username: {
                            required: "Please enter username",
                            minlength: "At least 2 characters"
                    },
                    password: {
                            minlength: "At least 5 characters"
                    }                    
                }
        });
    });
</script>