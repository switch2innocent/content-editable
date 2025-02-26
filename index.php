<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Editable DataTable</title>
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
                <table class="table table-responsive table-bordered bg-white table-hover datatable">
                    <thead>
                        <th style="display:none;">id</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="user-table-body">
                        <!-- Table rows will be populated here -->
                    </tbody>
                </table>
                <p class="text-secondary"> <span id="num_row">5</span> / <span>20 rows</span> </p>
            </div>
            <button type="submit" class="p-2 w-15 border-0 bg-success text-light" id="save" name="save">Save All</button>
            <button class="p-2 w-15 text-light bg-danger mb-3" id="clear">Clear</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            // Fetch users data from the server
            $.ajax({
                url: 'fetch_user.ctrl.php', // Fetch data from get_users.php
                type: 'GET',
                success: function(response) {
                    var users = JSON.parse(response); // Parse the response as JSON
                    var num_row = users.length; // Set the initial row count
                    $('#num_row').text(num_row); // Display the number of rows

                    // Loop through the users and populate the table
                    users.forEach(function(user, index) {
                        var rowId = index + 1; // Create unique row ID

                        // Generate the row HTML with contenteditable cells and data from the database
                        var html = `
                            <tr id="row-${rowId}">
                                <td contenteditable class="editable-cell up-id" id="up-id-${rowId}" style="display:none;">${user.id}</td>
                                <td contenteditable class="editable-cell fname" id="fname-${rowId}">${user.firstname}</td>
                                <td contenteditable class="editable-cell lname" id="lname-${rowId}">${user.lastname}</td>
                                <td>
                                    <button class="update btn-secondary" data-row="row-${rowId}">Update</button>
                                    <button class="delete btn-primary" data-row="row-${rowId}">Delete</button>
                                </td>
                            </tr>
                        `;

                        // Append the row to the table
                        $('#user-table-body').append(html);
                    });
                },
                error: function() {
                    alert("Error fetching user data.");
                }
            });

            // Clear editable cells
            $('#clear').on('click', function(e) {
                e.preventDefault();
                $('.editable').text('');
            });

            // Add row functionality
            $('#addrow').on('click', function(e) {
                e.preventDefault();

                var rowId = $('#user-table-body tr').length + 1; // Define rowId
                $('.datatable tbody').append(
                    `<tr id="row-${rowId}">
                        <td contenteditable="true" class="editable fname" id="fname-${rowId}"></td>
                        <td contenteditable="true" class="editable lname" id="lname-${rowId}"></td>
                        <td>
                            <button class="save btn-success" id="save-data">Save</button>
                            <button class="remove btn-danger" data-row="row-${rowId}">Remove</button>
                        </td>
                    </tr>`
                );



                // Get the current number of rows from the text
                // var num_row = parseInt($('#num_row').text());

                // // Make sure the total rows do not exceed 20
                // if (num_row < 20) {
                //     num_row++; // Increment the row count

                //     // Create a unique ID for the new row
                //     var rowId = 'row-' + num_row;

                //     // Generate the HTML for the new row
                //     var html = `
                //     <tr id="${rowId}">
                //         <td contenteditable class="editable-cell fname" id="fname-${num_row}"></td>
                //         <td contenteditable class="editable-cell lname" id="lname-${num_row}"></td>
                //         <td>
                //             <button class="save-row btn-success" data-row="${rowId}">Save</button>
                //             <button class="edit btn-secondary" data-row="${rowId}">Edit</button>
                //             <button class="delete btn-primary" data-row="${rowId}">Delete</button>
                //             <button class="remove btn-danger" data-row="${rowId}">Remove</button>
                //         </td>
                //     </tr>
                //     `;

                //     // Append the new row to the table
                //     $('#user-table-body').append(html);

                //     // Update the number of rows displayed
                //     $('#num_row').text(num_row);

                //     // Disable "Add Row" button if we reach 20 rows
                //     if (num_row == 20) {
                //         $('#addrow').prop('disabled', true).css("background-color", "red");
                //     }
                // }
            });


            // Remove row functionality
            $(document).on('click', '.remove', function() {
                var rowId = $(this).data('row');
                $('#' + rowId).remove();
                var num_row = parseInt($('#num_row').text());
                $('#num_row').text(num_row - 1);
            });

            // Save All Data
            $('#save').on('click', function(e) {
                e.preventDefault();
                var data = [];

                // Loop through each row and collect the data
                $('tr').each(function() {
                    var fname = $(this).find('.fname').text();
                    var lname = $(this).find('.lname').text();

                    // Only push to the data array if both firstname and lastname are not empty
                    if (fname.trim() !== "" && lname.trim() !== "") {
                        data.push({
                            firstname: fname,
                            lastname: lname
                        });
                    }
                });

                // Send the data array to the PHP script
                $.ajax({
                    type: 'POST',
                    url: 'save_users.ctrl.php',
                    data: {
                        rows: data
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert('Data saved successfully');
                            window.location.reload();
                        } else {
                            alert('Failed to save data');
                        }
                    }
                });
            });

            //Save single data
            $(document).on('click', '#save-data', function(e) {
                e.preventDefault();

                // Get the row id
                var rowId = $(this).closest('tr').attr('id');
                var fname = $('#' + rowId).find('.fname').text();
                var lname = $('#' + rowId).find('.lname').text();

                // Send the data to the server for that specific row
                $.ajax({
                    type: 'POST',
                    url: 'save_row.ctrl.php', // Create a new PHP file to handle saving individual rows
                    data: {
                        firstname: fname,
                        lastname: lname
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert('Row saved successfully');
                            window.location.reload();
                        } else {
                            alert('Failed to save the row');
                        }
                    }
                });
            });

            //Update data
            $(document).on('click', '.update', function(e) {
                e.preventDefault();
                
                var rowId = $(this).data('row'); // Define rowId
                var up_id = $('#' + rowId).find('.up-id').text();
                var fname = $('#' + rowId).find('.fname').text(); // Get the updated first name
                var lname = $('#' + rowId).find('.lname').text(); // Get the updated last name

                // Check if any data is missing
                if (!up_id || !fname || !lname) {
                    alert("Please make sure all fields are filled out.");
                    return;
                }

                // Send the data using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'update_users.ctrl.php',
                    data: {
                        id: up_id, // Send the row ID (make sure this is correct)
                        firstname: fname, // Send the first name
                        lastname: lname // Send the last name
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert('Row updated successfully');
                            window.location.reload();
                        } else {
                            alert('Failed to update the row');
                        }
                    }
                });
            });

            //Delete user
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();

                var rowId = $(this).data('row'); // Define rowId
                var up_id = $('#' + rowId).find('.up-id').text(); // Get the updated first name

                // Send the data using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'delete_users.ctrl.php',
                    data: {
                        id: up_id // Send the row ID (make sure this is correct)
                    },
                    success: function(response) {
                        if (response == 1) {
                            alert('Row deleted successfully');
                            window.location.reload();
                        } else {
                            alert('Failed to delete the row');
                        }
                    }
                });
            });


        });
    </script>

</body>

</html>