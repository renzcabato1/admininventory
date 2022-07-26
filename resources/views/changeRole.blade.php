<div class="modal fade" id="changerole" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="formModal">Change Role</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form method='post' action='change-role' onsubmit='show();'  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type='hidden' id='employee_id' name='employee_id'>
                <label >Name : </label> <span id="name"></span> <br>
                <label> Role : </label>
                <select name='role' name='role' id='role' class="form-control mb-2 mr-sm-2"  required>
                    <option value=''></option>
                    <option value='User'>User</option>
                    <option value='Admin'>Admin</option>
                </select>     
                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>