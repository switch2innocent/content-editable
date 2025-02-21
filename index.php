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
                <button type="button" id="addrow">Add Row</button>
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
                                <tr id="row" ' . $i . '>
                                    <td contenteditable class="editable-cell fname" name="fname" id="fname-' . $i . '"></td>
                                    <td contenteditable class="editable-cell lname" name="lname" id="lname-' . $i . '"></td>
                                </tr>
                            ';
                        }

                        ?>
                    </tbody>
                </table>
                <p class="text-secondary"> <span id="num_row">5</span> / <span>20 rows</span> </p>
            </div>
        </form>
        <a href="" class="p-2 w-15 border-0 bg-success text-light" id="generate" name="generate">Generate</a>
        <a href="" class="p-2 w-15 mt-5 draft bg-primary text-light">Save as draft</a>
        <a href="" class="p-2 w-15 text-light bg-danger mb-3 p-2 w-25" id="clear">Clear</a>
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
        
        //Clear editable cells
        $('#clear').on('click', function(e) {
            $('.editable-cell').text('');
        });


        //init for add rows
        var num_row = 5;
        $('#num_row').text(num_row);

        //Add rows
        $('#addrow').on('click', function () {

            num_row = num_row += 1;

            var html = `<tr class="row_add" id="row${num_row}" ${num_row}></tr>`;

            html += `
                <td contenteditable class="editable-cell fname" name="fname" id="fname-${num_row - 1}"></td>
                <td contenteditable class="editable-cell lname" name="lname" id="lname-${num_row - 1}"></td>
                <td><button class="remove btn-danger" id="remove" data-row="row${num_row}">remove</button></td>
            `;

            html += '</tr>';

            $('table tbody').append(html);
            $('#num_row').text(num_row);

            if (num_row == 20) {
                $(this).css("background-color", "red");
                $(this).attr('disabled', true);
            } else {
                $(this).attr('disabled', false);
                $('#num_row').text(num_row);
                $(this).css("background-color", "#5eb548");
            }
        });

        //Remove rows
        $(document).on('click', '.remove', function () {
            var delete_row = $(this).data('row');
            $('#' + delete_row).remove();
            num_row = num_row -= 1;
            $('#num_row').text(num_row);

            if (num_row < 20) {
                $()
            }
        });



    });
</script>

</html>