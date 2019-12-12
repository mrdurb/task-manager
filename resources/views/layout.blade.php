<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- csrf-token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- jQuery and AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>   
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- jBox -->
    <script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.0.5/dist/jBox.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.0.5/dist/jBox.all.min.css" rel="stylesheet">
    <title>Менеджер задач</title>
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs mt-5">
            <li class="nav-item">
                <a class="nav-link" href="#" id="taskTable">Задачи</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="employeeTable">Исполнители</a>
            </li>
        </ul>
        @yield('employees_table')
        @yield('tasks_table')
        @yield('editEmployee')
        @yield('editTask')
    </div>

<script>
    $(document).ready(function() {
        var cat = '{{ Request::path() }}';
        if( cat.includes('tasks'))
            $('#taskTable').addClass("active");
        else
            $('#employeeTable').addClass("active");
    });
    $('#taskTable').click(function() {
        window.location.replace("http://127.0.0.1:8000/tasks");
    });
    $('#employeeTable').click(function() {
        window.location.replace("http://127.0.0.1:8000/employees");
    });
</script>
</body>
</html>