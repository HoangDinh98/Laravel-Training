@extends ('layout.admin')

@section('content')
<h1>Posts</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Created Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (Session::has('users')) {
            foreach (Session::get('users') as $key => $values) {
                ?>
                <tr>
                    <td><?php echo ($key + 1) ?></td>
                    <td><?php echo ($values[0]) ?></td>
                    <td><?php echo ($values[1]) ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>No user</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
@endsection
