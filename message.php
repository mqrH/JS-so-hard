<!DOCTYPE html>
<?php
require_once('db.php');

$pdo = getPDO();


if (!empty($_GET['delete_message'])) {
    deleteMessage($pdo, $_GET['delete_message']);
}

$pdo = null;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bootstrap test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        function appendComment(name, message) {
            $("#list-of-messages").append(
                "<li class='list-group-item'><strong>" + name + "</strong>: " + message + "</li>"
            );
        }

        $(document).ready(function () {

            $.ajax({
                url: 'messagesseses.php',
                method: 'GET',
                success: function (request) {
                    if (request.data) {
                        request.data.map(function (comment) {
                            appendComment(comment.name, comment.message);
                        })
                    }
                }
            })

            $("form").submit(function (event) {
                event.preventDefault();

                let data1 = $(this).serialize();
                let data2 = {
                    name: $(this).find('input[name="name"]').val(),
                    message: $(this).find('input[name="message"]').val()
                };
                console.log('Variant 1 :' + data1);
                console.log('Variant 2 :');
                console.log(data2);

                $.ajax({
                    url: 'create-new-message.php',
                    method: 'POST',
                    data: data2,
                    success: function (request) {
                        appendComment(data2.name, data2.message);
                        $('form').trigger("reset");
                    }
                })
            })
        });

    </script>
</head>
<body>
<div class="container">

    <div class="card">
        <div class="card-header">
            Chat
        </div>
        <ul class="list-group list-group-flush" id="list-of-messages">

        </ul>
    </div>
    <br><br><br>
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputName" class="form-label">Name</label>
            <input
                    type="text"
                    class="form-control"
                    name="name"
            >
        </div>
        <hr>
        <div class="mb-3">
            <label for="exampleInputMessage" class="form-label">Message</label>
            <input
                    type="text"
                    class="form-control"
                    name="message"
            >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>