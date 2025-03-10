
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" class="form-control w-50" placeholder="Search for users">
            <a href="/users/create" class="btn btn-primary">+ Add New User</a>
        </div>

        <h4 class="mb-3"><i class="bi bi-person"></i>
        User List</h4>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user):
                    ?>
                    <tr>
                        <td><?= $user['first_name']?></td>
                        <td><?= $user['last_name']?></td>
                        <td><?= $user['email']?></td>
                        <td><?= $user['password']?></td>
                        <td><?= $user['role']?></td>
                        <td><?= $user['phone']?></td>
                        <td>
                        <a href="/users/delete/<?= $user['user_id']?>" class="btn btn-danger text-white">delete</i></a>
                        <a href="/users/edit/<?= $user['user_id']?>" class="btn btn-primary text-white">edit</i></a>
                        </td>
                    </tr>
                </tbody>
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>