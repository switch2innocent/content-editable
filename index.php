<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Editable DataTable</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <center>
            <h1>Sample CRUD Content Editable Datatable</h1>
        </center>
        <form action="" method="POST">
            <div class="table-responsive">
                <button type="button" id="addrow" class="btn btn-primary">Add Row</button>
                <table class="table table-responsive table-bordered bg-white table-hover">
                    <thead>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            echo '
                                <tr id="row-' . $i . '">
                                    <td contenteditable class="editable-cell fname" name="fname" id="fname-' . $i . '"></td>
                                    <td contenteditable class="editable-cell lname" name="lname" id="lname-' . $i . '"></td>
                                    <td>
                                    <button class="edit btn-secondary" data-row="row-' . $i . '">Edit</button>
                                    <button class="delete btn-primary" data-row="row-' . $i . '">Delete</button>
                                    <button class="remove btn-danger" data-row="row-' . $i . '">Remove</button>
                                    </td>

                                </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
                <p class="text-secondary"> <span id="num_row">5</span> / <span>20 rows</span> </p>
            </div>
            <button type="submit" class="p-2 w-15 border-0 bg-success text-light" id="save" name="save">Save</button>
            <button class="p-2 w-15 text-light bg-danger mb-3" id="clear">Clear</button>
        </form>

    </div>

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    $(document).ready(function() {

        // Clear editable cells
        $('#clear').on('click', function(e) {
            e.preventDefault();
            $('.editable-cell').text('');
        });

        // Initialize num_row
        var num_row = 5;
        $('#num_row').text(num_row);

        // Add row functionality
        $('#addrow').on('click', function(e) {
            e.preventDefault();

            if (num_row < 20) {
                num_row++; // Increment num_row
                var rowId = 'row-' + num_row;

                var html = `
                    <tr id="${rowId}">
                        <td contenteditable class="editable-cell fname" name="fname" id="fname-${num_row}"></td>
                        <td contenteditable class="editable-cell lname" name="lname" id="lname-${num_row}"></td>
                        <td>
                        <button class="edit btn-secondary" data-row="${rowId}">Edit</button>
                        <button class="delete btn-primary" data-row="${rowId}">Delete</button>
                        <button class="remove btn-danger" data-row="${rowId}">Remove</button>
                        </td>
                    </tr>
                `;

                $('table tbody').append(html);
                $('#num_row').text(num_row);

                if (num_row === 20) {
                    $(this).prop('disabled', true).css("background-color", "red");
                } else {
                    $(this).prop('disabled', false).css("background-color", "#5eb548");
                }
            }
        });

        // Remove row functionality
        $(document).on('click', '.remove', function() {
            var rowId = $(this).data('row');
            $('#' + rowId).remove();
            num_row--; // Decrement num_row
            $('#num_row').text(num_row);

            if (num_row < 20) {
                $('#addrow').prop('disabled', false).css("background-color", "#5eb548");
            }
        });

        //Save data
        $('#save').on('click', function(e) {
            e.preventDefault();

            var fname = $('#fname').val();
            var lname = $('#lname').val();

            $.ajax({
                type: 'POST',
                url: '',
                data: {fname: fname, lname: lname},
                success: function(r) {
                    if (r > 0) {
                        alert('Success');
                    } else {
                        alert('failed');
                    }
                }
            });
        });

    });
</script>

</html>